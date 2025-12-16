@extends('layouts.app')

@section('title', 'Gestion des Doléances')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Gestion des Doléances</h4>
            <div>
                <a href="{{ route('doleances.dashboard') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-chart-bar"></i> Tableau de bord
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filtres -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border">
                        <div class="card-body py-2">
                            <form method="GET" action="{{ route('doleances.index') }}" class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label small">Statut</label>
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">Tous les statuts</option>
                                        <option value="nouveau" {{ request('status') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                        <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="traite" {{ request('status') == 'traite' ? 'selected' : '' }}>Traité</option>
                                        <option value="rejete" {{ request('status') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Sujet</label>
                                    <input type="text" name="sujet" class="form-control form-control-sm" 
                                           placeholder="Rechercher par sujet" value="{{ request('sujet') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Tri par</label>
                                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date de création</option>
                                        <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Statut</option>
                                        <option value="sujet" {{ request('sort') == 'sujet' ? 'selected' : '' }}>Sujet</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-filter"></i> Filtrer
                                        </button>
                                        <a href="{{ route('doleances.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-redo"></i> Réinitialiser
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des doléances -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Sujet</th>
                            <th>Statut</th>
                            <th>Traiteur</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doleances as $doleance)
                        <tr class="{{ $doleance->status == 'nouveau' ? 'table-info' : '' }}">
                            <td><strong>#{{ $doleance->id }}</strong></td>
                            <td>{{ $doleance->nom }}</td>
                            <td>
                                <small class="text-muted">{{ $doleance->contact }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $doleance->sujet }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $doleance->statut_formate['badge'] }}">
                                    {{ $doleance->statut_formate['text'] }}
                                </span>
                            </td>
                            <td>
                                @if($doleance->traiteur)
                                    <span class="badge bg-secondary">
                                        {{ $doleance->traiteur->name }}
                                    </span>
                                    @if($doleance->traite_le)
                                        <br>
                                        <small class="text-muted">{{ $doleance->date_traitement }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $doleance->date_creation }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('doleances.show', $doleance) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($doleance->status == 'nouveau')
                                        <form action="{{ route('doleances.update.status', $doleance) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="en_cours">
                                            <button type="submit" class="btn btn-warning" title="Prendre en charge">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($doleance->status == 'en_cours')
                                        <!-- Modal pour marquer comme traité -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                                                data-bs-target="#traiterModal{{ $doleance->id }}" title="Marquer comme traité">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        <!-- Modal pour rejeter -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejeterModal{{ $doleance->id }}" title="Rejeter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                                
                                <!-- Modal Traiter -->
                                <div class="modal fade" id="traiterModal{{ $doleance->id }}" tabindex="-1">
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
                                                        <label for="reponse{{ $doleance->id }}" class="form-label">
                                                            Réponse / Commentaire (optionnel)
                                                        </label>
                                                        <textarea name="reponse" id="reponse{{ $doleance->id }}" 
                                                                  class="form-control" rows="4" 
                                                                  placeholder="Ajoutez une réponse ou un commentaire..."></textarea>
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
                                <div class="modal fade" id="rejeterModal{{ $doleance->id }}" tabindex="-1">
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
                                                        <label for="reponseRejet{{ $doleance->id }}" class="form-label">
                                                            Raison du rejet (optionnel)
                                                        </label>
                                                        <textarea name="reponse" id="reponseRejet{{ $doleance->id }}" 
                                                                  class="form-control" rows="4" 
                                                                  placeholder="Expliquez la raison du rejet..."></textarea>
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                    <p>Aucune doléance trouvée</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($doleances->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $doleances->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .badge-primary { background-color: #0d6efd; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-success { background-color: #198754; }
    .badge-danger { background-color: #dc3545; }
    .badge-secondary { background-color: #6c757d; }
    
    .table-info {
        background-color: rgba(13, 110, 253, 0.05) !important;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection