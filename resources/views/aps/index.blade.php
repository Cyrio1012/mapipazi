@extends('layouts.app')

@section('content')

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-semibold">Liste des AP Etablie</h2>
  </div>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
            <th>Num AP</th>
            <th>Propriétaire</th>
            <th>Commune</th>
            <th>Type</th>
            <th>Taux</th>
            <th>Descente liée</th>
            <th>Situation</th>
            <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($aps as $ap)
            <tr>
                <td>{{ str_pad($ap->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $ap->nom_proprietaire }}</td>
                <td>{{ $ap->comm_propriete }}</td>
                <td>{{ $ap->type }}</td>
                <td>{{ number_format($ap->taux, 0, '', ' ') }} Ar</td>
                <td>
                    @if($ap->descente)
                        {{ $ap->descente->num_pv }} ({{ $ap->descente->date?->format('d/m/Y') }})
                    @else
                        —
                    @endif
                </td>
                <td>{{ strtoupper($ap->situation) }}</td>
                <td>
                    <a href="{{ route('aps.show', $ap) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                </td>
            </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">Aucune AP etablie.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $aps->links() }}
  </div>
</div>
@endsection
