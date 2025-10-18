@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🔍 Détail de la descente #{{ $descente->id }}</h2>

    <a href="{{ route('descentes.index') }}" class="btn btn-secondary mb-3">⬅️ Retour à la liste</a>
    <a href="{{ route('fts.create.from.descente', $descente->id) }}" class="btn btn-outline-primary mb-3">➕Nouvelle FT liée</a>
    <a href="{{ route('descentes.edit', $descente->id) }}" class="btn btn-outline-warning mb-3">✏️ Modifier</a>

    {{-- Détail de la descente --}}
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">🗓️ Informations générales</div>
        <div class="card-body">
            <p><strong>Date :</strong> {{ $descente->date }}</p>
            <p><strong>Heure :</strong> {{ $descente->heure }}</p>
            <p><strong>Réf. OM :</strong> {{ $descente->ref_om }}</p>
            <p><strong>Réf. PV :</strong> {{ $descente->ref_pv }}</p>
            <p><strong>Réf. Rapport :</strong> {{ $descente->ref_rapport }}</p>
            <p><strong>Numéro PV :</strong> {{ $descente->num_pv }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-success text-white">👥 Équipe & Actions</div>
        <div class="card-body">
            
          <p><strong>👥 Équipe :</strong>
              @forelse ($descente->equipe ?? '[]' as $role)
                  <span class="badge bg-secondary me-1">🌿 {{ $role }}</span>
              @empty
                  <em>Aucune donnée</em>
              @endforelse
          </p>

          {{-- 🛠️ Actions --}}
          <p><strong>🛠️ Actions :</strong>
              @forelse ($descente->action ?? '[]' as $act)
                  <span class="badge bg-success me-1">🛠️ {{ $act }}</span>
              @empty
                  <em>Aucune action</em>
              @endforelse
          </p>

          {{-- 🔍 Constats --}}
          <p><strong>🔍 Constats :</strong>
              @forelse ($descente->constat ?? '[]' as $c)
                  <span class="badge bg-warning text-dark me-1">🔍 {{ $c }}</span>
              @empty
                  <em>Aucun constat</em>
              @endforelse
          </p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-info text-white">🧍 Personnes & Contact</div>
        <div class="card-body">
            <p><strong>Personne verbalisée :</strong> {{ $descente->pers_verb }}</p>
            <p><strong>Quantité personnes :</strong> {{ $descente->qte_pers }}</p>
            <p><strong>Adresse :</strong> {{ $descente->adresse }}</p>
            <p><strong>Contact :</strong> {{ $descente->contact }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-warning text-dark">📍 Localisation</div>
        <div class="card-body">
            <p><strong>District :</strong> {{ $descente->dist }}</p>
            <p><strong>Commune :</strong> {{ $descente->comm }}</p>
            <p><strong>Fokontany :</strong> {{ $descente->fkt }}</p>
            <p><strong>Coordonnées :</strong> {{ $descente->x }}, {{ $descente->y }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">📅 RDV & Pièces</div>
        <div class="card-body">
            <p><strong>Date RDV FT :</strong> {{ $descente->date_rdv_ft }}</p>
            <p><strong>Heure RDV FT :</strong> {{ $descente->heure_rdv_ft }}</p>

            <p><strong>📎 Pièces à fournir :</strong>
                @forelse ($descente->pieces_a_fournir ?? '[]' as $piece)
                    <span class="badge bg-info me-1">📎 {{ $piece }}</span>
                @empty
                    <em>Aucune pièce</em>
                @endforelse
            </p>
        </div>
    </div>
    

</div>
@endsection
