<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descente;

class CartographieController extends Controller
{
    public function index()
    {
        // Récupérer toutes les descentes avec des coordonnées valides
        $descentes = Descente::whereNotNull('x')
                            ->whereNotNull('y')
                            ->where('x', '!=', 0)
                            ->where('y', '!=', 0)
                            ->get()
                            ->map(function ($descente) {
            return [
                'id' => $descente->id,
                'date' => $descente->date,
                'heure' => $descente->heure,
                'ref_om' => $descente->ref_om,
                'ref_pv' => $descente->ref_pv,
                'ref_rapport' => $descente->ref_rapport,
                'num_pv' => $descente->num_pv,
                'equipe' => $descente->equipe,
                'action' => $descente->action,
                'constat' => $descente->constat,
                'pers_verb' => $descente->pers_verb,
                'qte_pers' => $descente->qte_pers,
                'adresse' => $descente->adresse,
                'contact' => $descente->contact,
                'dist' => $descente->dist,
                'comm' => $descente->comm,
                'fkt' => $descente->fkt,
                'x_laborde' => floatval($descente->x),
                'y_laborde' => floatval($descente->y),
            ];
        });

        return view('cartographie.index', compact('descentes'));
    }

    /**
     * API pour récupérer les descentes en JSON
     */
    public function getDescentesJson()
    {
        try {
            $descentes = Descente::whereNotNull('x')
                                ->whereNotNull('y')
                                ->where('x', '!=', 0)
                                ->where('y', '!=', 0)
                                ->get()
                                ->map(function ($descente) {
                return [
                    'id' => $descente->id,
                    'coordinates' => [
                        'x' => floatval($descente->x),
                        'y' => floatval($descente->y)
                    ],
                    'properties' => [
                        'ref_om' => $descente->ref_om,
                        'ref_pv' => $descente->ref_pv,
                        'date' => $descente->date,
                        'adresse' => $descente->adresse,
                        'comm' => $descente->comm
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $descentes,
                'count' => $descentes->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}