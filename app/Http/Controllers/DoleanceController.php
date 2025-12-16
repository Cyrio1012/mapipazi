<?php

namespace App\Http\Controllers;

use App\Models\Doleance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoleanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Doleance::query()->with('traiteur');
        
        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filtrage par sujet
        if ($request->has('sujet')) {
            $query->where('sujet', 'like', '%' . $request->sujet . '%');
        }
        
        // Tri
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);
        
        $doleances = $query->paginate(20);
        
        return view('doleances.index', compact('doleances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
            'accept_confidentialite' => 'accepted',
        ]);

        $doleance = Doleance::create($validated);

        // Retourne toujours JSON
        return back()->with('success', '✅ Doléance enregistrée ! Nous vous répondrons bientôt.');
     

    } catch (\Exception $e) {
        return back()->withErrors(['error' => '❌ Une erreur est survenue lors de l\'enregistrement de la doléance. Veuillez réessayer.']);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Doleance $doleance)
    {
        return view('doleances.show', compact('doleance'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Doleance $doleance)
    {
        $request->validate([
            'status' => 'required|in:en_cours,traite,rejete',
            'reponse' => 'nullable|string',
        ]);

        switch ($request->status) {
            case 'en_cours':
                $doleance->marquerEnCours(Auth::id());
                $message = 'Doléance marquée comme en cours.';
                break;
            case 'traite':
                $doleance->marquerCommeTraite(Auth::id(), $request->reponse);
                $message = 'Doléance marquée comme traitée.';
                break;
            case 'rejete':
                $doleance->marquerCommeRejete(Auth::id(), $request->reponse);
                $message = 'Doléance rejetée.';
                break;
        }

        return redirect()->route('doleances.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doleance $doleance)
    {
        return view('doleances.edit', compact('doleance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doleance $doleance)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
            'reponse' => 'nullable|string',
        ]);

        $doleance->update($validated);

        return redirect()->route('doleances.index')
            ->with('success', 'Doléance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doleance $doleance)
    {
        $doleance->delete();

        return redirect()->route('doleances.index')
            ->with('success', 'Doléance supprimée avec succès.');
    }

    /**
     * Dashboard statistics for doléances.
     */
    public function dashboard()
    {
        $stats = [
            'total' => Doleance::count(),
            'nouveau' => Doleance::where('status', 'nouveau')->count(),
            'en_cours' => Doleance::where('status', 'en_cours')->count(),
            'traite' => Doleance::where('status', 'traite')->count(),
            'rejete' => Doleance::where('status', 'rejete')->count(),
        ];

        $recentes = Doleance::orderBy('created_at', 'desc')
            ->with('traiteur')
            ->limit(10)
            ->get();

        return view('doleances.dashboard', compact('stats', 'recentes'));
    }
}