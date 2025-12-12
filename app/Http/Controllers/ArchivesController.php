<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Archives;
use App\Models\Descentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ArchivesController extends Controller
{
    public function index()
    {
        // Récupérer TOUTES les archives sans limite
        $archives = Archives::orderBy('id', 'desc')->get();
    
        
        return view('archives.index', compact('archives'));
    }

    public function show($id)
    {
        $archive = Archives::findOrFail($id);
        return view('archives.show', compact('archive'));
    }
    public function edit($id)
    {
        $archive = Archives::findOrFail($id);
        return view('archives.edit', compact('archive'));
    }



    public function update(Request $request, $id)
    {
        $archive = Archives::findOrFail($id);
        dd( $archive, $request->all());
        $validator = $this->validateArchive($request, $archive->id);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $archive->update($request->all());
            
            DB::commit();
            
            return redirect()->route('archives.show', $archive->id)
                ->with('success', 'Archive mise à jour avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Validation
    private function validateArchive(Request $request, $id = null)
    {
        $rules = [
            'exoyear' => 'nullable|integer|min:2000|max:2030',
            'arrivaldate' => 'nullable|date',
            'arrivalid' => 'nullable|string|max:50|unique:archives,arrivalid,' . $id,
            'sendersce' => 'nullable|string|max:100',
            'actiontaken' => 'nullable|string|max:100',
            'applicantname' => 'nullable|string|max:200',
            'municipality' => 'nullable|string|max:100',
            'property0wner' => 'nullable|string|max:200',
            
            // Autres champs optionnels
            'descentdate' => 'nullable|date',
            'reportid' => 'nullable|string|max:50',
            'summondate' => 'nullable|date',
            'measures' => 'nullable|string',
            'findingof' => 'nullable|string',
            'applicantaddress' => 'nullable|string',
            'applicantcontact' => 'nullable|string|max:50',
            'locality' => 'nullable|string|max:100',
            'propertytitle' => 'nullable|string|max:200',
            'propertyname' => 'nullable|string|max:200',
            'urbanplanningregulations' => 'nullable|string|max:200',
            'upr' => 'nullable|string|max:50',
            'zoning' => 'nullable|string|max:50',
            'surfacearea' => 'nullable|numeric|min:0',
            'backfilledarea' => 'nullable|numeric|min:0',
            'xv' => 'nullable|numeric',
            'yv' => 'nullable|numeric',
            'minutesid' => 'nullable|string|max:50',
            'minutesdate' => 'nullable|date',
            'partsupplied' => 'nullable|string|max:100',
            'submissiondate' => 'nullable|date',
            'destination' => 'nullable|string|max:50',
            'svr_fine' => 'nullable|numeric|min:0',
            'svr_roalty' => 'nullable|numeric|min:0',
            'invoicingid' => 'nullable|string|max:50',
            'invoicingdate' => 'nullable|date',
            'fineamount' => 'nullable|numeric|min:0',
            'roaltyamount' => 'nullable|numeric|min:0',
            'convention' => 'nullable|string|max:100',
            'payementmethod' => 'nullable|string|max:50',
            'daftransmissiondate' => 'nullable|date',
            'ref_quitus' => 'nullable|string|max:50',
            'sit_r' => 'nullable|string|max:20',
            'sit_a' => 'nullable|string|max:20',
            'commissiondate' => 'nullable|date',
            'commissionopinion' => 'nullable|string',
            'recommandationobs' => 'nullable|string',
            'opfinal' => 'nullable|string|max:50',
            'opiniondfdate' => 'nullable|date',
            'category' => 'nullable|string|max:50',
        ];

        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'date' => 'Le champ :attribute doit être une date valide.',
            'numeric' => 'Le champ :attribute doit être un nombre.',
            'min' => 'Le champ :attribute doit être au moins :min.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'unique' => 'Cette référence d\'arrivée existe déjà.',
            'integer' => 'L\'année d\'exercice doit être un nombre entier.',
        ];

        $attributes = [
            'exoyear' => 'année d\'exercice',
            'arrivaldate' => 'date d\'arrivée',
            'arrivalid' => 'référence d\'arrivée',
            'sendersce' => 'service émetteur',
            'actiontaken' => 'mesure prise',
            'applicantname' => 'nom du demandeur',
            'municipality' => 'commune',
            'property0wner' => 'propriétaire',
            'propertytitle' => 'titre de propriété',
            'propertyname' => 'nom de la propriété',
            'surfacearea' => 'surface',
            'backfilledarea' => 'zone remblayée',
            'fineamount' => 'montant amende',
            'roaltyamount' => 'montant redevance',
            'payementmethod' => 'mode de paiement',
            'ref_quitus' => 'référence quitus',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function dashboard()
    {
        
        $stats = [
            'total' => Archives::count(),
            'by_exoyear' => Archives::groupBy('exoyear')->select('exoyear', DB::raw('COUNT(*) as count'))->get(),
            'by_locality' => Archives::groupBy('locality')->select('locality', DB::raw('COUNT(*) as count'))->get(),
            'by_upr' => Archives::groupBy('upr')->select('upr', DB::raw('COUNT(*) as count'))->get(),
            'by_zoning' => Archives::groupBy('zoning')->select('zoning', DB::raw('COUNT(*) as count'))->get(),
            'by_destination' => Archives::groupBy('destination')->select('destination', DB::raw('COUNT(*) as count'))->get(),
            'by_category' => Archives::groupBy('category')->select('category', DB::raw('COUNT(*) as count'))->get(),
            'by_opfinal' => Archives::groupBy('opfinal')->select('opfinal', DB::raw('COUNT(*) as count'))->get(),
        ];
        //dd($stats['by_category']);
        return view('dashboardArchive', compact('stats'));
    }
}