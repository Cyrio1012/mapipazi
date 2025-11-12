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
                'x_laborde' => floatval($descente->x),
                'y_laborde' => floatval($descente->y),
            ];
        });

        // Récupérer toutes les archives avec des coordonnées valides (NOUVELLE STRUCTURE)
        $archives = Archives::withValidCoordinates()
                           ->get()
                           ->map(function ($archive) {
            return [
                'id' => $archive->id,
                'exoyear' => $archive->exoyear,
                'arrivaldate' => $archive->arrivaldate,
                'arrivalid' => $archive->arrivalid,
                'sendersce' => $archive->sendersce,
                'descentdate' => $archive->descentdate,
                'reportid' => $archive->reportid,
                'summondate' => $archive->summondate,
                'actiontaken' => $archive->actiontaken,
                'measures' => $archive->measures,
                'findingof' => $archive->findingof,
                'applicantname' => $archive->applicantname,
                'applicantaddress' => $archive->applicantaddress,
                'applicantcontact' => $archive->applicantcontact,
                'locality' => $archive->locality,
                'municipality' => $archive->municipality,
                'property0wner' => $archive->property0wner,
                'propertytitle' => $archive->propertytitle,
                'propertyname' => $archive->propertyname,
                'urbanplanningregulations' => $archive->urbanplanningregulations,
                'upr' => $archive->upr,
                'zoning' => $archive->zoning,
                'surfacearea' => $archive->surfacearea,
                'backfilledarea' => $archive->backfilledarea,
                'xv' => floatval($archive->xv),
                'yv' => floatval($archive->yv),
                'minutesid' => $archive->minutesid,
                'minutesdate' => $archive->minutesdate,
                'partsupplied' => $archive->partsupplied,
                'submissiondate' => $archive->submissiondate,
                'destination' => $archive->destination,
                'svr_fine' => $archive->svr_fine,
                'svr_roalty' => $archive->svr_roalty,
                'invoicingid' => $archive->invoicingid,
                'invoicingdate' => $archive->invoicingdate,
                'fineamount' => $archive->fineamount,
                'roaltyamount' => $archive->roaltyamount,
                'convention' => $archive->convention,
                'payementmethod' => $archive->payementmethod,
                'daftransmissiondate' => $archive->daftransmissiondate,
                'ref_quitus' => $archive->ref_quitus,
                'sit_r' => $archive->sit_r,
                'sit_a' => $archive->sit_a,
                'commissiondate' => $archive->commissiondate,
                'commissionopinion' => $archive->commissionopinion,
                'recommandationobs' => $archive->recommandationobs,
                'opfinal' => $archive->opfinal,
                'opiniondfdate' => $archive->opiniondfdate,
                'category' => $archive->category,
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
            Log::info("  Municipality: " . $archive['municipality']);
            Log::info("  xv: " . ($archive['xv'] ?? 'NULL'));
            Log::info("  yv: " . ($archive['yv'] ?? 'NULL'));
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
     * API pour récupérer les archives en JSON (NOUVELLE STRUCTURE)
     */
    public function getArchivesJson()
    {
        try {
            $archives = Archives::withValidCoordinates()
                                ->get()
                                ->map(function ($archive) {
                return [
                    'id' => $archive->id,
                    'coordinates' => [
                        'x' => floatval($archive->xv),
                        'y' => floatval($archive->yv)
                    ],
                    'properties' => [
                        'exoyear' => $archive->exoyear,
                        'arrivalid' => $archive->arrivalid,
                        'arrivaldate' => $archive->arrivaldate,
                        'sendersce' => $archive->sendersce,
                        'applicantname' => $archive->applicantname,
                        'applicantaddress' => $archive->applicantaddress,
                        'locality' => $archive->locality,
                        'municipality' => $archive->municipality,
                        'property0wner' => $archive->property0wner,
                        'findingof' => $archive->findingof,
                        'zoning' => $archive->zoning,
                        'surfacearea' => $archive->surfacearea,
                        'opfinal' => $archive->opfinal,
                        'fineamount' => $archive->fineamount,
                        'roaltyamount' => $archive->roaltyamount
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

    /**
     * API pour récupérer les détails d'une archive spécifique (NOUVELLE STRUCTURE)
     */
    public function getArchiveDetails($id)
    {
        try {
            $archive = Archives::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $archive->id,
                    'exoyear' => $archive->exoyear,
                    'arrivaldate' => $archive->arrivaldate,
                    'arrivalid' => $archive->arrivalid,
                    'sendersce' => $archive->sendersce,
                    'descentdate' => $archive->descentdate,
                    'reportid' => $archive->reportid,
                    'summondate' => $archive->summondate,
                    'actiontaken' => $archive->actiontaken,
                    'measures' => $archive->measures,
                    'findingof' => $archive->findingof,
                    'applicantname' => $archive->applicantname,
                    'applicantaddress' => $archive->applicantaddress,
                    'applicantcontact' => $archive->applicantcontact,
                    'locality' => $archive->locality,
                    'municipality' => $archive->municipality,
                    'property0wner' => $archive->property0wner,
                    'propertytitle' => $archive->propertytitle,
                    'propertyname' => $archive->propertyname,
                    'urbanplanningregulations' => $archive->urbanplanningregulations,
                    'upr' => $archive->upr,
                    'zoning' => $archive->zoning,
                    'surfacearea' => $archive->surfacearea,
                    'backfilledarea' => $archive->backfilledarea,
                    'xv' => $archive->xv,
                    'yv' => $archive->yv,
                    'minutesid' => $archive->minutesid,
                    'minutesdate' => $archive->minutesdate,
                    'partsupplied' => $archive->partsupplied,
                    'submissiondate' => $archive->submissiondate,
                    'destination' => $archive->destination,
                    'svr_fine' => $archive->svr_fine,
                    'svr_roalty' => $archive->svr_roalty,
                    'invoicingid' => $archive->invoicingid,
                    'invoicingdate' => $archive->invoicingdate,
                    'fineamount' => $archive->fineamount,
                    'roaltyamount' => $archive->roaltyamount,
                    'convention' => $archive->convention,
                    'payementmethod' => $archive->payementmethod,
                    'daftransmissiondate' => $archive->daftransmissiondate,
                    'ref_quitus' => $archive->ref_quitus,
                    'sit_r' => $archive->sit_r,
                    'sit_a' => $archive->sit_a,
                    'commissiondate' => $archive->commissiondate,
                    'commissionopinion' => $archive->commissionopinion,
                    'recommandationobs' => $archive->recommandationobs,
                    'opfinal' => $archive->opfinal,
                    'opiniondfdate' => $archive->opiniondfdate,
                    'category' => $archive->category,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Archive non trouvée: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Recherche avancée dans les archives pour la cartographie (NOUVELLE STRUCTURE)
     */
    public function searchArchives(Request $request)
    {
        try {
            $query = Archives::withValidCoordinates();

            // Filtre par municipalité
            if ($request->has('municipality') && $request->municipality) {
                $query->where('municipality', 'ILIKE', '%' . $request->municipality . '%');
            }

            // Filtre par année d'exercice
            if ($request->has('exoyear') && $request->exoyear) {
                $query->where('exoyear', $request->exoyear);
            }

            // Filtre par nom du demandeur
            if ($request->has('applicantname') && $request->applicantname) {
                $query->where('applicantname', 'ILIKE', '%' . $request->applicantname . '%');
            }

            // Filtre par propriétaire
            if ($request->has('property0wner') && $request->property0wner) {
                $query->where('property0wner', 'ILIKE', '%' . $request->property0wner . '%');
            }

            // Filtre par avis définitif
            if ($request->has('opfinal') && $request->opfinal) {
                $query->where('opfinal', 'ILIKE', '%' . $request->opfinal . '%');
            }

            // Filtre par zonage
            if ($request->has('zoning') && $request->zoning) {
                $query->where('zoning', 'ILIKE', '%' . $request->zoning . '%');
            }

            // Filtre par localité
            if ($request->has('locality') && $request->locality) {
                $query->where('locality', 'ILIKE', '%' . $request->locality . '%');
            }

            $archives = $query->get()->map(function ($archive) {
                return [
                    'id' => $archive->id,
                    'coordinates' => [
                        'x' => floatval($archive->xv),
                        'y' => floatval($archive->yv)
                    ],
                    'properties' => [
                        'exoyear' => $archive->exoyear,
                        'arrivalid' => $archive->arrivalid,
                        'arrivaldate' => $archive->arrivaldate,
                        'municipality' => $archive->municipality,
                        'property0wner' => $archive->property0wner,
                        'applicantname' => $archive->applicantname,
                        'zoning' => $archive->zoning,
                        'surfacearea' => $archive->surfacearea,
                        'opfinal' => $archive->opfinal,
                        'fineamount' => $archive->fineamount,
                        'roaltyamount' => $archive->roaltyamount,
                        'locality' => $archive->locality
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
                'message' => 'Erreur de recherche: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les statistiques pour la cartographie
     */
    public function getMapStatistics()
    {
        try {
            $totalArchives = Archives::withValidCoordinates()->count();
            $totalDescentes = Descente::whereNotNull('x')
                                    ->whereNotNull('y')
                                    ->where('x', '!=', 0)
                                    ->where('y', '!=', 0)
                                    ->count();

            // Statistiques par municipalité
            $municipalityStats = Archives::withValidCoordinates()
                ->select('municipality', \DB::raw('COUNT(*) as count'))
                ->whereNotNull('municipality')
                ->groupBy('municipality')
                ->orderBy('count', 'desc')
                ->get();

            // Statistiques par année
            $yearStats = Archives::withValidCoordinates()
                ->select('exoyear', \DB::raw('COUNT(*) as count'))
                ->whereNotNull('exoyear')
                ->groupBy('exoyear')
                ->orderBy('exoyear', 'desc')
                ->get();

            // Statistiques par type d'avis
            $opinionStats = Archives::withValidCoordinates()
                ->select('opfinal', \DB::raw('COUNT(*) as count'))
                ->whereNotNull('opfinal')
                ->groupBy('opfinal')
                ->orderBy('count', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_archives' => $totalArchives,
                    'total_descentes' => $totalDescentes,
                    'municipality_stats' => $municipalityStats,
                    'year_stats' => $yearStats,
                    'opinion_stats' => $opinionStats
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour les coordonnées d'une archive
     */
    public function updateArchiveCoordinates(Request $request, $id)
    {
        try {
            $request->validate([
                'xv' => 'required|numeric',
                'yv' => 'required|numeric'
            ]);

            $archive = Archives::findOrFail($id);
            $archive->update([
                'xv' => $request->xv,
                'yv' => $request->yv
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coordonnées mises à jour avec succès',
                'data' => [
                    'id' => $archive->id,
                    'xv' => $archive->xv,
                    'yv' => $archive->yv
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des coordonnées: ' . $e->getMessage()
            ], 500);
        }
    }
}