@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-archive"></i> Liste des Archives</h4>
            <span class="badge bg-light text-dark">Total: {{ $archives->count() }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="archivesTable" class="table table-striped table-hover">
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
                        @foreach($archives as $archive)
                        <tr>
                            <td>{{ $archive->id }}</td>
                            <td>{{ $archive->ref_arriv ?? 'N/A' }}</td>
                            <td>{{ $archive->date_arriv ? $archive->date_arriv->format('d/m/Y') : '-' }}</td>
                            <td>{{ $archive->sce_envoyeur ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $archive->action ?? '-' }}</span></td>
                            <td>{{ Str::limit($archive->adresse, 30) ?? '-' }}</td>
                            <td>{{ $archive->commune ?? '-' }}</td>
                            <td>{{ Str::limit($archive->proprio, 20) ?? '-' }}</td>
                            <td>
                                <a href="{{ route('archives.show', $archive->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function () {
    $('#archivesTable').DataTable({
        language: {
            "emptyTable": "Aucune archive trouvée",
            "info": "Affichage des lignes _START_ à _END_ sur _TOTAL_ archives",
            "infoEmpty": "Affichage de 0 à 0 sur 0 archives",
            "infoFiltered": "(filtrées depuis _MAX_ archives au total)",
            "infoThousands": " ",
            "lengthMenu": "Afficher _MENU_ archives",
            "loadingRecords": "Chargement...",
            "processing": "Traitement...",
            "search": "Rechercher :",
            "zeroRecords": "Aucune archive correspondante trouvée",
            "paginate": {
                "first": "Première",
                "last": "Dernière",
                "next": "Suivante",
                "previous": "Précédente"
            },
            "aria": {
                "sortAscending": ": tri croissant",
                "sortDescending": ": tri décroissant"
            }
        },
        dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copier',
                className: 'btn btn-sm btn-outline-secondary',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-outline-success',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-outline-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimer',
                className: 'btn btn-sm btn-outline-info',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        responsive: true,
        pageLength: 50,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        order: [[0, 'asc']],
        stateSave: true
    });
});
</script>
@endsection