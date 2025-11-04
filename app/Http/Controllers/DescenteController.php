<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DescenteController extends Controller
{
	// Récupère la liste des descentes, filtre optionnel sur 'q' (coordonnées / geom)
	public function index(Request $request)
	{
		$query = DB::table('descentes');

		if ($request->filled('q')) {
			$q = $request->q;
			$query->where(function ($sub) use ($q) {
				$sub->where('x', 'like', "%{$q}%")
					->orWhere('y', 'like', "%{$q}%")
					->orWhere('geom', 'like', "%{$q}%")
					->orWhere('adresse', 'like', "%{$q}%");
			});
		}

		$descentes = $query->orderBy('date', 'desc')->get();

		return view('descentes.index', compact('descentes', 'request'));
	}
}
