<?php

namespace App\Http\Controllers;

use App\Models\Matro;
use Illuminate\Http\Request;

class MatroController extends Controller
{
        public function index()
    {
        $matros = Matro::latest()->paginate(10);
        return view('matros.index', compact('matros'));
    }

    public function create()
    {
        return view('matros.create');
    }
    public function show(Matro $matro)
    {
        return view('matros.show', compact('matro'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_descent' => 'required|integer',
            'designation' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'imm' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
        ]);

        Matro::create($validated);
        return redirect()->route('matros.index')->with('success', 'Matériel ajouté avec succès.');
    }

    public function edit(Matro $matro)
    {
        return view('matros.edit', compact('matro'));
    }

    public function update(Request $request, Matro $matro)
    {
        $validated = $request->validate([
            'id_descent' => 'required|integer',
            'designation' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'imm' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
        ]);

        $matro->update($validated);
        return redirect()->route('matros.index')->with('success', 'Matériel mis à jour.');
    }

    public function destroy(Matro $matro)
    {
        $matro->delete();
        return redirect()->route('matros.index')->with('success', 'Matériel supprimé.');
    }
}
