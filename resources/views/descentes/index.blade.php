@extends('layouts.app')
@section('title', 'Descente')
@section('content')

<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="h4 mb-1">Liste des descentes</h2>
      <p class="text-muted mb-0">Gestion des procès-verbaux de descente</p>
    </div>
    @if(auth()->user()->statut === 'agent')
    <a href="{{ route('descentes.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-2"></i>Nouvelle descente
    </a>
    @endif
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="descentesTable" class="table table-hover datatable" style="width:100%">
          <thead>
            <tr>
              <th>Num PV</th>
              <th>Date & Heure</th>
              <th>Personne R.</th>
              <th>Réf. OM</th>
              <th>Réf. PV</th>
              <th>Fokontany</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($descentes as $descente)
              <tr>
                <td>
                  <span class="table-badge">
                    {{ str_pad($descente->num_pv, 3, '0', STR_PAD_LEFT) }}
                  </span>
                </td>
                <td>
                  <div class="fw-medium">{{ $descente->date?->format('d/m/Y') }}</div>
                  <small class="text-muted">{{ $descente->heure?->format('H:i') }}</small>
                </td>
                <td>{{ $descente->pers_verb }}</td>
                <td>
                  <span class="text-primary">{{ $descente->ref_om }}</span>
                </td>
                <td>
                  <code>{{ strtoupper($descente->ref_pv) }}</code>
                </td>
                <td>{{ $descente->fkt }}</td>
                <td>
                  <div class="d-flex justify-content-end gap-1">
                    <a href="{{ route('descentes.show', $descente->id) }}" 
                       class="btn btn-sm btn-light" 
                       data-bs-toggle="tooltip" title="Voir détails">
                      <i class="bi bi-eye"></i>
                    </a>
                    @if(auth()->user()->statut === 'agent')
                    <a href="{{ route('descentes.edit', $descente->id) }}" 
                       class="btn btn-sm btn-light"
                       data-bs-toggle="tooltip" title="Modifier">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('descentes.destroy', $descente->id) }}" method="POST" 
                          class="d-inline" onsubmit="return confirm('Supprimer cette descente ?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-light text-danger"
                              data-bs-toggle="tooltip" title="Supprimer">
                        <i class="bi bi-trash"></i>
                      </button>
                      @endif
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <div class="text-muted">
                    <i class="bi bi-inbox display-6 mb-3"></i>
                    <p class="mb-0">Aucune descente effectuée.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<style>
  .card {
    border-radius: 8px;
    border: 1px solid #e9ecef;
    padding: 20px;
  }
  

  
  .datatable thead th {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    color: #495057;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 1rem 0.75rem;
    text-transform: none;
    letter-spacing: normal;
  }
  
  .datatable tbody td {
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 0.75rem;
    vertical-align: middle;
    color: #6c757d;
    background: white;
  }
  
  .datatable tbody tr {
    transition: all 0.15s ease;
  }
  
  .datatable tbody tr:hover {
    background-color: #f8f9fa;
  }
  
  /* Style des contrôles DataTables comme l'image */
  .dataTables_wrapper .dataTables_length {
    padding: 1rem 1.25rem 0.5rem;
    color: #6c757d;
    font-size: 0.875rem;
  }
  
  .dataTables_wrapper .dataTables_length select {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0.25rem 2rem 0.25rem 0.5rem;
    font-size: 0.875rem;
    margin: 0 0.5rem;
    background-color: white;
  }
  
  .dataTables_wrapper .dataTables_filter {
    padding: 1rem 1.25rem 0.5rem;
    color: #6c757d;
    font-size: 0.875rem;
  }
  
  .dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0.25rem 0.75rem;
    margin-left: 0.5rem;
    font-size: 0.875rem;
    background-color: white;
  }
  
  .dataTables_wrapper .dataTables_info {
    padding: 1rem 1.25rem;
    color: #6c757d;
    font-size: 0.875rem;
    border-top: 1px solid #e9ecef;
  }
  
  .dataTables_wrapper .dataTables_paginate {
    padding: 0.75rem 1.25rem;
    border-top: 1px solid #e9ecef;
  }
  
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 0.375rem 0.75rem;
    margin: 0 0.15rem;
    color: #0060a0;
    background: white;
    font-size: 0.875rem;
  }
  
  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #0060a0;
    border-color: #0060a0;
    color: white !important;
  }
  
  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e9ecef;
    border-color: #adb5bd;
    color: #064272 !important;
  }
  
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    color: #6c757d !important;
    background: #f8f9fa;
    border-color: #dee2e6;
  }
  
  /* Badge moderne comme dans l'image */
  .table-badge {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-family: 'Courier New', monospace;
    color: #495057;
    font-weight: 500;
  }
  
  /* Boutons d'action discrets */
  .btn-sm {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    border: 1px solid #dee2e6;
    background: white;
    color: #6c757d;
  }
  
  .btn-sm:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
  }
  
  /* Style pour les états vides */
  .datatable tbody tr td.text-center {
    background: white;
    border-bottom: 1px solid #e9ecef;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      text-align: left;
      padding: 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      width: 100%;
      margin: 0.25rem 0;
    }
  }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script>
  $(document).ready(function() {
    // Initialisation de DataTable avec le style de l'image
    $('#descentesTable').DataTable({
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
      },
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      order: [[0, 'desc']],
      responsive: true,
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      columnDefs: [
        {
          targets: -1,
          orderable: false,
          searchable: false
        }
      ],
      initComplete: function() {
        // Style cohérent avec le design de l'image
        $('.dataTables_length select').addClass('form-select form-select-sm');
        $('.dataTables_filter input').addClass('form-control form-control-sm');
        
        // Ajouter les labels comme dans l'image
        $('.dataTables_length').prepend('<span class="me-2">Afficher</span>');
        $('.dataTables_length').append('<span class="ms-2">entrées</span>');
        $('.dataTables_filter label').contents().filter(function() {
          return this.nodeType === 3;
        }).remove();
        $('.dataTables_filter label').prepend('Rechercher :');
      }
    });
    
    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
</script>
@endpush

@endsection