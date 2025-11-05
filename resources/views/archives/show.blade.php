@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - {{ $archive->ref_arriv ?? 'N/A' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-card {
            border-left: 4px solid #007bff;
        }
        .section-title {
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .badge-status {
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- En-tête -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="h3 text-primary">
                        <i class="fas fa-file-alt"></i> Détails de l'Archive
                    </h1>
                    <a href="{{ route('archives.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
                
                <!-- Carte résumé -->
                <div class="card info-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Référence:</strong><br>
                                <span class="h5">{{ $archive->ref_arriv ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Date d'arrivée:</strong><br>
                                @if($archive->date_arriv)
                                    <span class="h5">{{ $archive->date_arriv->format('d/m/Y') }}</span>
                                @else
                                    <span class="text-muted">Non renseigné</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>Service envoyeur:</strong><br>
                                <span class="h5">{{ $archive->sce_envoyeur ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Action:</strong><br>
                                <span class="badge bg-primary badge-status">{{ $archive->action ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Colonne gauche -->
            <div class="col-lg-6">
                <!-- Informations de base -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-info-circle"></i> Informations de base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Constat:</div>
                            <div class="col-sm-8">{{ $archive->constat ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Resp. demande:</div>
                            <div class="col-sm-8">{{ $archive->respo_dmd ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Contact:</div>
                            <div class="col-sm-8">{{ $archive->contact ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">FKT:</div>
                            <div class="col-sm-8">{{ $archive->fkt ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date description:</div>
                            <div class="col-sm-8">
                                @if($archive->date_desc)
                                    {{ $archive->date_desc->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations géographiques -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-map-marker-alt"></i> Informations géographiques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Adresse:</div>
                            <div class="col-sm-8">{{ $archive->adresse ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Commune:</div>
                            <div class="col-sm-8">{{ $archive->commune ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Propriétaire:</div>
                            <div class="col-sm-8">{{ $archive->proprio ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Titre parcelle:</div>
                            <div class="col-sm-8">{{ $archive->titre_plle ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Parcelle:</div>
                            <div class="col-sm-8">{{ $archive->plle ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Informations techniques -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-ruler-combined"></i> Informations techniques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Imm. terrain:</div>
                            <div class="col-sm-8">{{ $archive->imm_terrain ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Catégorie zone:</div>
                            <div class="col-sm-8">{{ $archive->cat_zone ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">PU zoning:</div>
                            <div class="col-sm-8">{{ $archive->pu_zoning ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Zoning:</div>
                            <div class="col-sm-8">{{ $archive->zoning ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Surface (m²):</div>
                            <div class="col-sm-8">{{ $archive->area_m ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Surface nécessaire:</div>
                            <div class="col-sm-8">{{ $archive->area_need ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">COS:</div>
                            <div class="col-sm-8">{{ $archive->COS ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Note terrain:</div>
                            <div class="col-sm-8">{{ $archive->nota_terrain ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite -->
            <div class="col-lg-6">
                <!-- Procès-verbaux -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-file-contract"></i> Procès-verbaux
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. PV Pat 1:</div>
                            <div class="col-sm-8">{{ $archive->ref_pvPat1 ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date PV Pat 1:</div>
                            <div class="col-sm-8">
                                @if($archive->date_pvPat1)
                                    {{ $archive->date_pvPat1->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. PV Pat 2:</div>
                            <div class="col-sm-8">{{ $archive->ref_pvPat2 ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date PV Pat 2:</div>
                            <div class="col-sm-8">
                                @if($archive->date_pvPat2)
                                    {{ $archive->date_pvPat2->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. Non Resp:</div>
                            <div class="col-sm-8">{{ $archive->ref_nonResp ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date Non Resp:</div>
                            <div class="col-sm-8">
                                @if($archive->date_nonR)
                                    {{ $archive->date_nonR->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations financières -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-money-bill-wave"></i> Informations financières
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">TVU A:</div>
                            <div class="col-sm-8">{{ $archive->tvu_a ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">TVU R:</div>
                            <div class="col-sm-8">{{ $archive->tvu_r ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Valeur A:</div>
                            <div class="col-sm-8">{{ $archive->val_a ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Valeur R:</div>
                            <div class="col-sm-8">{{ $archive->val_r ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Convention:</div>
                            <div class="col-sm-8">{{ $archive->Convention ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Mode paiement:</div>
                            <div class="col-sm-8">{{ $archive->mod_paie ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Autorisations et suivi -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-tasks"></i> Autorisations et suivi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. AP:</div>
                            <div class="col-sm-8">{{ $archive->ref_AP ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date AP:</div>
                            <div class="col-sm-8">
                                @if($archive->date_AP)
                                    {{ $archive->date_AP->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. Quittance:</div>
                            <div class="col-sm-8">{{ $archive->ref_quitce ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Situation R:</div>
                            <div class="col-sm-8">{{ $archive->situ_r ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Situation A:</div>
                            <div class="col-sm-8">{{ $archive->situ_a ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Catégorie situation:</div>
                            <div class="col-sm-8">{{ $archive->cat_situ ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Observations et décisions -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-comments"></i> Observations et décisions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="info-label">Observations recommandées:</div>
                            <div class="mt-1">{{ $archive->obs_recmd ?? 'Aucune observation' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Avis définitif:</div>
                            <div class="mt-1">{{ $archive->avis_def ?? 'Aucun avis' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Date décision définitive:</div>
                            <div class="mt-1">
                                @if($archive->date_def)
                                    {{ $archive->date_def->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>    
@endsection