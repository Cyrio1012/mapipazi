@extends('layouts.app')

@section('title', 'Nouvelle Demande')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Nouvelle Demande</h1>
        <a href="{{ route('demandes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('demandes.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3 border-bottom pb-2">Informations de Base</h5>
                        
                        <div class="mb-3">
                            <label for="arrivalid" class="form-label">Référence Arrivée *</label>
                            <input type="text" class="form-control @error('arrivalid') is-invalid @enderror" 
                                   id="arrivalid" name="arrivalid" value="{{ old('arrivalid') }}" required>
                            @error('arrivalid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicantname" class="form-label">Nom du Demandeur *</label>
                            <input type="text" class="form-control @error('applicantname') is-invalid @enderror" 
                                   id="applicantname" name="applicantname" value="{{ old('applicantname') }}" required>
                            @error('applicantname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicantaddress" class="form-label">Adresse du Demandeur</label>
                            <textarea class="form-control @error('applicantaddress') is-invalid @enderror" 
                                      id="applicantaddress" name="applicantaddress" rows="2">{{ old('applicantaddress') }}</textarea>
                            @error('applicantaddress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="propertyname" class="form-label">Nom de la Propriété</label>
                            <input type="text" class="form-control @error('propertyname') is-invalid @enderror" 
                                   id="propertyname" name="propertyname" value="{{ old('propertyname') }}">
                            @error('propertyname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="propertyowner" class="form-label">Propriétaire</label>
                            <input type="text" class="form-control @error('propertyowner') is-invalid @enderror" 
                                   id="propertyowner" name="propertyowner" value="{{ old('propertyowner') }}">
                            @error('propertyowner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="propertytitle" class="form-label">Titre de Propriété</label>
                            <input type="text" class="form-control @error('propertytitle') is-invalid @enderror" 
                                   id="propertytitle" name="propertytitle" value="{{ old('propertytitle') }}">
                            @error('propertytitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="locality" class="form-label">Localité</label>
                                <input type="text" class="form-control @error('locality') is-invalid @enderror" 
                                       id="locality" name="locality" value="{{ old('locality') }}">
                                @error('locality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="municipality" class="form-label">Commune</label>
                                <input type="text" class="form-control @error('municipality') is-invalid @enderror" 
                                       id="municipality" name="municipality" value="{{ old('municipality') }}">
                                @error('municipality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3 border-bottom pb-2">Coordonnées & Surfaces</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="xv" class="form-label">Coordonnée X</label>
                                <input type="number" step="0.0001" class="form-control @error('xv') is-invalid @enderror" 
                                       id="xv" name="xv" value="{{ old('xv') }}">
                                @error('xv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="yv" class="form-label">Coordonnée Y</label>
                                <input type="number" step="0.0001" class="form-control @error('yv') is-invalid @enderror" 
                                       id="yv" name="yv" value="{{ old('yv') }}">
                                @error('yv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="surfacearea" class="form-label">Surface Totale (m²)</label>
                                <input type="number" step="0.01" class="form-control @error('surfacearea') is-invalid @enderror" 
                                       id="surfacearea" name="surfacearea" value="{{ old('surfacearea') }}">
                                @error('surfacearea')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="backfilledarea" class="form-label">Surface Remblayée (m²)</label>
                                <input type="number" step="0.01" class="form-control @error('backfilledarea') is-invalid @enderror" 
                                       id="backfilledarea" name="backfilledarea" value="{{ old('backfilledarea') }}">
                                @error('backfilledarea')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="roaltyamount" class="form-label">Montant </label>
                            <input type="number" step="0.01" class="form-control @error('roaltyamount') is-invalid @enderror" 
                                   id="roaltyamount" name="roaltyamount" value="{{ old('roaltyamount') }}">
                            @error('roaltyamount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 mt-4 border-bottom pb-2">Informations Techniques</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="upr" class="form-label">UPR</label>
                                <input type="text" class="form-control @error('upr') is-invalid @enderror" 
                                       id="upr" name="upr" value="{{ old('upr') }}">
                                @error('upr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sit_r" class="form-label">SIT_R</label>
                                <input type="text" class="form-control @error('sit_r') is-invalid @enderror" 
                                       id="sit_r" name="sit_r" value="{{ old('sit_r') }}">
                                @error('sit_r')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Catégorie</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                       id="category" name="category" value="{{ old('category') }}">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="opfinal" class="form-label">OP Final</label>
                                <input type="text" class="form-control @error('opfinal') is-invalid @enderror" 
                                       id="opfinal" name="opfinal" value="{{ old('opfinal') }}">
                                @error('opfinal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5 class="mb-3 border-bottom pb-2">Dates</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="arrivaldate" class="form-label">Date d'Arrivée</label>
                                <input type="date" class="form-control @error('arrivaldate') is-invalid @enderror" 
                                       id="arrivaldate" name="arrivaldate" value="{{ old('arrivaldate') }}">
                                @error('arrivaldate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="invoicingdate" class="form-label">Date de Facturation</label>
                                <input type="date" class="form-control @error('invoicingdate') is-invalid @enderror" 
                                       id="invoicingdate" name="invoicingdate" value="{{ old('invoicingdate') }}">
                                @error('invoicingdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="commissiondate" class="form-label">Date Commission</label>
                                <input type="date" class="form-control @error('commissiondate') is-invalid @enderror" 
                                       id="commissiondate" name="commissiondate" value="{{ old('commissiondate') }}">
                                @error('commissiondate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="opiniondfdate" class="form-label">Date Avis DF</label>
                                <input type="date" class="form-control @error('opiniondfdate') is-invalid @enderror" 
                                       id="opiniondfdate" name="opiniondfdate" value="{{ old('opiniondfdate') }}">
                                @error('opiniondfdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="exoyear" class="form-label">Année d'Exercice</label>
                                <input type="number" min="2000" max="2100" class="form-control @error('exoyear') is-invalid @enderror" 
                                       id="exoyear" name="exoyear" value="{{ old('exoyear') }}">
                                @error('exoyear')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="invoicingid" class="form-label">Référence Facturation</label>
                                <input type="text" class="form-control @error('invoicingid') is-invalid @enderror" 
                                       id="invoicingid" name="invoicingid" value="{{ old('invoicingid') }}">
                                @error('invoicingid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sendersce" class="form-label">Service Expéditeur</label>
                            <input type="text" class="form-control @error('sendersce') is-invalid @enderror" 
                                   id="sendersce" name="sendersce" value="{{ old('sendersce') }}">
                            @error('sendersce')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3 border-bottom pb-2">Avis & Règlements</h5>
                        
                        <div class="mb-3">
                            <label for="commissionopinion" class="form-label">Avis de la Commission</label>
                            <textarea class="form-control @error('commissionopinion') is-invalid @enderror" 
                                      id="commissionopinion" name="commissionopinion" rows="4">{{ old('commissionopinion') }}</textarea>
                            @error('commissionopinion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="urbanplanningregulations" class="form-label">Règlements d'Urbanisme</label>
                            <textarea class="form-control @error('urbanplanningregulations') is-invalid @enderror" 
                                      id="urbanplanningregulations" name="urbanplanningregulations" rows="4">{{ old('urbanplanningregulations') }}</textarea>
                            @error('urbanplanningregulations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer la Demande
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script pour formater automatiquement les dates
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        
        // Définir la date d'arrivée à aujourd'hui par défaut
        const arrivalDateInput = document.getElementById('arrivaldate');
        if (arrivalDateInput && !arrivalDateInput.value) {
            arrivalDateInput.value = today;
        }
        
        // Définir l'année d'exercice à l'année courante par défaut
        const exoyearInput = document.getElementById('exoyear');
        if (exoyearInput && !exoyearInput.value) {
            exoyearInput.value = new Date().getFullYear();
        }
    });
</script>
@endsection