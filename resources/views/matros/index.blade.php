@extends('layouts.app')
@if(auth()->user()->statut === 'agent' || auth()->user()->statut === 'admin' )
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-semibold">🚛 Matériels roulants</h2>
    <a href="{{ route('matros.create') }}" class="btn btn-outline-dark rounded-pill">➕ Ajouter</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Désignation</th>
          <th>Marque</th>
          <th>Type</th>
          <th>IMM</th>
          <th>Volume</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($matros as $matro)
          <tr>
            <td>{{ $matro->id }}</td>
            <td>{{ $matro->designation }}</td>
            <td>{{ $matro->marque }}</td>
            <td>{{ $matro->type }}</td>
            <td>{{ $matro->imm }}</td>
            <td>{{ $matro->volume }}</td>
            <td class="text-end">
              <a href="{{ route('matros.edit', $matro) }}" class="btn btn-sm btn-outline-secondary">✏️</a>
              <form action="{{ route('matros.destroy', $matro) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce matériel ?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">🗑️</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">Aucun matériel trouvé.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $matros->links() }}
  </div>
</div>
@endsection
@else
    @php
        abort(404);
    @endphp
@endif