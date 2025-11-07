<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descente;
use App\Models\Archives;
use Illuminate\Support\Facades\Log;

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
                'x_laborde' => floatval($descente->x), // CORRECTION ICI
                'y_laborde' => floatval($descente->y), // CORRECTION ICI
            ];
        });

        // Récupérer toutes les archives avec des coordonnées valides
        $archives = Archives::whereNotNull('Xv')
                           ->whereNotNull('Yv')
                           ->where('Xv', '!=', 0)
                           ->where('Yv', '!=', 0)
                           ->get()
                           ->map(function ($archive) {
            return [
                'id' => $archive->id,
                'date_arriv' => $archive->date_arriv,
                'ref_arriv' => $archive->ref_arriv,
                'sce_envoyeur' => $archive->sce_envoyeur,
                'action' => $archive->action,
                'adresse' => $archive->adresse,
                'contact' => $archive->contact,
                'fkt' => $archive->fkt,
                'commune' => $archive->commune,
                'proprio' => $archive->proprio,
                'Xv' => floatval($archive->Xv),
                'Yv' => floatval($archive->Yv),
            ];
        });

        // DEBUG: Vérifier les données
        Log::info('=== DEBUG DESCENTES ===');
        Log::info('Nombre total de descentes: ' . $descentes->count());
        
        foreach ($descentes as $index => $descente) {
            Log::info("Descente #" . ($index + 1) . ":");
            Log::info("  ID: " . $descente['id']);
            Log::info("  x_laborde: " . ($descente['x_laborde'] ?? 'NULL'));
            Log::info("  y_laborde: " . ($descente['y_laborde'] ?? 'NULL'));
        }

        Log::info('=== DEBUG ARCHIVES ===');
        Log::info('Nombre total d\'archives: ' . $archives->count());
        
        foreach ($archives as $index => $archive) {
            Log::info("Archive #" . ($index + 1) . ":");
            Log::info("  ID: " . $archive['id']);
            Log::info("  Xv: " . ($archive['Xv'] ?? 'NULL'));
            Log::info("  Yv: " . ($archive['Yv'] ?? 'NULL'));
        }

        return view('cartographie.index', compact('descentes', 'archives'));
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

    /**
     * API pour récupérer les archives en JSON
     */
    public function getArchivesJson()
    {
        try {
            $archives = Archives::whereNotNull('Xv')
                                ->whereNotNull('Yv')
                                ->where('Xv', '!=', 0)
                                ->where('Yv', '!=', 0)
                                ->get()
                                ->map(function ($archive) {
                return [
                    'id' => $archive->id,
                    'coordinates' => [
                        'x' => floatval($archive->Xv),
                        'y' => floatval($archive->Yv)
                    ],
                    'properties' => [
                        'ref_arriv' => $archive->ref_arriv,
                        'date_arriv' => $archive->date_arriv,
                        'sce_envoyeur' => $archive->sce_envoyeur,
                        'adresse' => $archive->adresse,
                        'commune' => $archive->commune
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $archives,
                'count' => $archives->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}