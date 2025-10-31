@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📄 Détails de l'AP n°{{ $ap->num_ap ?? $ap->id }}</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Propriétaire :</strong> {{ $ap->nom_proprietaire }}</p>
            <p><strong>Type :</strong> {{ $ap->type }}</p>
            <p><strong>Date AP :</strong> {{ $ap->date_ap?->format('d/m/Y') }}</p>
            <p><strong>Superficie remblais :</strong> {{ $ap->sup_remblais }} m²</p>
            <p><strong>Commune propriété :</strong> {{ $ap->comm_propriete }}</p>
            <p><strong>Coordonnées :</strong> X: {{ $ap->x }} | Y: {{ $ap->y }}</p>
            <p><strong>Fokontany :</strong> {{ $ap->fkt }}</p>
            <p><strong>Zone :</strong> {{ strtoupper($ap->zone) }}</p>
            <p><strong>Titre :</strong> {{ $ap->titre }}</p>
            <p><strong>Destination :</strong> {{ strtoupper($ap->destination) }}</p>
            <p><strong>Taux :</strong> {{ number_format($ap->taux, 0, '', ' ') }} Ar</p>
            <p><strong>Taux payé :</strong> {{ number_format($ap->taux_payer, 0, '', ' ') }} Ar</p>
            <p><strong>Date de notification :</strong> {{ $ap->notifier?->format('d/m/Y') }}</p>
            <p><strong>Délai MD :</strong> {{ $ap->delais_md }} jours</p>
            <p><strong>Situation :</strong> {{ $ap->situation }}</p>

            @if($ap->descente)
                <hr>
                <h5>📌 Descente liée</h5>
                <p><strong>Numéro PV :</strong> {{ $ap->descente->num_pv }}</p>
                <p><strong>Date :</strong> {{ $ap->descente->date?->format('d/m/Y') }}</p>
                <p><strong>Fokontany :</strong> {{ $ap->descente->fkt }}</p>
            @endif
            <a href="{{ route('aps.export', $ap->id) }}" class="btn btn-outline-danger mt-3">
                🧾 Exporter en PDF
            </a>

        </div>
    </div>
</div>
@endsection
