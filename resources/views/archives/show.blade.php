@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - {{ $archive->arrivalid ?? 'N/A' }}</title>
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
                                <span class="h5">{{ $archive->arrivalid ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Date d'arrivée:</strong><br>
                                @if($archive->arrivaldate)
                                    <span class="h5">{{ \Carbon\Carbon::parse($archive->arrivaldate)->format('d/m/Y') }}</span>
                                @else
                                    <span class="text-muted">Non renseigné</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>Service envoyeur:</strong><br>
                                <span class="h5">{{ $archive->sendersce ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Action:</strong><br>
                                <span class="badge bg-primary badge-status">{{ $archive->actiontaken ?? '-' }}</span>
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
                            <div class="col-sm-8">{{ $archive->findingof ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Demandeur:</div>
                            <div class="col-sm-8">{{ $archive->applicantname ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Adresse:</div>
                            <div class="col-sm-8">{{ $archive->applicantaddress ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Contact:</div>
                            <div class="col-sm-8">{{ $archive->applicantcontact ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date descente:</div>
                            <div class="col-sm-8">
                                @if($archive->descentdate)
                                    {{ \Carbon\Carbon::parse($archive->descentdate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date convocation:</div>
                            <div class="col-sm-8">
                                @if($archive->summondate)
                                    {{ \Carbon\Carbon::parse($archive->summondate)->format('d/m/Y') }}
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
                            <div class="col-sm-4 info-label">Localité:</div>
                            <div class="col-sm-8">{{ $archive->locality ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Commune:</div>
                            <div class="col-sm-8">{{ $archive->municipality ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Propriétaire:</div>
                            <div class="col-sm-8">{{ $archive->property0wner ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Titre parcelle:</div>
                            <div class="col-sm-8">{{ $archive->propertytitle ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Nom propriété:</div>
                            <div class="col-sm-8">{{ $archive->propertyname ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Règlement urbanisme:</div>
                            <div class="col-sm-8">{{ $archive->urbanplanningregulations ?? '-' }}</div>
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
                            <div class="col-sm-4 info-label">UPR:</div>
                            <div class="col-sm-8">{{ $archive->upr ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Zonage:</div>
                            <div class="col-sm-8">{{ $archive->zoning ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Surface (m²):</div>
                            <div class="col-sm-8">{{ $archive->surfacearea ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Surface remblayée:</div>
                            <div class="col-sm-8">{{ $archive->backfilledarea ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Coordonnée X:</div>
                            <div class="col-sm-8">{{ $archive->xv ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Coordonnée Y:</div>
                            <div class="col-sm-8">{{ $archive->yv ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite -->
            <div class="col-lg-6">
                <!-- Procès-verbaux et documents -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-file-contract"></i> Procès-verbaux et documents
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. PV:</div>
                            <div class="col-sm-8">{{ $archive->reportid ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. PV délibération:</div>
                            <div class="col-sm-8">{{ $archive->minutesid ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date PV délibération:</div>
                            <div class="col-sm-8">
                                @if($archive->minutesdate)
                                    {{ \Carbon\Carbon::parse($archive->minutesdate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Pièces fournies:</div>
                            <div class="col-sm-8">{{ $archive->partsupplied ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date soumission:</div>
                            <div class="col-sm-8">
                                @if($archive->submissiondate)
                                    {{ \Carbon\Carbon::parse($archive->submissiondate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Destination:</div>
                            <div class="col-sm-8">{{ $archive->destination ?? '-' }}</div>
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
                            <div class="col-sm-4 info-label">SVR Amende:</div>
                            <div class="col-sm-8">{{ $archive->svr_fine ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">SVR Redevance:</div>
                            <div class="col-sm-8">{{ $archive->svr_roalty ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. facturation:</div>
                            <div class="col-sm-8">{{ $archive->invoicingid ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date facturation:</div>
                            <div class="col-sm-8">
                                @if($archive->invoicingdate)
                                    {{ \Carbon\Carbon::parse($archive->invoicingdate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Montant amende:</div>
                            <div class="col-sm-8">
                                @if($archive->fineamount)
                                    {{ number_format($archive->fineamount, 2, ',', ' ') }} MGA
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Montant redevance:</div>
                            <div class="col-sm-8">
                                @if($archive->roaltyamount)
                                    {{ number_format($archive->roaltyamount, 2, ',', ' ') }} MGA
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Convention:</div>
                            <div class="col-sm-8">{{ $archive->convention ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Mode paiement:</div>
                            <div class="col-sm-8">{{ $archive->payementmethod ?? '-' }}</div>
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
                            <div class="col-sm-4 info-label">Date transmission DAF:</div>
                            <div class="col-sm-8">
                                @if($archive->daftransmissiondate)
                                    {{ \Carbon\Carbon::parse($archive->daftransmissiondate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Réf. Quitus:</div>
                            <div class="col-sm-8">{{ $archive->ref_quitus ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Situation R:</div>
                            <div class="col-sm-8">{{ $archive->sit_r ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Situation A:</div>
                            <div class="col-sm-8">{{ $archive->sit_a ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Date commission:</div>
                            <div class="col-sm-8">
                                @if($archive->commissiondate)
                                    {{ \Carbon\Carbon::parse($archive->commissiondate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 info-label">Avis commission:</div>
                            <div class="col-sm-8">{{ $archive->commissionopinion ?? '-' }}</div>
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
                            <div class="info-label">Observations recommandation:</div>
                            <div class="mt-1">{{ $archive->recommandationobs ?? 'Aucune observation' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Avis définitif:</div>
                            <div class="mt-1">{{ $archive->opfinal ?? 'Aucun avis' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Date avis définitif:</div>
                            <div class="mt-1">
                                @if($archive->opiniondfdate)
                                    {{ \Carbon\Carbon::parse($archive->opiniondfdate)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Catégorie:</div>
                            <div class="mt-1">{{ $archive->category ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-cogs"></i> Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('archives.edit', $archive->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette archive ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                            <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> Retour à la liste
                            </a>
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