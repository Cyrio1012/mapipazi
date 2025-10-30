<?php

namespace App\Http\Controllers;

use App\Models\Descentes;
use App\Models\Ft;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DescentesController extends Controller
{
    public function dashboard()
    {
        $descentes = Descentes::latest()->paginate(10);
        return view('dashboard', compact('descentes'));
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

            'x'=> 'nullable|numeric',

            'y' => 'nullable|numeric',

            'date_rdv_ft' => 'nullable|date',
            'heure_rdv_ft' => 'nullable|date_format:H:i',

            'pieces_a_fournir' => 'nullable|array',
        ]);

        Descentes::create($validated);
        return redirect()->route('descentes.index')->with('success', 'Descente créée avec succès.');
    }

    public function show(Descentes $descente)
    {
        $fts = FT::where('id_descent', $descente->id)->get();
        $info_ft = FT::where('id_descent', $descente->id)->latest()->first();
        // dd($info_ft);
        return view('descentes.show', compact('descente','fts','info_ft'));
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
}
