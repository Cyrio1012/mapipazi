@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Modifier Archive #{{ $archive->id ?? 'Nouveau' }}
                    </h4>
                    <div>
                        <a href="{{ route('archives.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                
                <form method="POST" action="{{ isset($archive) ? route('archives.update', $archive->id) : route('archives.store') }}" id="archiveForm">
                    @csrf
                    @if(isset($archive))
                        @method('PUT')
                    @endif
                    
                    <div class="card-body">
                        <!-- Navigation par onglets -->
                        <ul class="nav nav-tabs mb-4" id="archiveTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                    <i class="fas fa-info-circle"></i> Général
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="demandeur-tab" data-bs-toggle="tab" data-bs-target="#demandeur" type="button" role="tab">
                                    <i class="fas fa-user"></i> Demandeur
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="propriete-tab" data-bs-toggle="tab" data-bs-target="#propriete" type="button" role="tab">
                                    <i class="fas fa-home"></i> Propriété
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="urbanisme-tab" data-bs-toggle="tab" data-bs-target="#urbanisme" type="button" role="tab">
                                    <i class="fas fa-city"></i> Urbanisme
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="procedure-tab" data-bs-toggle="tab" data-bs-target="#procedure" type="button" role="tab">
                                    <i class="fas fa-gavel"></i> Procédure
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="financier-tab" data-bs-toggle="tab" data-bs-target="#financier" type="button" role="tab">
                                    <i class="fas fa-money-bill"></i> Financier
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="commission-tab" data-bs-toggle="tab" data-bs-target="#commission" type="button" role="tab">
                                    <i class="fas fa-users"></i> Commission
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="archiveTabsContent">
                            <!-- Onglet Général -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="exoyear" class="form-label">Année d'exercice *</label>
                                        <input type="number" class="form-control" id="exoyear" name="exoyear" 
                                               value="{{ old('exoyear', $archive->exoyear ?? '') }}" 
                                               min="2000" max="2030">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="arrivaldate" class="form-label">Date d'arrivée *</label>
                                        <input type="date" class="form-control" id="arrivaldate" name="arrivaldate" 
                                               value="{{ old('arrivaldate', $archive->arrivaldate ? $archive->arrivaldate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="arrivalid" class="form-label">Référence d'arrivée *</label>
                                        <input type="text" class="form-control" id="arrivalid" name="arrivalid" 
                                               value="{{ old('arrivalid', $archive->arrivalid ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="sendersce" class="form-label">Service émetteur *</label>
                                        <textarea class="form-control" rows="3" name="sendersce" id="sendersce">
                                            {{  $archive->sendersce ?? '' }}
                                        </textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="actiontaken" class="form-label">Mesure prise *</label>
                                        <textarea class="form-control" rows="3" name="actiontaken" id="actiontaken">
                                            {{  $archive->actiontaken ?? '' }}
                                        </textarea>
                                        
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="measures" class="form-label">Mesures détaillées</label>
                                        <textarea class="form-control" id="measures" name="measures" rows="3">{{ old('measures', $archive->measures ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="findingof" class="form-label">Constats</label>
                                        <textarea class="form-control" id="findingof" name="findingof" rows="3">{{ old('findingof', $archive->findingof ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Demandeur -->
                            <div class="tab-pane fade" id="demandeur" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="applicantname" class="form-label">Nom du demandeur *</label>
                                        <input type="text" class="form-control" id="applicantname" name="applicantname" 
                                               value="{{ old('applicantname', $archive->applicantname ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="applicantcontact" class="form-label">Contact</label>
                                        <input type="text" class="form-control" id="applicantcontact" name="applicantcontact" 
                                               value="{{ old('applicantcontact', $archive->applicantcontact ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="applicantaddress" class="form-label">Adresse</label>
                                        <textarea class="form-control" id="applicantaddress" name="applicantaddress" rows="2">{{ old('applicantaddress', $archive->applicantaddress ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Propriété -->
                            <div class="tab-pane fade" id="propriete" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="municipality" class="form-label">Commune *</label>
                                        <input type="text" class="form-control" id="municipality" name="municipality" 
                                               value="{{ old('municipality', $archive->municipality ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="locality" class="form-label">Localité</label>
                                        <input type="text" class="form-control" id="locality" name="locality" 
                                               value="{{ old('locality', $archive->locality ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="property0wner" class="form-label">Propriétaire *</label>
                                        <input type="text" class="form-control" id="property0wner" name="property0wner" 
                                               value="{{ old('property0wner', $archive->property0wner ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="propertytitle" class="form-label">Titre de propriété</label>
                                        <input type="text" class="form-control" id="propertytitle" name="propertytitle" 
                                               value="{{ old('propertytitle', $archive->propertytitle ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="propertyname" class="form-label">Nom de la propriété</label>
                                        <input type="text" class="form-control" id="propertyname" name="propertyname" 
                                               value="{{ old('propertyname', $archive->propertyname ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Urbanisme -->
                            <div class="tab-pane fade" id="urbanisme" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="urbanplanningregulations" class="form-label">Règlement d'urbanisme</label>
                                        <input type="text" class="form-control" id="urbanplanningregulations" name="urbanplanningregulations" 
                                               value="{{ old('urbanplanningregulations', $archive->urbanplanningregulations ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="upr" class="form-label">UPR</label>
                                        <input type="text" class="form-control" id="upr" name="upr" 
                                               value="{{ old('upr', $archive->upr ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="zoning" class="form-label">Zonage</label>
                                        <select class="form-select" id="zoning" name="zoning">
                                            <option value="">Sélectionner...</option>
                                            <option value="Zone A" {{ (old('zoning', $archive->zoning ?? '') == 'Zone A') ? 'selected' : '' }}>Zone A</option>
                                            <option value="Zone B" {{ (old('zoning', $archive->zoning ?? '') == 'Zone B') ? 'selected' : '' }}>Zone B</option>
                                            <option value="Zone C" {{ (old('zoning', $archive->zoning ?? '') == 'Zone C') ? 'selected' : '' }}>Zone C</option>
                                            <option value="Zone D" {{ (old('zoning', $archive->zoning ?? '') == 'Zone D') ? 'selected' : '' }}>Zone D</option>
                                            <option value="Zone NA" {{ (old('zoning', $archive->zoning ?? '') == 'Zone NA') ? 'selected' : '' }}>Zone NA</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="surfacearea" class="form-label">Surface (m²)</label>
                                        <input type="number" class="form-control" id="surfacearea" name="surfacearea" 
                                               value="{{ old('surfacearea', $archive->surfacearea ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="backfilledarea" class="form-label">Zone remblayée (m²)</label>
                                        <input type="number" class="form-control" id="backfilledarea" name="backfilledarea" 
                                               value="{{ old('backfilledarea', $archive->backfilledarea ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="xv" class="form-label">Coordonnée X</label>
                                        <input type="number" class="form-control" id="xv" name="xv" 
                                               value="{{ old('xv', $archive->xv ?? '') }}" step="0.000001">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="yv" class="form-label">Coordonnée Y</label>
                                        <input type="number" class="form-control" id="yv" name="yv" 
                                               value="{{ old('yv', $archive->yv ?? '') }}" step="0.000001">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="destination" class="form-label">Destination</label>
                                        <select class="form-select" id="destination" name="destination">
                                            <option value="">Sélectionner...</option>
                                            <option value="Résidentiel" {{ (old('destination', $archive->destination ?? '') == 'Résidentiel') ? 'selected' : '' }}>Résidentiel</option>
                                            <option value="Commercial" {{ (old('destination', $archive->destination ?? '') == 'Commercial') ? 'selected' : '' }}>Commercial</option>
                                            <option value="Industriel" {{ (old('destination', $archive->destination ?? '') == 'Industriel') ? 'selected' : '' }}>Industriel</option>
                                            <option value="Agricole" {{ (old('destination', $archive->destination ?? '') == 'Agricole') ? 'selected' : '' }}>Agricole</option>
                                            <option value="Mixte" {{ (old('destination', $archive->destination ?? '') == 'Mixte') ? 'selected' : '' }}>Mixte</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Procédure -->
                            <div class="tab-pane fade" id="procedure" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="descentdate" class="form-label">Date de descente</label>
                                        <input type="date" class="form-control" id="descentdate" name="descentdate" 
                                               value="{{ old('descentdate',$archive->descentdate ? $archive->descentdate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="reportid" class="form-label">ID Rapport</label>
                                        <input type="text" class="form-control" id="reportid" name="reportid" 
                                               value="{{ old('reportid', $archive->reportid ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="summondate" class="form-label">Date de convocation</label>
                                        <input type="date" class="form-control" id="summondate" name="summondate" 
                                               value="{{ old('summondate', $archive->summondate ? $archive->summodate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="minutesid" class="form-label">ID PV</label>
                                        <input type="text" class="form-control" id="minutesid" name="minutesid" 
                                               value="{{ old('minutesid', $archive->minutesid ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="minutesdate" class="form-label">Date PV</label>
                                        <input type="date" class="form-control" id="minutesdate" name="minutesdate" 
                                               value="{{ old('minutesdate', $archive->minutesdate ? $archive->minutesdate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="partsupplied" class="form-label">Partie fournie</label>
                                        <input type="text" class="form-control" id="partsupplied" name="partsupplied" 
                                               value="{{ old('partsupplied', $archive->partsupplied ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="submissiondate" class="form-label">Date de soumission</label>
                                        <input type="date" class="form-control" id="submissiondate" name="submissiondate" 
                                               value="{{ old('submissiondate', $archive->submissiondate ? $archive->submissiondate->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Financier -->
                            <div class="tab-pane fade" id="financier" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="svr_fine" class="form-label">Amende SVR</label>
                                        <input type="number" class="form-control" id="svr_fine" name="svr_fine" 
                                               value="{{ old('svr_fine', $archive->svr_fine ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="svr_roalty" class="form-label">Redevance SVR</label>
                                        <input type="number" class="form-control" id="svr_roalty" name="svr_roalty" 
                                               value="{{ old('svr_roalty', $archive->svr_roalty ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="invoicingid" class="form-label">ID Facturation</label>
                                        <input type="text" class="form-control" id="invoicingid" name="invoicingid" 
                                               value="{{ old('invoicingid', $archive->invoicingid ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="invoicingdate" class="form-label">Date facturation</label>
                                        <input type="date" class="form-control" id="invoicingdate" name="invoicingdate" 
                                               value="{{ old('invoicingdate', $archive->invoicingdate ?$archive->invoicingdate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="fineamount" class="form-label">Montant amende (Ar)</label>
                                        <input type="number" class="form-control" id="fineamount" name="fineamount" 
                                               value="{{ old('fineamount', $archive->fineamount ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="roaltyamount" class="form-label">Montant redevance (Ar)</label>
                                        <input type="number" class="form-control" id="roaltyamount" name="roaltyamount" 
                                               value="{{ old('roaltyamount', $archive->roaltyamount ?? '') }}" step="0.01" min="0">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="convention" class="form-label">Convention</label>
                                        <input type="text" class="form-control" id="convention" name="convention" 
                                               value="{{ old('convention', $archive->convention ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="payementmethod" class="form-label">Mode de paiement</label>
                                        <select class="form-select" id="payementmethod" name="payementmethod">
                                            <option value="">Sélectionner...</option>
                                            <option value="Espèces" {{ (old('payementmethod', $archive->payementmethod ?? '') == 'Espèces') ? 'selected' : '' }}>Espèces</option>
                                            <option value="Chèque" {{ (old('payementmethod', $archive->payementmethod ?? '') == 'Chèque') ? 'selected' : '' }}>Chèque</option>
                                            <option value="Virement" {{ (old('payementmethod', $archive->payementmethod ?? '') == 'Virement') ? 'selected' : '' }}>Virement</option>
                                            <option value="Carte bancaire" {{ (old('payementmethod', $archive->payementmethod ?? '') == 'Carte bancaire') ? 'selected' : '' }}>Carte bancaire</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="daftransmissiondate" class="form-label">Date transmission DAF</label>
                                        <input type="date" class="form-control" id="daftransmissiondate" name="daftransmissiondate" 
                                               value="{{ old('daftransmissiondate', $archive->daftransmissiondate ? $archive->daftrasmissiondate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="ref_quitus" class="form-label">Référence quitus</label>
                                        <input type="text" class="form-control" id="ref_quitus" name="ref_quitus" 
                                               value="{{ old('ref_quitus', $archive->ref_quitus ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                        <label for="sit_r" class="form-label">SIT R</label>
                                        <input type="text" class="form-control" id="sit_r" name="sit_r" 
                                               value="{{ old('sit_r', $archive->sit_r ?? '') }}">
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                        <label for="sit_a" class="form-label">SIT A</label>
                                        <input type="text" class="form-control" id="sit_a" name="sit_a" 
                                               value="{{ old('sit_a', $archive->sit_a ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglet Commission -->
                            <div class="tab-pane fade" id="commission" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="commissiondate" class="form-label">Date commission</label>
                                        <input type="date" class="form-control" id="commissiondate" name="commissiondate" 
                                               value="{{ old('commissiondate', $archive->commissiondate ? $archive->commissiondate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-8 mb-3">
                                        <label for="commissionopinion" class="form-label">Avis de la commission</label>
                                        <textarea class="form-control" id="commissionopinion" name="commissionopinion" rows="2">{{ old('commissionopinion', $archive->commissionopinion ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="recommandationobs" class="form-label">Observations recommandation</label>
                                        <textarea class="form-control" id="recommandationobs" name="recommandationobs" rows="3">{{ old('recommandationobs', $archive->recommandationobs ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="opfinal" class="form-label">Avis final OP</label>
                                        <select class="form-select" id="opfinal" name="opfinal">
                                            <option value="">Sélectionner...</option>
                                            <option value="Favorable" {{ (old('opfinal', $archive->opfinal ?? '') == 'Favorable') ? 'selected' : '' }}>Favorable</option>
                                            <option value="Défavorable" {{ (old('opfinal', $archive->opfinal ?? '') == 'Défavorable') ? 'selected' : '' }}>Défavorable</option>
                                            <option value="Ajourné" {{ (old('opfinal', $archive->opfinal ?? '') == 'Ajourné') ? 'selected' : '' }}>Ajourné</option>
                                            <option value="Reporté" {{ (old('opfinal', $archive->opfinal ?? '') == 'Reporté') ? 'selected' : '' }}>Reporté</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="opiniondfdate" class="form-label">Date avis DF</label>
                                        <input type="date" class="form-control" id="opiniondfdate" name="opiniondfdate" 
                                               value="{{ old('opiniondfdate', $archive->opiniondfdate ? $archive->opiniondfdate->format('Y-m-d') : '') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Catégorie</label>
                                        <select class="form-select" id="category" name="category">
                                            <option value="">Sélectionner...</option>
                                            <option value="Catégorie 1" {{ (old('category', $archive->category ?? '') == 'Catégorie 1') ? 'selected' : '' }}>Catégorie 1</option>
                                            <option value="Catégorie 2" {{ (old('category', $archive->category ?? '') == 'Catégorie 2') ? 'selected' : '' }}>Catégorie 2</option>
                                            <option value="Catégorie 3" {{ (old('category', $archive->category ?? '') == 'Catégorie 3') ? 'selected' : '' }}>Catégorie 3</option>
                                            <option value="Catégorie 4" {{ (old('category', $archive->category ?? '') == 'Catégorie 4') ? 'selected' : '' }}>Catégorie 4</option>
                                            <option value="Catégorie 5" {{ (old('category', $archive->category ?? '') == 'Catégorie 5') ? 'selected' : '' }}>Catégorie 5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="fas fa-redo"></i> Réinitialiser
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ isset($archive) ? 'Mettre à jour' : 'Créer' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation JavaScript côté client
    const form = document.getElementById('archiveForm');
    
  
    
    // Auto-formatage des dates
    const dateFields = document.querySelectorAll('input[type="date"]');
    dateFields.forEach(field => {
        field.addEventListener('change', function() {
            if (this.value) {
                const date = new Date(this.value);
                this.title = formatDate(date);
            }
        });
        
        if (field.value) {
            const date = new Date(field.value);
            field.title = formatDate(date);
        }
    });
    
    // Générer un ID d'arrivée si création
    const arrivalIdField = document.getElementById('arrivalid');
    if (arrivalIdField && !arrivalIdField.value && !{{ isset($archive) ? 'true' : 'false' }}) {
        arrivalIdField.value = generateArchiveId();
    }
    
    // Calcul automatique des totaux
    setupCalculations();
    
    // Navigation par onglets avec validation
    setupTabValidation();
});

// Validation du formulaire
function validateForm() {
    let isValid = true;
    const errorMessages = [];
    
    // Champs obligatoires
    const requiredFields = [
        //{ id: 'exoyear', name: 'Année d\'exercice' },
        //{ id: 'arrivaldate', name: 'Date d\'arrivée' },
        //{ id: 'arrivalid', name: 'Référence d\'arrivée' },
        //{ id: 'sendersce', name: 'Service émetteur' },
        //{ id: 'actiontaken', name: 'Mesure prise' },
        //{ id: 'applicantname', name: 'Nom du demandeur' },
        //{ id: 'municipality', name: 'Commune' },
        //{ id: 'property0wner', name: 'Propriétaire' }
    ];
    
    // Vérifier chaque champ obligatoire
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            const value = element.value ? element.value.trim() : '';
            if (!value) {
                isValid = false;
                element.classList.add('is-invalid');
                errorMessages.push(`${field.name} est obligatoire`);
                
                // Ajouter le message d'erreur
                let errorDiv = element.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Ce champ est obligatoire';
                    element.parentNode.appendChild(errorDiv);
                }
            } else {
                element.classList.remove('is-invalid');
                // Supprimer le message d'erreur
                const errorDiv = element.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv.remove();
                }
            }
        }
    });
    
    // Validation des dates
    const dateFields = document.querySelectorAll('input[type="date"]');
    dateFields.forEach(field => {
        if (field.value) {
            const date = new Date(field.value);
            if (isNaN(date.getTime())) {
                isValid = false;
                field.classList.add('is-invalid');
                errorMessages.push(`Date invalide dans ${field.previousElementSibling?.textContent || 'un champ date'}`);
            }
        }
    });
    
    // Validation des nombres
    const numberFields = document.querySelectorAll('input[type="number"]');
    numberFields.forEach(field => {
        if (field.value) {
            const num = parseFloat(field.value);
            if (isNaN(num) || (field.min && num < parseFloat(field.min))) {
                isValid = false;
                field.classList.add('is-invalid');
                errorMessages.push(`Valeur invalide dans ${field.previousElementSibling?.textContent || 'un champ numérique'}`);
            }
        }
    });
    
    if (!isValid) {
        // Afficher toutes les erreurs
        showErrorModal(errorMessages);
        
        // Aller au premier champ avec erreur
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            const tabPane = firstError.closest('.tab-pane');
            if (tabPane) {
                const tabId = tabPane.id;
                const tabButton = document.querySelector(`[data-bs-target="#${tabId}"]`);
                if (tabButton) {
                    new bootstrap.Tab(tabButton).show();
                }
            }
            firstError.focus();
        }
    }
    
    return isValid;
}

// Afficher une modal d'erreur
function showErrorModal(messages) {
    // Créer une modal temporaire pour afficher les erreurs
    const modalHtml = `
        <div class="modal fade" id="errorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Erreurs de validation</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <p class="mb-2"><strong>Veuillez corriger les erreurs suivantes :</strong></p>
                            <ul class="mb-0">
                                ${messages.map(msg => `<li>${msg}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Ajouter la modal au DOM
    const modalContainer = document.createElement('div');
    modalContainer.innerHTML = modalHtml;
    document.body.appendChild(modalContainer.firstElementChild);
    
    // Afficher la modal
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
    
    // Supprimer la modal après fermeture
    document.getElementById('errorModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Formater une date
function formatDate(date) {
    return date.toLocaleDateString('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Générer un ID d'archive
function generateArchiveId() {
    const prefix = 'ARCH';
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    
    return `${prefix}-${year}${month}${day}-${random}`;
}

// Configuration des calculs automatiques
function setupCalculations() {
    const fineAmountField = document.getElementById('fineamount');
    const royaltyAmountField = document.getElementById('roaltyamount');
    const svrFineField = document.getElementById('svr_fine');
    const svrRoyaltyField = document.getElementById('svr_roalty');
    
    function calculateTotal() {
        const fine = parseFloat(fineAmountField?.value) || 0;
        const royalty = parseFloat(royaltyAmountField?.value) || 0;
        const svrFine = parseFloat(svrFineField?.value) || 0;
        const svrRoyalty = parseFloat(svrRoyaltyField?.value) || 0;
        
        // Vous pouvez afficher le total quelque part
        // const total = fine + royalty + svrFine + svrRoyalty;
    }
    
    [fineAmountField, royaltyAmountField, svrFineField, svrRoyaltyField].forEach(field => {
        if (field) {
            field.addEventListener('input', calculateTotal);
        }
    });
}

// Configuration de la validation par onglet
function setupTabValidation() {
    const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const currentTab = document.querySelector('.tab-pane.active');
            if (currentTab) {
                const requiredFields = currentTab.querySelectorAll('[required]');
                let hasError = false;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        hasError = true;
                        field.classList.add('is-invalid');
                    }
                });
                
                if (hasError) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires dans l\'onglet actuel avant de passer au suivant.');
                    return false;
                }
            }
        });
    });
}

// Réinitialiser le formulaire
function resetForm() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les modifications seront perdues.')) {
        document.getElementById('archiveForm').reset();
        
        // Réinitialiser les messages d'erreur
        document.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        document.querySelectorAll('.invalid-feedback').forEach(error => {
            error.remove();
        });
        
        // Regénérer l'ID si c'est une création
        if (!{{ isset($archive) ? 'true' : 'false' }}) {
            const arrivalIdField = document.getElementById('arrivalid');
            if (arrivalIdField) {
                arrivalIdField.value = generateArchiveId();
            }
        }
    }
}

// Copier les coordonnées
function copyCoordinates() {
    const xv = document.getElementById('xv').value;
    const yv = document.getElementById('yv').value;
    
    if (xv && yv) {
        const text = `X: ${xv}, Y: ${yv}`;
        navigator.clipboard.writeText(text)
            .then(() => alert('Coordonnées copiées dans le presse-papier !'))
            .catch(err => console.error('Erreur de copie:', err));
    }
}

// Prévisualiser le formulaire
function previewForm() {
    // Ici vous pourriez implémenter une prévisualisation
    alert('Fonction de prévisualisation à implémenter');
}
</script>

<!-- Styles -->
<style>
.nav-tabs .nav-link {
    font-weight: 500;
    color: #6c757d;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link:hover {
    color: #495057;
    border-color: #dee2e6;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    font-weight: 600;
    border-color: #0d6efd;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
}

.card-footer {
    border-top: 1px solid rgba(0,0,0,.125);
    background-color: rgba(0,0,0,.03);
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

.tab-pane {
    padding-top: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
    }
    
    .nav-tabs .nav-item {
        white-space: nowrap;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .col-md-3, .col-md-4, .col-md-6 {
        margin-bottom: 1rem;
    }
}

/* Amélioration de l'UX */
input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
    filter: invert(0.5);
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

.form-control:not(:placeholder-shown) {
    background-color: #f8f9fa;
}

.form-control:focus:not(:placeholder-shown) {
    background-color: white;
}
</style>
@endsection