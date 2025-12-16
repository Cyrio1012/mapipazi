@extends('layouts.app')

@section('title', 'Détails de la Doléance')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Carte principale -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Doléance #{{ $doleance->id }}</h4>
                    <span class="badge {{ $doleance->statut_formate['badge'] }} fs-6">
                        {{ $doleance->statut_formate['text'] }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Informations du demandeur</h6>
                            <div class="mb-3">
                                <label class="form-label small">Nom complet</label>
                                <p class="fw-bold">{{ $doleance->nom }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Contact</label>
                                <p class="fw-bold">{{ $doleance->contact }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Informations techniques</h6>
                            <div class="mb-3">
                                <label class="form-label small">Date de création</label>
                                <p class="fw-bold">{{ $doleance->date_creation }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Dernière mise à jour</label>
                                <p class="fw-bold">{{ $doleance->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($doleance->traiteur)
                            <div class="mb-3">
                                <label class="form-label small">Traité par</label>
                                <p class="fw-bold">{{ $doleance->traiteur->name }}</p>
                            </div>
                            @endif
                            @if($doleance->traite_le)
                            <div class="mb-3">
                                <label class="form-label small">Traité le</label>
                                <p class="fw-bold">{{ $doleance->date_traitement }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small">Sujet</label>
                        <div class="alert alert-secondary">
                            <h5 class="mb-0">{{ $doleance->sujet }}</h5>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small">Message</label>
                        <div class="card border">
                            <div class="card-body bg-light">
                                {!! nl2br(e($doleance->message)) !!}
                            </div>
                        </div>
                    </div>

                    @if($doleance->reponse)
                    <div class="mb-4">
                        <label class="form-label small">Réponse / Commentaire</label>
                        <div class="card border border-success">
                            <div class="card-header bg-success text-white">
                                <i class="fas fa-reply me-1"></i> Réponse de l'APIPA
                            </div>
                            <div class="card-body bg-light">
                                {!! nl2br(e($doleance->reponse)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs"></i> Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('doleances.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                        </a>
                        
                        @if($doleance->status == 'nouveau')
                            <form action="{{ route('doleances.update.status', $doleance) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="en_cours">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-play me-1"></i> Prendre en charge
                                </button>
                            </form>
                        @endif
                        
                        @if($doleance->status == 'en_cours')
                            <!-- Bouton Traiter avec modal -->
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" 
                                    data-bs-target="#traiterModal">
                                <i class="fas fa-check me-1"></i> Marquer comme traité
                            </button>
                            
                            <!-- Bouton Rejeter avec modal -->
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" 
                                    data-bs-target="#rejeterModal">
                                <i class="fas fa-times me-1"></i> Rejeter
                            </button>
                        @endif
                        
                        @if(in_array($doleance->status, ['traite', 'rejete']))
                            <!-- Bouton pour revenir à "en cours" -->
                            <form action="{{ route('doleances.update.status', $doleance) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="en_cours">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-redo me-1"></i> Reprendre en charge
                                </button>
                            </form>
                        @endif
                        
                        <!-- Édition -->
                        <a href="{{ route('doleances.edit', $doleance) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        
                        <!-- Suppression -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Historique des statuts -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Création</h6>
                                <p class="text-muted small mb-0">{{ $doleance->date_creation }}</p>
                                <p class="small mb-0">Doléance soumise</p>
                            </div>
                        </div>
                        
                        @if($doleance->status != 'nouveau' && $doleance->traiteur)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Prise en charge</h6>
                                <p class="text-muted small mb-0">Par: {{ $doleance->traiteur->name }}</p>
                                <p class="small mb-0">Statut: {{ $doleance->statut_formate['text'] }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($doleance->traite_le)
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $doleance->status == 'traite' ? 'bg-success' : 'bg-danger' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Traitement</h6>
                                <p class="text-muted small mb-0">{{ $doleance->date_traitement }}</p>
                                <p class="small mb-0">
                                    {{ $doleance->status == 'traite' ? 'Doléance traitée' : 'Doléance rejetée' }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Traiter -->
<div class="modal fade" id="traiterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Marquer comme traité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('doleances.update.status', $doleance) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="status" value="traite">
                    <div class="mb-3">
                        <label for="reponse" class="form-label">Réponse / Commentaire (optionnel)</label>
                        <textarea name="reponse" id="reponse" class="form-control" rows="4" 
                                  placeholder="Ajoutez une réponse ou un commentaire...">{{ $doleance->reponse }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Marquer comme traité
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Rejeter -->
<div class="modal fade" id="rejeterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Rejeter la doléance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('doleances.update.status', $doleance) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="status" value="rejete">
                    <div class="mb-3">
                        <label for="reponseRejet" class="form-label">Raison du rejet (optionnel)</label>
                        <textarea name="reponse" id="reponseRejet" class="form-control" rows="4" 
                                  placeholder="Expliquez la raison du rejet...">{{ $doleance->reponse }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Rejeter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette doléance ? Cette action est irréversible.</p>
                <p class="fw-bold">Doléance #{{ $doleance->id }} - {{ $doleance->sujet }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('doleances.destroy', $doleance) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .timeline-item:last-child .timeline-content {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endsection