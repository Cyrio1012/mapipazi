@extends('layouts.app')
@section('title', 'FT')

@section('content')
<div class="container">
  <h2 class="mb-4">📋 Liste des FT</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('fts.create') }}" class="btn btn-primary mb-3">➕ Nouvelle FT</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Numéro</th>
        <th>Commune</th>
        <th>Date FT</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fts as $ft)
        <tr>
          <td>{{ $ft->id }}</td>
          <td>{{ $ft->numero }}</td>
          <td>{{ $ft->commune }}</td>
          <td>{{ $ft->date_ft }}</td>
          <td>
            <a href="{{ route('fts.show', $ft) }}" class="btn btn-sm btn-info">Voir</a>
            <a href="{{ route('fts.edit', $ft) }}" class="btn btn-sm btn-warning">Modifier</a>
            <form action="{{ route('fts.destroy', $ft) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $fts->links() }}
</div>
@endsection
