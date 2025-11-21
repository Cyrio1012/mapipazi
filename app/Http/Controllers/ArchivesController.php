<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Archives;
use App\Models\Descentes;
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