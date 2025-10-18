<?php

namespace App\Http\Controllers;

use App\Models\Ft;
use App\Models\Descentes;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class FtController extends Controller
{
    public function index()
    {
        $fts = Ft::latest()->paginate(10);
        return view('fts.index', compact('fts'));
    }

    public function createFromDescente($id)
    {
        $descente = Descentes::findOrFail($id);
        return view('fts.create', compact('descente'));
    }

    public function store(Request $request)
    {
        $descente = Descentes::findOrFail($request->id_descent);

        $validated = $request->validate([
            'id_descent' => 'required|exists:descentes,id',
            'date' => 'nullable|date',
            'heure' => 'nullable|date_format:H:i',
            'num_ft' => 'nullable|string|max:255',
            'antony_ft' => 'nullable|string|max:255',
            'pu' => 'nullable|string|max:255',
            'zone' => 'required|in:zc,zi,zd',
            'destination' => 'required|in:h,c',
            'objet_ft' => 'nullable|string',
            'nom_pers_venue' => 'nullable|string|max:255',
            'qte_pers_venue' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'cin' => 'nullable|string|max:255',
            'pieces_apporter' => 'nullable|array',
            'recommandation' => 'nullable|string',
            'pieces_complement' => 'nullable|array',
            'delais' => 'nullable|string|max:255',
            'date_rdv_ft' => 'nullable|date',
            'heure_rdv_ft' => 'nullable|date_format:H:i',
        ]);

        // Injecter les champs _desc depuis la descente
        $validated['dist_desc'] = $descente->dist;
        $validated['comm_desc'] = $descente->comm;
        $validated['fkt_desc'] = $descente->fkt;
        $validated['x_desc'] = $descente->x;
        $validated['y_desc'] = $descente->y;
        $validated['constat_desc'] = $descente->constat;

        Ft::create($validated);
        return redirect()->route('fts.index')->with('success', 'FT enregistrée avec succès.');
    }

    public function show(Ft $ft)
    {
        return view('fts.show', compact('ft'));
    }

    public function edit(Ft $ft)
    {
        return view('fts.edit', compact('ft'));
    }

    public function update(Request $request, Ft $ft)
    {
        $validated = $request->validate([
            // mêmes règles que store()
        ]);

        $ft->update($validated);
        return redirect()->route('fts.show', $ft)->with('success', 'FT mise à jour.');
    }

    public function destroy(Ft $ft)
    {
        $ft->delete();
        return redirect()->route('fts.index')->with('success', 'FT supprimée.');
    }
   
    public function exportPdf($id)
    {
        $ft = Ft::findOrFail($id);

        // Génération du PDF (exemple avec DomPDF)
        $pdf = Pdf::loadView('fts.pdf', compact('ft'))->setPaper('A4', 'portrait');
        return $pdf->download("FT_{$ft->num_ft}.pdf");
    }


}
