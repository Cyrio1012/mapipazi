@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📋 Liste des AP enregistrées</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Num AP</th>
                <th>Propriétaire</th>
                <th>Commune</th>
                <th>Fokontany</th>
                <th>Zone</th>
                <th>Destination</th>
                <th>Taux</th>
                <th>Descente liée</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aps as $ap)
            <tr>
                <td>{{ $ap->id }}</td>
                <td>{{ $ap->num_ap }}</td>
                <td>{{ $ap->nom_proprietaire }}</td>
                <td>{{ $ap->comm_propriete }}</td>
                <td>{{ $ap->fkt }}</td>
                <td>{{ strtoupper($ap->zone) }}</td>
                <td>{{ strtoupper($ap->destination) }}</td>
                <td>{{ number_format($ap->taux, 0, '', ' ') }} Ar</td>
                <td>
                    @if($ap->descente)
                        {{ $ap->descente->num_pv }} ({{ $ap->descente->date?->format('d/m/Y') }})
                    @else
                        —
                    @endif
                </td>
                <td>
                    <a href="{{ route('aps.show', $ap) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $aps->links() }}
</div>
@endsection
