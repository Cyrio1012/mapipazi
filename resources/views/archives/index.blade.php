@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-archive"></i> Liste des Archives</h4>
            <span class="badge bg-light text-dark">Total: {{ $archives->count() }}</span>
        </div>
        <div class="card-body">
            
            <!-- Statistiques et informations -->
    

            <!-- Barre de recherche et filtres -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i> Recherche
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="pageSize">
                        <option value="10">10 par page</option>
                        <option value="25" selected>25 par page</option>
                        <option value="50">50 par page</option>
                        <option value="100">100 par page</option>
                        <option value="250">250 par page</option>
                        <option value="500">500 par page</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        <button class="btn btn-outline-primary" onclick="exportToExcel()">
                            <i class="fas fa-download"></i> Exporter Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tableau des archives -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="120">Réf. Arrivée</th>
                            <th width="100">Date Arrivée</th>
                            <th>Service</th>
                            <th>Demandeur</th>
                            <th>Commune</th>
                            <th>Propriétaire</th>
                            <th width="80" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="archiveTableBody">
                        @foreach($archives as $archive)
                        <tr class="archive-row">
                            <td class="fw-bold">{{ $archive->id }}</td>
                            <td>
                                <strong class="text-primary">{{ $archive->arrivalid ?? 'N/A' }}</strong>
                                @if($archive->exoyear)
                                    <br><small class="text-muted">Année: {{ $archive->exoyear }}</small>
                                @endif
                            </td>
                            <td>
                                @if($archive->arrivaldate)
                                    <span class="badge bg-light text-dark">
                                        {{ \Carbon\Carbon::parse($archive->arrivaldate)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-truncate">{{ $archive->sendersce ?? '-' }}</span>
                            </td>
                            <td>
                                @if($archive->actiontaken)
                                    <span class="badge bg-info text-dark" title="{{ $archive->actiontaken }}">
                                        {{ Str::limit($archive->actiontaken, 25) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            
                            <td>
                                @if($archive->municipality)
                                    <div>
                                        <strong>{{ $archive->municipality }}</strong>
                                        @if($archive->locality)
                                            <br><small class="text-muted">{{ $archive->locality }}</small>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($archive->property0wner)
                                    <span class="text-truncate">{{ Str::limit($archive->property0wner, 20) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('archives.show', $archive->id) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Voir les détails">
                                    <i class="fas fa-eye"></i>+ Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Affichage de <span id="startRow">1</span> à <span id="endRow">{{ min(25, $archives->count()) }}</span> 
                    sur <strong id="totalRows">{{ $archives->count() }}</strong> archives
                </div>
                <nav>
                    <ul class="pagination mb-0" id="pagination">
                        <!-- La pagination sera générée par JavaScript -->
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
.archive-row:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.table th {
    border-top: 2px solid #dee2e6;
    font-weight: 600;
    background-color: #f8f9fa;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.pagination .page-link {
    color: #0d6efd;
}

.pagination .page-link:hover {
    color: #0a58ca;
}

.badge {
    font-size: 0.75em;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
    display: inline-block;
}
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
class ArchiveTable {
    constructor() {
        this.currentPage = 1;
        this.pageSize = 25;
        this.allRows = document.querySelectorAll('.archive-row');
        this.totalRows = this.allRows.length;
        this.filteredRows = Array.from(this.allRows);
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updatePageSize();
        this.renderPagination();
        this.showPage(1);
    }

    setupEventListeners() {
        // Recherche en temps réel
        document.getElementById('searchInput').addEventListener('input', (e) => {
            this.filterRows(e.target.value);
        });

        // Effacer la recherche
        document.getElementById('clearSearch').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            this.filterRows('');
        });

        // Changer la taille de page
        document.getElementById('pageSize').addEventListener('change', (e) => {
            this.pageSize = parseInt(e.target.value);
            this.currentPage = 1;
            this.renderPagination();
            this.showPage(1);
        });
    }

    filterRows(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        
        if (term === '') {
            this.filteredRows = Array.from(this.allRows);
        } else {
            this.filteredRows = Array.from(this.allRows).filter(row => {
                const rowText = row.textContent.toLowerCase();
                return rowText.includes(term);
            });
        }

        this.currentPage = 1;
        this.renderPagination();
        this.showPage(1);
        this.updateRowCount();
    }

    showPage(page) {
        // Cacher toutes les lignes
        this.allRows.forEach(row => row.style.display = 'none');
        
        // Afficher les lignes de la page courante
        const start = (page - 1) * this.pageSize;
        const end = start + this.pageSize;
        
        this.filteredRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        // Mettre à jour la pagination active
        this.updatePaginationActive(page);
        this.updateRowCount(start, end);
    }

    renderPagination() {
        const totalPages = Math.ceil(this.filteredRows.length / this.pageSize);
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        // Bouton Précédent
        const prevLi = this.createPaginationItem('Précédent', this.currentPage - 1, this.currentPage === 1);
        pagination.appendChild(prevLi);

        // Pages numérotées
        for (let i = 1; i <= totalPages; i++) {
            const li = this.createPaginationItem(i.toString(), i, false, i === this.currentPage);
            pagination.appendChild(li);
        }

        // Bouton Suivant
        const nextLi = this.createPaginationItem('Suivant', this.currentPage + 1, this.currentPage === totalPages);
        pagination.appendChild(nextLi);
    }

    createPaginationItem(text, page, disabled = false, active = false) {
        const li = document.createElement('li');
        li.className = 'page-item';
        
        if (disabled) li.classList.add('disabled');
        if (active) li.classList.add('active');

        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = text;
        
        if (!disabled) {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                this.currentPage = page;
                this.showPage(page);
                this.renderPagination();
            });
        }

        li.appendChild(a);
        return li;
    }

    updatePaginationActive(page) {
        document.querySelectorAll('.page-item').forEach(item => {
            item.classList.remove('active');
        });
        
        const items = document.querySelectorAll('.page-item');
        items[page].classList.add('active'); // +1 car le premier est "Précédent"
    }

    updateRowCount(start = 0, end = 0) {
        const total = this.filteredRows.length;
        const displayStart = total > 0 ? start + 1 : 0;
        const displayEnd = Math.min(end, total);

        document.getElementById('startRow').textContent = displayStart;
        document.getElementById('endRow').textContent = displayEnd;
        document.getElementById('totalRows').textContent = total;
    }

    updatePageSize() {
        document.getElementById('pageSize').value = this.pageSize;
    }
}

// Export Excel
function exportToExcel() {
    const table = document.querySelector('table');
    const workbook = XLSX.utils.table_to_book(table, {sheet: "Archives"});
    XLSX.writeFile(workbook, `archives_${new Date().toISOString().split('T')[0]}.xlsx`);
}

// Initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    new ArchiveTable();
    
    // Afficher un message de confirmation
    console.log(`Tableau des archives initialisé avec ${document.querySelectorAll('.archive-row').length} lignes`);
});
</script>
@endsection