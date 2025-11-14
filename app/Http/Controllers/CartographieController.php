<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descente;
use App\Models\Archives;
use App\Models\ap;
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
                'ap' => ap::where('id_descent', $descente->id)->first(),
                'sup_remblais' => ap::where('id_descent', $descente->id)->value('sup_remblais'),
                'date' => $descente->date,
                'heure' => $descente->heure,
                'ref_om' => $descente->ref_om,
                'ref_pv' => $descente->ref_pv,
                'ref_rapport' => $descente->ref_rapport,
                'num_pv' => $descente->num_pv,
                'ft_id' => $descente->ft_id, // AJOUT DE FT_ID
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
                'geom' => $descente->geom, // AJOUT DE GEOM
                'date_rdv_ft' => $descente->date_rdv_ft, // AJOUT DE DATE_RDV_FT
                'heure_rdv_ft' => $descente->heure_rdv_ft, // AJOUT DE HEURE_RDV_FT
                'pieces_a_fournir' => $descente->pieces_a_fournir, // AJOUT DE PIECES_A_FOURNIR
                'pieces_fournis' => $descente->pieces_fournis, // AJOUT DE PIECES_FOURNIS
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
                'surfacearea' => $this->formatSurface($archive->surfacearea),
                'backfilledarea' => $this->formatSurface($archive->backfilledarea),
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
            Log::info("  FT_ID: " . ($descente['ft_id'] ?? 'NULL'));
            Log::info("  x_laborde: " . ($descente['x_laborde'] ?? 'NULL'));
            Log::info("  y_laborde: " . ($descente['y_laborde'] ?? 'NULL'));
        }

        Log::info('=== DEBUG ARCHIVES ===');
        Log::info('Nombre total d\'archives: ' . $archives->count());
        
        foreach ($archives as $index => $archive) {
            Log::info("Archive #" . ($index + 1) . ":");
            Log::info("  ID: " . $archive['id']);
            Log::info("  Municipality: " . $archive['municipality']);
            Log::info("  Surface: " . $archive['surfacearea']);
            Log::info("  Surface remblayée: " . $archive['backfilledarea']);
            Log::info("  xv: " . ($archive['xv'] ?? 'NULL'));
            Log::info("  yv: " . ($archive['yv'] ?? 'NULL'));
        }
        
        return view('cartographie.index', compact('descentes', 'archives'));
    }

    /**
     * Fonction pour formater les surfaces
     */
    private function formatSurface($surface)
    {
        if (!$surface || $surface === 'null' || $surface === '' || $surface === 'N/A') {
            return 'Non spécifié';
        }
        
        // Si c'est un nombre, formater avec unité
        $num = floatval($surface);
        if (!is_nan($num)) {
            return number_format($num, 0, ',', ' ') . ' m²';
        }
        
        return $surface;
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
                        'ft_id' => $descente->ft_id, // AJOUT DE FT_ID
                        'date' => $descente->date,
                        'heure' => $descente->heure,
                        'adresse' => $descente->adresse,
                        'comm' => $descente->comm,
                        'contact' => $descente->contact,
                        'date_rdv_ft' => $descente->date_rdv_ft, // AJOUT DE DATE_RDV_FT
                        'heure_rdv_ft' => $descente->heure_rdv_ft, // AJOUT DE HEURE_RDV_FT
                        'equipe_formatee' => $descente->equipe_formatee, // UTILISATION DE L'ACCESSOR
                        'action_formatee' => $descente->action_formatee, // UTILISATION DE L'ACCESSOR
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
     * API pour récupérer les détails d'une descente spécifique
     */
    public function getDescenteDetails($id)
    {
        try {
            $descente = Descente::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $descente->id,
                    'date' => $descente->date,
                    'heure' => $descente->heure,
                    'ref_om' => $descente->ref_om,
                    'ref_pv' => $descente->ref_pv,
                    'ref_rapport' => $descente->ref_rapport,
                    'num_pv' => $descente->num_pv,
                    'ft_id' => $descente->ft_id, // AJOUT DE FT_ID
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
                    'x' => $descente->x,
                    'y' => $descente->y,
                    'geom' => $descente->geom,
                    'date_rdv_ft' => $descente->date_rdv_ft,
                    'heure_rdv_ft' => $descente->heure_rdv_ft,
                    'pieces_a_fournir' => $descente->pieces_a_fournir,
                    'pieces_fournis' => $descente->pieces_fournis,
                    'created_at' => $descente->created_at,
                    'updated_at' => $descente->updated_at,
                    // Accesseurs formatés
                    'equipe_formatee' => $descente->equipe_formatee,
                    'action_formatee' => $descente->action_formatee,
                    'constat_formatee' => $descente->constat_formatee,
                    'pieces_a_fournir_formatee' => $descente->pieces_a_fournir_formatee,
                    'pieces_fournis_formatee' => $descente->pieces_fournis_formatee,
                    'date_time_complete' => $descente->date_time_complete,
                    'date_time_rdv_ft_complete' => $descente->date_time_rdv_ft_complete,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Descente non trouvée: ' . $e->getMessage()
            ], 404);
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
                        'surfacearea' => $this->formatSurface($archive->surfacearea),
                        'backfilledarea' => $this->formatSurface($archive->backfilledarea),
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
                    'surfacearea' => $this->formatSurface($archive->surfacearea),
                    'backfilledarea' => $this->formatSurface($archive->backfilledarea),
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
     * Recherche avancée dans les descentes pour la cartographie
     */
    public function searchDescentes(Request $request)
    {
        try {
            $query = Descente::whereNotNull('x')
                            ->whereNotNull('y')
                            ->where('x', '!=', 0)
                            ->where('y', '!=', 0);

            // Filtre par référence
            if ($request->has('reference') && $request->reference) {
                $query->where(function ($q) use ($request) {
                    $q->where('ref_om', 'ILIKE', '%' . $request->reference . '%')
                      ->orWhere('ref_pv', 'ILIKE', '%' . $request->reference . '%')
                      ->orWhere('ft_id', 'ILIKE', '%' . $request->reference . '%') // AJOUT DE FT_ID
                      ->orWhere('num_pv', 'ILIKE', '%' . $request->reference . '%');
                });
            }

            // Filtre par commune
            if ($request->has('commune') && $request->commune) {
                $query->where('comm', 'ILIKE', '%' . $request->commune . '%');
            }

            // Filtre par date
            if ($request->has('date') && $request->date) {
                $query->whereDate('date', $request->date);
            }

            // Filtre par adresse
            if ($request->has('adresse') && $request->adresse) {
                $query->where('adresse', 'ILIKE', '%' . $request->adresse . '%');
            }

            $descentes = $query->get()->map(function ($descente) {
                return [
                    'id' => $descente->id,
                    'coordinates' => [
                        'x' => floatval($descente->x),
                        'y' => floatval($descente->y)
                    ],
                    'properties' => [
                        'ref_om' => $descente->ref_om,
                        'ref_pv' => $descente->ref_pv,
                        'ft_id' => $descente->ft_id, // AJOUT DE FT_ID
                        'date' => $descente->date,
                        'heure' => $descente->heure,
                        'adresse' => $descente->adresse,
                        'comm' => $descente->comm,
                        'contact' => $descente->contact,
                        'date_rdv_ft' => $descente->date_rdv_ft,
                        'heure_rdv_ft' => $descente->heure_rdv_ft,
                        'equipe_formatee' => $descente->equipe_formatee,
                        'action_formatee' => $descente->action_formatee,
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
                'message' => 'Erreur de recherche: ' . $e->getMessage()
            ], 500);
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
                        'surfacearea' => $this->formatSurface($archive->surfacearea),
                        'backfilledarea' => $this->formatSurface($archive->backfilledarea),
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

    /**
     * Mettre à jour les coordonnées d'une descente
     */
    public function updateDescenteCoordinates(Request $request, $id)
    {
        try {
            $request->validate([
                'x' => 'required|numeric',
                'y' => 'required|numeric'
            ]);

            $descente = Descente::findOrFail($id);
            $descente->update([
                'x' => $request->x,
                'y' => $request->y
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coordonnées de la descente mises à jour avec succès',
                'data' => [
                    'id' => $descente->id,
                    'x' => $descente->x,
                    'y' => $descente->y,
                    'ft_id' => $descente->ft_id // AJOUT DE FT_ID DANS LA RÉPONSE
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