@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-archive"></i> Liste des Archives</h4>
            <div>
                <span class="badge bg-light text-dark me-2">Total: {{ $archives->count() }}</span>
                <button class="btn btn-light btn-sm" onclick="toggleColumnFilter()">
                    <i class="fas fa-columns"></i> Filtrer colonnes
                </button>
            </div>
        </div>
        <div class="card-body">
            
            <!-- Filtre de colonnes (caché par défaut) -->
            <div class="row mb-3 d-none" id="columnFilterContainer">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-header py-2 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="fas fa-filter"></i> Sélection des colonnes</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllColumns()">
                                        <i class="fas fa-check-square"></i> Tout
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllColumns()">
                                        <i class="fas fa-square"></i> Rien
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="applyColumnFilter()">
                                        <i class="fas fa-check"></i> Appliquer
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-2">
                            <div class="row" id="columnFilterCheckboxes">
                                <!-- Les checkboxes seront générées dynamiquement -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary flex-fill" onclick="exportToExcel()">
                            <i class="fas fa-download"></i> Excel
                        </button>
                        <button class="btn btn-outline-success flex-fill" onclick="exportVisibleToExcel()">
                            <i class="fas fa-file-excel"></i> Colonnes visibles
                        </button>
                    </div>
                </div>
            </div>

            <!-- Checkboxes des colonnes visibles -->
            <div class="row mb-2" id="visibleColumnsContainer">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 align-items-center p-2 bg-light rounded border">
                        <span class="fw-bold me-2">Colonnes affichées:</span>
                        <div id="visibleColumnsCheckboxes" class="d-flex flex-wrap gap-2">
                            <!-- Les checkboxes des colonnes visibles seront générées ici -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des archives -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-light" id="tableHeader">
                        <!-- L'en-tête sera généré dynamiquement -->
                    </thead>
                    <tbody id="archiveTableBody">
                        @foreach($archives as $archive)
                        <tr class="archive-row" data-id="{{ $archive->id }}"
                            data-archive='@json($archive)'>
                            <!-- Les données sont stockées dans l'attribut data-archive -->
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
    position: relative;
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

.column-filter-checkbox {
    margin: 5px 0;
    min-width: 200px;
}

#visibleColumnsCheckboxes .form-check {
    margin: 2px;
}

.visible-column-checkbox {
    background-color: white;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 4px 8px;
}

.visible-column-checkbox:hover {
    background-color: #f8f9fa;
}

.column-header {
    position: relative;
}

.column-actions {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
}

.column-header:hover .column-actions {
    display: block;
}

.table-column {
    transition: all 0.3s ease;
}
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Définition des colonnes disponibles
const availableColumns = [
    { id: 'id', label: 'ID', default: true, width: '60' },
    { id: 'exoyear', label: 'Année d\'exercice', default: false, width: '100' },
    { id: 'arrivaldate', label: 'Date d\'arrivée', default: true, width: '120' },
    { id: 'arrivalid', label: 'Réf. Arrivée', default: true, width: '120' },
    { id: 'sendersce', label: 'Service émetteur', default: true, width: '150' },
    { id: 'descentdate', label: 'Date de descente', default: false, width: '120' },
    { id: 'reportid', label: 'ID Rapport', default: false, width: '100' },
    { id: 'summondate', label: 'Date de convocation', default: false, width: '120' },
    { id: 'actiontaken', label: 'Mesure prise', default: true, width: '150' },
    { id: 'measures', label: 'Mesures', default: false, width: '150' },
    { id: 'findingof', label: 'Constats', default: false, width: '150' },
    { id: 'applicantname', label: 'Nom demandeur', default: false, width: '150' },
    { id: 'applicantaddress', label: 'Adresse demandeur', default: false, width: '150' },
    { id: 'applicantcontact', label: 'Contact demandeur', default: false, width: '150' },
    { id: 'locality', label: 'Localité', default: false, width: '120' },
    { id: 'municipality', label: 'Commune', default: true, width: '120' },
    { id: 'property0wner', label: 'Propriétaire', default: true, width: '150' },
    { id: 'propertytitle', label: 'Titre de propriété', default: false, width: '150' },
    { id: 'propertyname', label: 'Nom de propriété', default: false, width: '150' },
    { id: 'urbanplanningregulations', label: 'Règlement urbain', default: false, width: '150' },
    { id: 'upr', label: 'UPR', default: false, width: '80' },
    { id: 'zoning', label: 'Zonage', default: false, width: '100' },
    { id: 'surfacearea', label: 'Surface', default: false, width: '80' },
    { id: 'backfilledarea', label: 'Zone remblayée', default: false, width: '100' },
    { id: 'xv', label: 'XV', default: false, width: '80' },
    { id: 'yv', label: 'YV', default: false, width: '80' },
    { id: 'minutesid', label: 'ID PV', default: false, width: '80' },
    { id: 'minutesdate', label: 'Date PV', default: false, width: '100' },
    { id: 'partsupplied', label: 'Partie fournie', default: false, width: '120' },
    { id: 'submissiondate', label: 'Date soumission', default: false, width: '120' },
    { id: 'destination', label: 'Destination', default: false, width: '120' },
    { id: 'svr_fine', label: 'Amende SVR', default: false, width: '100' },
    { id: 'svr_roalty', label: 'Redevance SVR', default: false, width: '100' },
    { id: 'invoicingid', label: 'ID Facturation', default: false, width: '100' },
    { id: 'invoicingdate', label: 'Date facturation', default: false, width: '120' },
    { id: 'fineamount', label: 'Montant amende', default: false, width: '100' },
    { id: 'roaltyamount', label: 'Montant redevance', default: false, width: '100' },
    { id: 'convention', label: 'Convention', default: false, width: '120' },
    { id: 'payementmethod', label: 'Mode paiement', default: false, width: '120' },
    { id: 'daftransmissiondate', label: 'Date transmission DAF', default: false, width: '140' },
    { id: 'ref_quitus', label: 'Réf. Quitus', default: false, width: '100' },
    { id: 'sit_r', label: 'SIT R', default: false, width: '80' },
    { id: 'sit_a', label: 'SIT A', default: false, width: '80' },
    { id: 'commissiondate', label: 'Date commission', default: false, width: '120' },
    { id: 'commissionopinion', label: 'Avis commission', default: false, width: '150' },
    { id: 'recommandationobs', label: 'Observations recommandation', default: false, width: '150' },
    { id: 'opfinal', label: 'Avis final OP', default: false, width: '120' },
    { id: 'opiniondfdate', label: 'Date avis DF', default: false, width: '120' },
    { id: 'category', label: 'Catégorie', default: false, width: '100' }
];

class ArchiveTable {
    constructor() {
        this.currentPage = 1;
        this.pageSize = 25;
        this.allRows = document.querySelectorAll('.archive-row');
        this.totalRows = this.allRows.length;
        this.filteredRows = Array.from(this.allRows);
        this.selectedColumns = this.getDefaultColumns();
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updatePageSize();
        this.renderColumnFilterCheckboxes();
        this.renderVisibleColumnsCheckboxes();
        this.renderTableHeader();
        this.renderTableBody();
        this.renderPagination();
        this.showPage(1);
    }

    getDefaultColumns() {
        return availableColumns.filter(col => col.default).map(col => col.id);
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

    renderColumnFilterCheckboxes() {
        const container = document.getElementById('columnFilterCheckboxes');
        container.innerHTML = '';
        
        availableColumns.forEach(column => {
            const isChecked = this.selectedColumns.includes(column.id);
            
            const colDiv = document.createElement('div');
            colDiv.className = 'col-md-3 col-sm-4 column-filter-checkbox';
            
            colDiv.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           id="filter_col_${column.id}" 
                           value="${column.id}"
                           ${isChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="filter_col_${column.id}">
                        ${column.label}
                    </label>
                </div>
            `;
            
            container.appendChild(colDiv);
        });
    }

    renderVisibleColumnsCheckboxes() {
        const container = document.getElementById('visibleColumnsCheckboxes');
        container.innerHTML = '';
        
        this.selectedColumns.forEach(columnId => {
            const column = availableColumns.find(c => c.id === columnId);
            if (column) {
                const div = document.createElement('div');
                div.className = 'visible-column-checkbox';
                
                div.innerHTML = `
                    <div class="form-check form-check-inline m-0">
                        <input class="form-check-input" type="checkbox" 
                               id="visible_col_${column.id}" 
                               value="${column.id}"
                               checked
                               onchange="toggleColumnVisibility('${column.id}', this.checked)">
                        <label class="form-check-label" for="visible_col_${column.id}">
                            ${column.label}
                        </label>
                    </div>
                `;
                
                container.appendChild(div);
            }
        });
        
        // Ajouter un bouton pour gérer toutes les colonnes
        const manageDiv = document.createElement('div');
        manageDiv.className = 'd-flex align-items-center ms-2';
        manageDiv.innerHTML = `
            <button class="btn btn-sm btn-outline-secondary" onclick="toggleColumnFilter()" title="Gérer les colonnes">
                <i class="fa fa-plus"></i>+
            </button>
        `;
        container.appendChild(manageDiv);
    }

    renderTableHeader() {
        const header = document.getElementById('tableHeader');
        header.innerHTML = '';
        
        const tr = document.createElement('tr');
        
        // Ajouter l'en-tête pour chaque colonne sélectionnée
        this.selectedColumns.forEach(columnId => {
            const column = availableColumns.find(c => c.id === columnId);
            if (column) {
                const th = document.createElement('th');
                th.className = 'table-column column-header';
                th.style.width = column.width + 'px';
                th.innerHTML = `
                    <span>${column.label}</span>
                    <div class="column-actions">
                        <button class="btn btn-sm btn-link text-danger p-0" 
                                onclick="hideColumn('${column.id}')"
                                title="Masquer cette colonne">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                tr.appendChild(th);
            }
        });
        
        // Ajouter la colonne Actions
        const actionsTh = document.createElement('th');
        actionsTh.className = 'text-center';
        actionsTh.style.width = '80px';
        actionsTh.innerHTML = `
            <span>Actions</span>
            <div class="column-actions">
                <button class="btn btn-sm btn-link text-primary p-0" 
                        onclick="toggleColumnFilter()"
                        title="Gérer les colonnes">
                    <i class="fas fa-cog"></i>
                </button>
            </div>
        `;
        tr.appendChild(actionsTh);
        
        header.appendChild(tr);
    }

    renderTableBody() {
        this.allRows.forEach(row => {
            const archiveData = this.getArchiveData(row);
            row.innerHTML = '';
            
            // Ajouter les cellules pour chaque colonne sélectionnée
            this.selectedColumns.forEach(columnId => {
                const td = document.createElement('td');
                td.className = 'table-column';
                
                // Récupérer la valeur depuis les données
                const value = archiveData[columnId] || null;
                const formattedValue = this.formatCellValue(value, columnId);
                td.innerHTML = formattedValue;
                
                row.appendChild(td);
            });
            
            // Ajouter la cellule Actions
            const actionsTd = document.createElement('td');
            actionsTd.className = 'text-center';
            actionsTd.innerHTML = `
                <a href="/archives/${archiveData.id}" 
                   class="btn btn-sm btn-outline-primary" 
                   title="Voir les détails">
                    <i class="fas fa-eye"></i>+ Voir
                </a>
            `;
            row.appendChild(actionsTd);
        });
    }

    getArchiveData(row) {
        try {
            const dataJson = row.getAttribute('data-archive');
            if (dataJson) {
                return JSON.parse(dataJson);
            }
        } catch (e) {
            console.error('Erreur de parsing JSON:', e);
        }
        return {};
    }

    formatCellValue(value, columnId) {
        if (value === null || value === undefined || value === '') {
            return '<span class="text-muted">-</span>';
        }
        
        switch(columnId) {
            case 'id':
                return `<span class="fw-bold">${value}</span>`;
            case 'arrivalid':
            case 'reportid':
            case 'minutesid':
            case 'invoicingid':
            case 'ref_quitus':
                return `<strong class="text-primary">${value}</strong>`;
            case 'arrivaldate':
            case 'descentdate':
            case 'summondate':
            case 'minutesdate':
            case 'submissiondate':
            case 'invoicingdate':
            case 'daftransmissiondate':
            case 'commissiondate':
            case 'opiniondfdate':
                return `<span class="badge bg-light text-dark">${this.formatDate(value)}</span>`;
            case 'actiontaken':
                return `<span class="badge bg-info text-dark" title="${value}">${this.truncateText(value, 25)}</span>`;
            case 'exoyear':
                return `<span class="badge bg-secondary">${value}</span>`;
            case 'sendersce':
            case 'applicantname':
            case 'municipality':
            case 'locality':
            case 'property0wner':
            case 'propertyname':
                return `<span class="text-truncate" title="${value}">${this.truncateText(value, 20)}</span>`;
            case 'applicantaddress':
                return `<small>${this.truncateText(value, 30)}</small>`;
            case 'fineamount':
            case 'roaltyamount':
            case 'svr_fine':
            case 'svr_roalty':
                if (!isNaN(parseFloat(value))) {
                    return `<span class="text-danger fw-bold">${parseFloat(value).toFixed(2)} €</span>`;
                }
                return value;
            case 'surfacearea':
            case 'backfilledarea':
                if (!isNaN(parseFloat(value))) {
                    return `<span>${parseFloat(value).toFixed(2)} m²</span>`;
                }
                return value;
            case 'commissionopinion':
            case 'opfinal':
                if (typeof value === 'string') {
                    const lowerVal = value.toLowerCase();
                    if (lowerVal.includes('favorable') || lowerVal.includes('apprové') || lowerVal.includes('accepté')) {
                        return `<span class="badge bg-success">${value}</span>`;
                    } else if (lowerVal.includes('défavorable') || lowerVal.includes('rejeté') || lowerVal.includes('refusé')) {
                        return `<span class="badge bg-danger">${value}</span>`;
                    } else {
                        return `<span class="badge bg-warning text-dark">${value}</span>`;
                    }
                }
                return value;
            case 'category':
                return `<span class="badge bg-primary">${value}</span>`;
            case 'upr':
            case 'zoning':
            case 'sit_r':
            case 'sit_a':
                return `<code>${value}</code>`;
            case 'measures':
            case 'findingof':
            case 'recommandationobs':
                return `<small>${this.truncateText(value, 30)}</small>`;
            default:
                return value;
        }
    }

    truncateText(text, maxLength) {
        if (!text) return '';
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }

    formatDate(dateString) {
        if (!dateString) return '-';
        try {
            // Essayer de parser la date
            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                // Si ce n'est pas une date valide, essayer un format spécifique
                const parts = dateString.split('-');
                if (parts.length === 3) {
                    return `${parts[2]}/${parts[1]}/${parts[0]}`;
                }
                return dateString;
            }
            // Formater en dd/mm/yyyy
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        } catch (e) {
            return dateString;
        }
    }

    filterRows(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        
        if (term === '') {
            this.filteredRows = Array.from(this.allRows);
        } else {
            this.filteredRows = Array.from(this.allRows).filter(row => {
                // Rechercher dans toutes les données de la ligne
                const archiveData = this.getArchiveData(row);
                const rowText = Object.values(archiveData)
                    .join(' ')
                    .toLowerCase();
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
        if (items[page]) {
            items[page].classList.add('active');
        }
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

    updateSelectedColumns(columns) {
        // Toujours inclure la colonne ID si elle n'est pas présente
        if (!columns.includes('id')) {
            columns.unshift('id');
        }
        
        this.selectedColumns = columns;
        this.renderColumnFilterCheckboxes();
        this.renderVisibleColumnsCheckboxes();
        this.renderTableHeader();
        this.renderTableBody();
        this.renderPagination();
        this.showPage(1);
    }

    hideColumn(columnId) {
        const newColumns = this.selectedColumns.filter(col => col !== columnId);
        this.updateSelectedColumns(newColumns);
    }

    toggleColumn(columnId, show) {
        if (show && !this.selectedColumns.includes(columnId)) {
            // Ajouter la colonne
            this.selectedColumns.push(columnId);
        } else if (!show && this.selectedColumns.includes(columnId)) {
            // Supprimer la colonne
            this.selectedColumns = this.selectedColumns.filter(col => col !== columnId);
        }
        
        this.renderVisibleColumnsCheckboxes();
        this.renderTableHeader();
        this.renderTableBody();
    }
}

// Variables globales
let archiveTable;

// Fonctions globales
function toggleColumnFilter() {
    const container = document.getElementById('columnFilterContainer');
    container.classList.toggle('d-none');
}

function selectAllColumns() {
    document.querySelectorAll('#columnFilterCheckboxes input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllColumns() {
    document.querySelectorAll('#columnFilterCheckboxes input[type="checkbox"]').forEach(checkbox => {
        if (checkbox.value !== 'id') {
            checkbox.checked = false;
        }
    });
}

function applyColumnFilter() {
    const selectedColumns = [];
    document.querySelectorAll('#columnFilterCheckboxes input[type="checkbox"]:checked').forEach(checkbox => {
        selectedColumns.push(checkbox.value);
    });
    
    archiveTable.updateSelectedColumns(selectedColumns);
    toggleColumnFilter();
}

function toggleColumnVisibility(columnId, show) {
    archiveTable.toggleColumn(columnId, show);
}

function hideColumn(columnId) {
    archiveTable.hideColumn(columnId);
    // Mettre à jour la checkbox correspondante
    const checkbox = document.getElementById(`visible_col_${columnId}`);
    if (checkbox) {
        checkbox.checked = false;
    }
}

// Export Excel de toutes les colonnes
function exportToExcel() {
    const table = document.querySelector('table');
    const workbook = XLSX.utils.table_to_book(table, {sheet: "Archives"});
    XLSX.writeFile(workbook, `archives_${new Date().toISOString().split('T')[0]}.xlsx`);
}

// Export Excel uniquement des colonnes visibles
function exportVisibleToExcel() {
    // Créer une table temporaire avec seulement les colonnes visibles
    const tempTable = document.createElement('table');
    const originalHeader = document.querySelector('#tableHeader tr').cloneNode(true);
    
    // Supprimer la colonne Actions de l'export
    originalHeader.deleteCell(originalHeader.cells.length - 1);
    tempTable.appendChild(originalHeader);
    
    // Ajouter les données visibles
    document.querySelectorAll('.archive-row:not([style*="display: none"])').forEach(row => {
        const clonedRow = row.cloneNode(true);
        clonedRow.deleteCell(clonedRow.cells.length - 1); // Supprimer Actions
        tempTable.appendChild(clonedRow);
    });
    
    const workbook = XLSX.utils.table_to_book(tempTable, {sheet: "Archives"});
    XLSX.writeFile(workbook, `archives_colonnes_${new Date().toISOString().split('T')[0]}.xlsx`);
}

// Initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    archiveTable = new ArchiveTable();
    
    // Afficher un message de confirmation
    console.log(`Tableau des archives initialisé avec ${document.querySelectorAll('.archive-row').length} lignes`);
});
</script>
@endsection