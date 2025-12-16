@extends('layouts.app')

@section('title', 'Détails de la Demande')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Détails de la Demande</h1>
        <div class="btn-group">
            <a href="{{ route('demandes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <a href="{{ route('demandes.edit', $demande) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Référence Arrivée</label>
                            <p class="fw-bold">{{ $demande->arrivalid ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Référence Facturation</label>
                            <p class="fw-bold">{{ $demande->invoicingid ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Demandeur</label>
                            <p class="fw-bold">{{ $demande->applicantname ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Propriétaire</label>
                            <p class="fw-bold">{{ $demande->propertyowner ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Nom de la Propriété</label>
                            <p class="fw-bold">{{ $demande->propertyname ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Titre de Propriété</label>
                            <p class="fw-bold">{{ $demande->propertytitle ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Adresse du Demandeur</label>
                            <p class="fw-bold">{{ $demande->applicantaddress ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Localité</label>
                            <p class="fw-bold">{{ $demande->locality ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Commune</label>
                            <p class="fw-bold">{{ $demande->municipality ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">UPR</label>
                            <p class="fw-bold">{{ $demande->upr ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">SIT_R</label>
                            <p class="fw-bold">{{ $demande->sit_r ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Catégorie</label>
                            <p class="fw-bold">{{ $demande->category ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">OP Final</label>
                            <p class="fw-bold">{{ $demande->opfinal ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Service Expéditeur</label>
                            <p class="fw-bold">{{ $demande->sendersce ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Coordonnées & Surfaces</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Coordonnées X</label>
                        <p class="fw-bold">{{ $demande->xv ? number_format($demande->xv, 4) : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Coordonnées Y</label>
                        <p class="fw-bold">{{ $demande->yv ? number_format($demande->yv, 4) : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Surface Totale (m²)</label>
                        <p class="fw-bold">{{ $demande->surfacearea ? number_format($demande->surfacearea, 2) : '0.00' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Surface Remblayée (m²)</label>
                        <p class="fw-bold">{{ $demande->backfilledarea ? number_format($demande->backfilledarea, 2) : '0.00' }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Dates & Montants</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Date Arrivée</label>
                        <p class="fw-bold">{{ $demande->arrivaldate ? $demande->arrivaldate->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Date Facturation</label>
                        <p class="fw-bold">{{ $demande->invoicingdate ? $demande->invoicingdate->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Date Commission</label>
                        <p class="fw-bold">{{ $demande->commissiondate ? $demande->commissiondate->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Date Avis DF</label>
                        <p class="fw-bold">{{ $demande->opiniondfdate ? $demande->opiniondfdate->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Montant Royalty</label>
                        <p class="fw-bold">{{ $demande->roaltyamount ? number_format($demande->roaltyamount, 2) . ' €' : '0.00 €' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Année Exercice</label>
                        <p class="fw-bold">{{ $demande->exoyear ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($demande->commissionopinion || $demande->urbanplanningregulations)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Avis & Règlements</h5>
                </div>
                <div class="card-body">
                    @if($demande->commissionopinion)
                    <div class="mb-4">
                        <label class="form-label text-muted small">Avis de la Commission</label>
                        <p class="fw-normal">{{ $demande->commissionopinion }}</p>
                    </div>
                    @endif
                    
                    @if($demande->urbanplanningregulations)
                    <div>
                        <label class="form-label text-muted small">Règlements d'Urbanisme</label>
                        <p class="fw-normal">{{ $demande->urbanplanningregulations }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection