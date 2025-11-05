@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Archives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.075);
        }
        .badge-status {
            font-size: 0.75em;
        }
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-archive"></i> Liste des Archives
                            </h4>
                            <span class="badge bg-light text-dark">
                                Total: {{ $archives->total() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Barre de recherche et filtres -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{ route('archives.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Rechercher..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown">
                                        Trier par
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'date_arriv_desc']) }}">Date arrivée (récent)</a></li>
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'date_arriv_asc']) }}">Date arrivée (ancien)</a></li>
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'ref_arriv']) }}">Référence</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tableau des archives -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Réf. Arrivée</th>
                                        <th>Date Arrivée</th>
                                        <th>Service</th>
                                        <th>Action</th>
                                        <th>Adresse</th>
                                        <th>Commune</th>
                                        <th>Propriétaire</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($archives as $archive)
                                        <tr>
                                            <td>{{ $archive->id }}</td>
                                            <td>
                                                <strong>{{ $archive->ref_arriv ?? 'N/A' }}</strong>
                                            </td>
                                            <td>
                                                @if($archive->date_arriv)
                                                    {{ $archive->date_arriv->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $archive->sce_envoyeur ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">{{ $archive->action ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($archive->adresse, 30) ?? '-' }}</small>
                                            </td>
                                            <td>{{ $archive->commune ?? '-' }}</td>
                                            <td>{{ Str::limit($archive->proprio, 20) ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('archives.show', $archive->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <br>
                                                Aucune archive trouvée
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($archives->hasPages())
                        <div class="row mt-3">
                            <div class="col-12">
                                <nav aria-label="Pagination">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-0">
                                                Affichage de {{ $archives->firstItem() }} à {{ $archives->lastItem() }} 
                                                sur {{ $archives->total() }} archives
                                            </p>
                                        </div>
                                        <ul class="pagination mb-0">
                                            {{ $archives->links() }}
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        @endif
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