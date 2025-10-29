<?php

namespace App\Http\Controllers;

use App\Models\ap;
use App\Models\Descentes;
use App\Models\Propriete;
use App\Models\Ft;
use Illuminate\Http\Request;
use NumberFormatter;

class ApController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            if($type ==='amande'){
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
            if($type ==='amande'){
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
        // dd($request->all());
        $zone = $request->zone;
        $destination = $request->destination;
        $sup = $request->sup_remblais;
        $commune = $request->comm_propriete;
        $t = $this->calculerTauxAp($zone, $destination, $sup, $commune, 'redevance');
        dd($this->chiffreEnLettre($t));
        if (in_array($zone, ['zc', 'zd'])) {
    // 1. AP Redevance
        Ap::create([
            'id_descent' => $request->id_descent,
            'num_ap' => $request->num_ap,
            'type' => 'redevance',
            'date_ap' => $request->date_ap,
            'sup_remblais' => $sup,
            'comm_propriete' => $commune,
            'pu' => $request->pu,
            'zone' => $zone,
            'destination' => $destination,
            'taux' => $this->calculerTauxAp($zone, $destination, $sup, $commune, 'redevance'),
            'situation' => $request->situation,
        ]);

        // 2. AP Amande zone
        Ap::create([
            'id_descent' => $request->id_descent,
            'num_ap' => $request->num_ap . '-A',
            'type' => 'a_zone',
            'date_ap' => $request->date_ap,
            'sup_remblais' => $sup,
            'comm_propriete' => $commune,
            'pu' => $request->pu,
            'zone' => $zone,
            'destination' => $destination,
            'taux' => $this->calculerTauxAp($zone, $destination, $sup, $commune, 'a_zone'),
            'situation' => $request->situation,
        ]);
    }

    if ($zone === 'zi') {
        // AP unique : Amande zone
        Ap::create([
            'id_descent' => $request->id_descent,
            'num_ap' => $request->num_ap,
            'type' => 'a_zone',
            'date_ap' => $request->date_ap,
            'sup_remblais' => $sup,
            'comm_propriete' => $commune,
            'pu' => $request->pu,
            'zone' => $zone,
            'destination' => $destination,
            'taux' => $this->calculerTauxAp($zone, $destination, $sup, $commune, 'a_zone'),
            'situation' => $request->situation,
        ]);
    }
        // return redirect()->route('descentes.show', $validated['id_descent'])->with('success', 'AP enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ap $ap)
    {
        //
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
}
