<?php

namespace App\Http\Controllers;

use App\Models\Archives;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    public function index()
    {
        // Récupérer TOUTES les archives sans limite
        $archives = Archives::orderBy('id', 'desc')->get();
        
        // Debug
        \Log::info("Archives récupérées: " . $archives->count());
        
        return view('archives.index', compact('archives'));
    }

    public function show($id)
    {
        $archive = Archives::findOrFail($id);
        return view('archives.show', compact('archive'));
    }

    // Autres méthodes...
}