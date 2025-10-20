@extends('layouts.app')
@section('title', 'Descente')
@section('content')
<div class="container">
    <h2 class="mb-4">📋 Liste des descentes</h2>

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <a href="{{ route('descentes.create') }}" class="btn btn-primary mb-3">➕ Nouvelle descente</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Réf. OM</th>
                <th>Réf. PV</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($descentes as $descente)
                <tr>
                    <td>{{ $descente->id }}</td>
                    <td>{{ $descente->date }}</td>
                    <td>{{ $descente->heure }}</td>
                    <td>{{ $descente->ref_om }}</td>
                    <td>{{ strtoupper($descente->ref_pv) }}</td>
                    <td>{{ $descente->dist }}</td>
                    <td>
                        <a href="{{ route('descentes.show', $descente->id) }}" class="btn btn-sm btn-outline-info">👁️ Voir</a>
                        <a href="{{ route('descentes.edit', $descente->id) }}" class="btn btn-sm btn-outline-warning">✏️ Modifier</a>
                        <form action="{{ route('descentes.destroy', $descente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette descente ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $descentes->links() }}
</div>
@endsection
