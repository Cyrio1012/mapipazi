<?php

namespace App\Http\Controllers;

use App\Models\ap;
use App\Models\Descentes;
use App\Models\Ft;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DescentesController extends Controller
{
    public function dashboard()
    {
        $descentes = Descentes::latest()->paginate(10);
        $fts_total = Ft::count();
        $ap_total = ap::count();
        $total = Descentes::count();
        $parMois = Descentes::selectRaw('EXTRACT(MONTH FROM date) AS mois, COUNT(*) AS total')
                ->groupByRaw('EXTRACT(MONTH FROM date)')
                ->orderByRaw('EXTRACT(MONTH FROM date)')
                ->get();
        $parAn = Descentes::selectRaw('EXTRACT(YEAR FROM date) AS annee, COUNT(*) AS total')
                ->groupByRaw('EXTRACT(YEAR FROM date)')
                ->orderByRaw('EXTRACT(YEAR FROM date)')
                ->get();
        $parComm = Descentes::select('comm')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('comm')
                ->orderByDesc('total')
                ->get();
        $totalRDV = Descentes::whereNotNull('date_rdv_ft')->count();
        $rdvEnAttente = Descentes::whereNotNull('date_rdv_ft')
                ->whereDate('date_rdv_ft', '>=', now()->toDateString())
                ->whereNull('ft_id')
                ->count();
        //dd($total, $parMois, $parAn, $parComm, $totalRDV, $rdvEnAttente);

        return view('dashboard', compact('descentes', 'total', 'parMois', 'parAn', 'parComm', 'totalRDV', 'rdvEnAttente','fts_total','ap_total'));
    }
    public function index()
    {

        $descentes = Descentes::latest()->paginate(10);
        return view('descentes.index', compact('descentes'));
    }

    public function create()
    {
        $pvOptions = ['pat' => 'Pat', 'fifafi' => 'FiFaFi'];
        $equipeOptions = ['Brigade Specialisé', 'PAT', 'APIPA'];
        $actionOptions = ['Depôt Convocation(PV)', 'Depôt AIT', 'Non respect','Immobilisation MR'];
        $constatOptions = ['Ri','rir','Crir','NR AIT','cellage'];
        $piecesOption = ['CSJ','Plan topo(Scr labord)','delimitation surface terrain remblayée','PU(srat,dlat) avec allignement','Procuration','Acte de vente','PC','PR', 'Autorisation exeptionnelle de circulé'];
        $locations = DB::table('fokontany')->select('fkt', 'firaisana', 'distrika')->get();
        return view('descentes.create', compact('locations','equipeOptions', 'actionOptions', 'constatOptions', 'pvOptions' , 'piecesOption'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'nullable|date',
            'heure' => 'nullable|date_format:H:i',

            'ref_om' => 'string|max:255',
            'ref_pv' => 'nullable|in:pat,fifafi',
            'ref_rapport' => 'nullable|string|max:255',
            'num_pv' => 'string|max:255',

            'equipe' => 'nullable|array',
            'action' => 'nullable|array',
            'constat' => 'nullable|array',

            'pers_verb' => 'string|max:255',
            'qte_pers' => 'nullable|string|max:255',

            'adresse' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',

            'dist' => 'nullable|string|max:255',
            'comm' => 'nullable|string|max:255',
            'fkt' => 'nullable|string|max:255',
            'x'=> 'nullable|numeric',
            'y' => 'nullable|numeric',
            'geom' => 'nullable|json',
            'date_rdv_ft' => 'date',
            'heure_rdv_ft' => 'date_format:H:i',

            'pieces_a_fournir' => 'nullable|array',
        ]);
        Descentes::create($validated);
        return redirect()->route('descentes.index')->with('success', 'Descente créée avec succès.');
    }

    public function show(Descentes $descente)
    {
        $fts = FT::where('id_descent', $descente->id)->get();
        $info_ft = FT::where('id_descent', $descente->id)->latest()->first();
        $info_ap = ap::where('id_descent', $descente->id)->get();
        // dd($info_ap);
        return view('descentes.show', compact('descente','fts','info_ft','info_ap'));
    }

    public function edit(Descentes $descente)
    {
        return view('descentes.edit', compact('descente'));
    }

    public function update(Request $request, Descentes $descente)
    {
        $validated = $request->validate([
            'date' => 'nullable|date',
            'heure' => 'nullable|date_format:H:i',

            'ref_om' => 'nullable|string|max:255',
            'ref_pv' => 'nullable|in:pat,fifafi',
            'ref_rapport' => 'nullable|string|max:255',
            'num_pv' => 'nullable|string|max:255',

            'equipe' => 'nullable|array',
            'action' => 'nullable|array',
            'constat' => 'nullable|array',

            'pers_verb' => 'nullable|string|max:255',
            'qte_pers' => 'nullable|string|max:255',

            'adresse' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',

            'dist' => 'nullable|string|max:255',
            'comm' => 'nullable|string|max:255',
            'fkt' => 'nullable|string|max:255',

        
            'date_rdv_ft' => 'nullable|date',
            'heure_rdv_ft' => 'nullable|date_format:H:i',

            'pieces_a_fournir' => 'nullable|array',
        ]);

        $descente->update($validated);
        return redirect()->route('descentes.index')->with('success', 'Descentes mise à jour.');
    }

    public function destroy(Descentes $descente)
    {
        $descente->delete();
        return redirect()->route('descentes.index')->with('success', 'Descentes supprimée.');
    }

    public function rdv()
    {
        $rdvEnAttente = Descentes::whereNotNull('date_rdv_ft')
                ->whereDate('date_rdv_ft', '>=', now()->toDateString())
                ->whereNull('ft_id')
                ->paginate(10);
        $rdvFait = Descentes::whereNotNull('date_rdv_ft')
                ->whereNotNull('ft_id')
                ->paginate(10);
        $rdvRate= Descentes::whereNotNull('date_rdv_ft')
                ->whereDate('date_rdv_ft', '<', now()->toDateString())
                ->whereNull('ft_id')
                ->paginate(10);
        // dd($rdvEnAttente,$rdvFait,$rdvRate);
        return view('descentes.rdv', compact('rdvEnAttente','rdvFait','rdvRate'));;
    }  
    public function archive()  {
        return view ('descentes.archive');
    }
    public function comparution(Request $request,$descente){
        $validated = $request->validate([
            'date_rdv_ft' => 'nullable|date',
            'heure_rdv_ft' => 'nullable|date_format:H:i',
        ]);

        $descente->update($validated);
        return view ('descentes.rdv');
    }
}
