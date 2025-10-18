@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🔍 Détail FT #{{ $ft->id }}</h2>

    {{-- 📍 Localisation --}}
    <div class="card mb-3">
        <div class="card-header bg-warning text-dark">📍 Localisation</div>
        <div class="card-body">
            <p><strong>District :</strong> {{ $ft->dist_desc }}</p>
            <p><strong>Commune :</strong> {{ $ft->comm_desc }}</p>
            <p><strong>Fokontany :</strong> {{ $ft->fkt_desc }}</p>
            <p><strong>Coordonnées :</strong> {{ $ft->x_desc }}, {{ $ft->y_desc }}</p>
        </div>
    </div>

    {{-- 🔍 Constat --}}
    <div class="card mb-3">
        <div class="card-header bg-info text-white">🔍 Constat</div>
        <div class="card-body">
            @forelse ($ft->constat_desc ?? [] as $c)
                <span class="badge bg-warning text-dark me-1">{{ $c }}</span>
            @empty
                <em>Aucun constat</em>
            @endforelse
        </div>
    </div>

    {{-- 📝 Informations FT --}}
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">📝 Informations FT</div>
        <div class="card-body">
            <p><strong>Numéro FT :</strong> {{ $ft->num_ft }}</p>
            <p><strong>Motif :</strong> {{ $ft->antony_ft }}</p>
            <p><strong>Zone :</strong> {{ strtoupper($ft->zone) }}</p>
            <p><strong>Destination :</strong> {{ strtoupper($ft->destination) }}</p>
        </div>
    </div>
    <a href="{{ route('fts.export.pdf', $ft->id) }}" class="btn btn-outline-secondary mb-3">
    🖨️ Imprimer / Exporter PDF
    </a>
</div>
@endsection
