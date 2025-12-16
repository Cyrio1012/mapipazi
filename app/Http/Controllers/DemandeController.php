<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
   public function index()
    {
        $demandes = Demande::orderBy('created_at', 'desc')->paginate(20);
        return view('demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'xv' => 'nullable|numeric',
            'yv' => 'nullable|numeric',
            'upr' => 'nullable|string|max:100',
            'sit_r' => 'nullable|string|max:100',
            'exoyear' => 'nullable|integer|digits:4',
            'opfinal' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'locality' => 'nullable|string|max:100',
            'arrivalid' => 'nullable|string|max:50|unique:demandes,arrivalid',
            'sendersce' => 'nullable|string|max:100',
            'arrivaldate' => 'nullable|date',
            'invoicingid' => 'nullable|string|max:50|unique:demandes,invoicingid',
            'surfacearea' => 'nullable|numeric|min:0',
            'municipality' => 'nullable|string|max:100',
            'propertyname' => 'nullable|string|max:200',
            'roaltyamount' => 'nullable|numeric|min:0',
            'applicantname' => 'nullable|string|max:200',
            'invoicingdate' => 'nullable|date',
            'opiniondfdate' => 'nullable|date',
            'propertyowner' => 'nullable|string|max:200',
            'propertytitle' => 'nullable|string|max:200',
            'backfilledarea' => 'nullable|numeric|min:0',
            'commissiondate' => 'nullable|date',
            'applicantaddress' => 'nullable|string',
            'commissionopinion' => 'nullable|string',
            'urbanplanningregulations' => 'nullable|string',
        ]);

        Demande::create($validated);

        return redirect()->route('demandes.index')
            ->with('success', 'Demande créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
        return view('demandes.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demande $demande)
    {
        return view('demandes.edit', compact('demande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demande $demande)
    {
        $validated = $request->validate([
            'xv' => 'nullable|numeric',
            'yv' => 'nullable|numeric',
            'upr' => 'nullable|string|max:100',
            'sit_r' => 'nullable|string|max:100',
            'exoyear' => 'nullable|integer|digits:4',
            'opfinal' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'locality' => 'nullable|string|max:100',
            'arrivalid' => 'nullable|string|max:50|unique:demandes,arrivalid,' . $demande->id,
            'sendersce' => 'nullable|string|max:100',
            'arrivaldate' => 'nullable|date',
            'invoicingid' => 'nullable|string|max:50|unique:demandes,invoicingid,' . $demande->id,
            'surfacearea' => 'nullable|numeric|min:0',
            'municipality' => 'nullable|string|max:100',
            'propertyname' => 'nullable|string|max:200',
            'roaltyamount' => 'nullable|numeric|min:0',
            'applicantname' => 'nullable|string|max:200',
            'invoicingdate' => 'nullable|date',
            'opiniondfdate' => 'nullable|date',
            'propertyowner' => 'nullable|string|max:200',
            'propertytitle' => 'nullable|string|max:200',
            'backfilledarea' => 'nullable|numeric|min:0',
            'commissiondate' => 'nullable|date',
            'applicantaddress' => 'nullable|string',
            'commissionopinion' => 'nullable|string',
            'urbanplanningregulations' => 'nullable|string',
        ]);

        $demande->update($validated);

        return redirect()->route('demandes.index')
            ->with('success', 'Demande mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        $demande->delete();

        return redirect()->route('demandes.index')
            ->with('success', 'Demande supprimée avec succès.');
    }
}
