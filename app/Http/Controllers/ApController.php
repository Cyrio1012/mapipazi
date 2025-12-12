<?php

namespace App\Http\Controllers;

use App\Models\ap;
use App\Models\Descentes;
use App\Models\Propriete;
use App\Models\Ft;
use Illuminate\Http\Request;
use NumberFormatter;
use Barryvdh\DomPDF\Facade\Pdf;

class ApController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aps = Ap::with('descente')->latest()->paginate(10); // pagination facultative

        return view('aps.index', compact('aps'));
    }
    public function etablir_ap($id_descente, Request $request)
    {
        $descente = Descentes::findOrFail($id_descente);
        $fts = Ft::where('id_descent', $id_descente)->latest()->first();
        $proprietes = Propriete::where('id_descent', $id_descente)->latest()->first();
        $taux= $this->calculerTauxAp($proprietes->zone, $proprietes->destination, $proprietes->sup_remblais, $proprietes->comm_desc, 'redevance');
        $taux_lettre= $this->chiffreEnLettre($taux);
        $type = $request->type_ap;
        $base = $this->calculerBase($proprietes->zone, $proprietes->destination, $proprietes->sup_remblais, $proprietes->comm_desc, 'redevance');;
        // dd($descente, $fts, $proprietes, $taux ,$taux_lettre, $request->all());
        return view('aps.create', compact('descente','fts' ,'proprietes','taux_lettre','taux','type','base'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create_ap($id_descente)
    {
        $descente = Descentes::findOrFail($id_descente);
        return view('aps.create', compact('descente'));
    }


    private function calculerTauxAp($zone, $destination, $sup, $commune, $type = 'redevance')
    {
        $commune = strtolower(trim($commune));
        $isCUA = $commune === 'cua';
        $isPeripherie = !$isCUA;

        $base = 0;

            if ($sup < 100) {
                $base = 6250;
            } elseif ($destination === 'h' && 100< $sup ) {
                $base = 12500;
            } elseif ($destination === 'c' && $sup < 2000) {
                $base = 18750;
            } else {
                $base = 25000;
            }
            if ($isPeripherie) {
                    $base = $base/2;
            }else {
                $base = $base;
            }
            if($type ==='amende'){
                if ($isCUA) {
                    $base *= 2;
                }else {
                    $base = $base;
                }
            }
        return $sup * $base;;
    }
    private function calculerBase($zone, $destination, $sup, $commune, $type = 'redevance')
    {
        $commune = strtolower(trim($commune));
        $isCUA = $commune === 'cua';
        $isPeripherie = !$isCUA;

        $base = 0;

            if ($sup < 100) {
                $base = 6250;
            } elseif ($destination === 'h' && 100< $sup ) {
                $base = 12500;
            } elseif ($destination === 'c' && $sup < 2000) {
                $base = 18750;
            } else {
                $base = 25000;
            }
            if ($isPeripherie) {
                    $base = $base/2;
            }else {
                $base = $base;
            }
            if($type ==='amende'){
                if ($isCUA) {
                    $base *= 2;
                }else {
                    $base = $base;
                }
            }
        return $base;
    }

    function chiffreEnLettre($nombre) { $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT); return ucfirst($f->format($nombre)) . ' Ariary'; }

    public function store(Request $request)
    {   
        $validated = $request->validate([
        'id_descent' => 'required|exists:descentes,id',
        'num_ap' => 'nullable|string',
        'nom_proprietaire' => 'nullable|string',
        'type' => 'nullable|string',
        'date_ap' => 'nullable|date',
        'sup_remblais' => 'nullable|numeric',
        'comm_propriete' => 'nullable|string',
        'x' => 'nullable|string',
        'y' => 'nullable|string',
        'fkt' => 'nullable|string',
        'zone' => 'required|in:zc,zi,zd',
        'titre' => 'nullable|string',
        'destination' => 'required|in:h,c',
        'taux' => 'nullable|integer',
        'taux_payer' => 'nullable|integer',
        'notifier' => 'nullable|date',
        'delais_md' => 'nullable|integer',
        'situation' => 'nullable|string',
    ]);

        $ap = Ap::create($validated);

        return redirect()->route('aps.index')->with('success', '✅ AP enregistrée avec succès.');
        // return redirect()->route('descentes.show', $validated['id_descent'])->with('success', 'AP enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ap $ap)
    {
        // $ap = Ap::with('descente')->findOrFail($ap);

        return view('aps.show', compact('ap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ap $ap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ap $ap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ap $ap)
    {
        //
    }
    public function export($id)
    {
        $ap = Ap::findOrFail($id);
        $taux_lettre= $this->chiffreEnLettre($ap->taux);
        $type = $ap->type;
        $base = $this->calculerBase($ap->zone, $ap->destination, $ap->sup_remblais, $ap->comm_propriete, $ap->type);;

        $pdf = Pdf::loadView('aps.pdf', compact('ap','taux_lettre','type','base'))->setPaper('A4', 'portrait');
        // return $pdf->download('ap_'.$ap->id.'.pdf');
        return view('aps.pdf', compact('ap','taux_lettre','type','base'));
    }
}
