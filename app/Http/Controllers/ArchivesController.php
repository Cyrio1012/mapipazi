<?php

namespace App\Http\Controllers;

use App\Models\Archives;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
   public function index()
    {
        $archives = Archives::orderBy('date_arriv', 'desc')->paginate(20);
        // dd( $archives);
        return view('archives.index', compact('archives'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $archive = Archives::findOrFail($id);
        return view('archives.show', compact('archive'));
    }
}