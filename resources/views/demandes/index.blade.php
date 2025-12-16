@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-file-alt"></i> Liste des Demandes</h4>
            <div>
                <span class="badge bg-light text-dark me-2">Total: {{ $demandes->count() }}</span>
                <a href="{{ route('demandes.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle demande
                </a>
                <button class="btn btn-light btn-sm ms-2" onclick="toggleColumnFilter()">
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
                            <i class="fas fa-times"></i> Effacer
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

            <!-- Tableau des demandes -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-light" id="tableHeader">
                        <!-- L'en-tête sera généré dynamiquement -->
                    </thead>
                    <tbody id="demandeTableBody">
                        @foreach($demandes as $demande)
                        <tr class="demande-row" data-id="{{ $demande->id }}"
                            data-demande='@json($demande)'>
                            <!-- Les données sont stockées dans l'attribut data-demande -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Affichage de <span id="startRow">1</span> à <span id="endRow">{{ min(25, $demandes->count()) }}</span> 
                    sur <strong id="totalRows">{{ $demandes->count() }}</strong> demandes
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
.demande-row:hover {
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

.status-badge {
    font-size: 0.7em;
    padding: 3px 8px;
}

/* Ajout pour la cellule Actions */
.actions-cell {
    white-space: nowrap;
}
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Définition des colonnes disponibles pour les demandes
const availableColumns = [
    { id: 'id', label: 'ID', default: true, width: '60' },
    { id: 'exoyear', label: 'Année d\'exercice', default: true, width: '100' },
    { id: 'arrivaldate', label: 'Date d\'arrivée', default: true, width: '120' },
    { id: 'arrivalid', label: 'Réf. Arrivée', default: true, width: '120' },
    { id: 'sendersce', label: 'Service émetteur', default: true, width: '150' },
    { id: 'applicantname', label: 'Nom du demandeur', default: true, width: '180' },
    { id: 'applicantaddress', label: 'Adresse du demandeur', default: false, width: '200' },
    { id: 'propertyname', label: 'Nom de la propriété', default: true, width: '180' },
    { id: 'propertyowner', label: 'Propriétaire', default: true, width: '180' },
    { id: 'propertytitle', label: 'Titre de propriété', default: false, width: '150' },
    { id: 'locality', label: 'Localité', default: true, width: '120' },
    { id: 'municipality', label: 'Commune', default: true, width: '120' },
    { id: 'surfacearea', label: 'Surface (m²)', default: true, width: '100' },
    { id: 'backfilledarea', label: 'Surface remblayée (m²)', default: false, width: '130' },
    { id: 'roaltyamount', label: 'Montant ', default: true, width: '130' },
    { id: 'xv', label: 'Coordonnée X', default: false, width: '100' },
    { id: 'yv', label: 'Coordonnée Y', default: false, width: '100' },
    { id: 'upr', label: 'UPR', default: true, width: '80' },
    { id: 'sit_r', label: 'SIT_R', default: true, width: '80' },
    { id: 'category', label: 'Catégorie', default: true, width: '120' },
    { id: 'opfinal', label: 'Avis final OP', default: true, width: '120' },
    { id: 'invoicingid', label: 'Réf. Facturation', default: false, width: '120' },
    { id: 'invoicingdate', label: 'Date de facturation', default: false, width: '130' },
    { id: 'commissiondate', label: 'Date commission', default: false, width: '130' },
    { id: 'commissionopinion', label: 'Avis commission', default: false, width: '150' },
    { id: 'opiniondfdate', label: 'Date avis DF', default: false, width: '120' },
    { id: 'urbanplanningregulations', label: 'Règlements d\'urbanisme', default: false, width: '180' }
];

class DemandeTable {
    constructor() {
        this.currentPage = 1;
        this.pageSize = 25;
        this.allRows = document.querySelectorAll('.demande-row');
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
                <i class="fas fa-plus"></i>
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
        actionsTh.className = 'text-center actions-cell';
        actionsTh.style.width = '100px';
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
            const demandeData = this.getDemandeData(row);
            row.innerHTML = '';
            
            // Ajouter les cellules pour chaque colonne sélectionnée
            this.selectedColumns.forEach(columnId => {
                const td = document.createElement('td');
                td.className = 'table-column';
                
                // Récupérer la valeur depuis les données
                const value = demandeData[columnId] || null;
                const formattedValue = this.formatCellValue(value, columnId);
                td.innerHTML = formattedValue;
                
                row.appendChild(td);
            });
            
            // Ajouter la cellule Actions
            const actionsTd = document.createElement('td');
            actionsTd.className = 'text-center actions-cell';
            actionsTd.innerHTML = `
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/demandes/${demandeData.id}" 
                       class="btn btn-outline-info" 
                       title="Voir les détails">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/demandes/${demandeData.id}/edit" 
                       class="btn btn-outline-warning" 
                       title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger" 
                            onclick="confirmDelete(${demandeData.id})"
                            title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            row.appendChild(actionsTd);
        });
    }

    getDemandeData(row) {
        try {
            const dataJson = row.getAttribute('data-demande');
            if (dataJson) {
                const data = JSON.parse(dataJson);
                // Convertir les dates pour le formatage
                if (data.arrivaldate) data.arrivaldate = new Date(data.arrivaldate);
                if (data.invoicingdate) data.invoicingdate = new Date(data.invoicingdate);
                if (data.commissiondate) data.commissiondate = new Date(data.commissiondate);
                if (data.opiniondfdate) data.opiniondfdate = new Date(data.opiniondfdate);
                return data;
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
            case 'invoicingid':
                return `<strong class="text-primary">${value}</strong>`;
            case 'arrivaldate':
            case 'invoicingdate':
            case 'commissiondate':
            case 'opiniondfdate':
                if (value instanceof Date && !isNaN(value)) {
                    return `<span class="badge bg-light text-dark">${this.formatDate(value)}</span>`;
                } else if (typeof value === 'string') {
                    return `<span class="badge bg-light text-dark">${this.formatDateString(value)}</span>`;
                }
                return value;
            case 'exoyear':
                return `<span class="badge bg-secondary">${value}</span>`;
            case 'applicantname':
            case 'propertyowner':
                return `<span class="fw-bold">${this.truncateText(value, 25)}</span>`;
            case 'applicantaddress':
                return `<small>${this.truncateText(value, 30)}</small>`;
            case 'propertyname':
                return `<span class="text-truncate" title="${value}">${this.truncateText(value, 20)}</span>`;
            case 'propertytitle':
                return `<code>${this.truncateText(value, 15)}</code>`;
            case 'locality':
            case 'municipality':
                return `<span>${value}</span>`;
            case 'sendersce':
                return `<span class="badge bg-info text-dark">${value}</span>`;
            case 'roaltyamount':
                if (!isNaN(parseFloat(value))) {
                    return `<span class="text-success fw-bold">${parseFloat(value).toFixed(2)} €</span>`;
                }
                return value;
            case 'surfacearea':
            case 'backfilledarea':
                if (!isNaN(parseFloat(value))) {
                    return `<span>${parseFloat(value).toFixed(2)} m²</span>`;
                }
                return value;
            case 'xv':
            case 'yv':
                if (!isNaN(parseFloat(value))) {
                    return `<span>${parseFloat(value).toFixed(4)}</span>`;
                }
                return value;
            case 'upr':
            case 'sit_r':
                return `<code class="bg-light px-1 rounded">${value}</code>`;
            case 'category':
                const categoryColors = {
                    'A': 'bg-primary',
                    'B': 'bg-success',
                    'C': 'bg-warning',
                    'D': 'bg-danger'
                };
                const color = categoryColors[value] || 'bg-secondary';
                return `<span class="badge ${color}">${value}</span>`;
            case 'opfinal':
                if (typeof value === 'string') {
                    const lowerVal = value.toLowerCase();
                    if (lowerVal.includes('favorable') || lowerVal.includes('apprové') || lowerVal.includes('accepté')) {
                        return `<span class="badge bg-success">Favorable</span>`;
                    } else if (lowerVal.includes('défavorable') || lowerVal.includes('rejeté') || lowerVal.includes('refusé')) {
                        return `<span class="badge bg-danger">Défavorable</span>`;
                    } else {
                        return `<span class="badge bg-warning text-dark">${value}</span>`;
                    }
                }
                return value;
            case 'commissionopinion':
                return `<small>${this.truncateText(value, 40)}</small>`;
            case 'urbanplanningregulations':
                return `<small class="text-truncate d-block" style="max-width: 250px;">${value}</small>`;
            default:
                return value;
        }
    }

    truncateText(text, maxLength) {
        if (!text) return '';
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }

    formatDate(date) {
        if (!date) return '-';
        if (date instanceof Date && !isNaN(date.getTime())) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
        return date;
    }

    formatDateString(dateString) {
        if (!dateString) return '-';
        try {
            const parts = dateString.split('-');
            if (parts.length === 3) {
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            return dateString;
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
                const demandeData = this.getDemandeData(row);
                const rowText = Object.values(demandeData)
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
let demandeTable;

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
    
    demandeTable.updateSelectedColumns(selectedColumns);
    toggleColumnFilter();
}

function toggleColumnVisibility(columnId, show) {
    demandeTable.toggleColumn(columnId, show);
}

function hideColumn(columnId) {
    demandeTable.hideColumn(columnId);
    // Mettre à jour la checkbox correspondante
    const checkbox = document.getElementById(`visible_col_${columnId}`);
    if (checkbox) {
        checkbox.checked = false;
    }
}

// Fonction de confirmation pour la suppression
function confirmDelete(demandeId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')) {
        // Créer un formulaire de suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/demandes/${demandeId}`;
        form.style.display = 'none';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Export Excel de toutes les colonnes
function exportToExcel() {
    const table = document.querySelector('table');
    const workbook = XLSX.utils.table_to_book(table, {sheet: "Demandes"});
    XLSX.writeFile(workbook, `demandes_${new Date().toISOString().split('T')[0]}.xlsx`);
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
    document.querySelectorAll('.demande-row:not([style*="display: none"])').forEach(row => {
        const clonedRow = row.cloneNode(true);
        clonedRow.deleteCell(clonedRow.cells.length - 1); // Supprimer Actions
        tempTable.appendChild(clonedRow);
    });
    
    const workbook = XLSX.utils.table_to_book(tempTable, {sheet: "Demandes"});
    XLSX.writeFile(workbook, `demandes_colonnes_${new Date().toISOString().split('T')[0]}.xlsx`);
}

// Initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    demandeTable = new DemandeTable();
    
    // Afficher un message de confirmation
    console.log(`Tableau des demandes initialisé avec ${document.querySelectorAll('.demande-row').length} lignes`);
});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
    });
</script>
@endif
@endsection