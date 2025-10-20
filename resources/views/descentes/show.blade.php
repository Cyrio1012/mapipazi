@extends('layouts.app')
@section('title', 'Descente')
@section('content')

<style>
    .card {
  border: none;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.card-header {
  font-weight: 600;
  font-size: 1rem;
  border-bottom: 1px solid rgba(0,0,0,0.05);
}
.badge {
  font-size: 0.85rem;
  padding: 0.4em 0.6em;
  border-radius: 6px;
}
.row.material-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.material-grid > .card {
  flex: 1 1 calc(50% - 1rem);
  min-width: 300px;
}
@media (max-width: 768px) {
  .material-grid > .card {
    flex: 1 1 100%;
  }
}

</style>
<div class="container">
  <h2 class="mb-4">🔍 Détail de la descente num {{ $descente->id }}</h2>

  <div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('descentes.index') }}" class="btn btn-secondary">⬅️ Retour à la liste</a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        FT liée
    </button>
    <a href="{{ route('fts.create.from.descente', $descente->id) }}" class="btn btn-outline-primary">Avis de payement</a>
    <a href="{{ route('descentes.edit', $descente->id) }}" class="btn btn-outline-warning">✏️ Modifier</a>
</div>




<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">FT liée au descente {{ $descente->id }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($fts->count() > 0 )
            @foreach ($fts as $ft)
                
            <a href="{{ route('fts.show', $ft->id) }}" ><p class="alert alert-secondary">FT Numéro: {{ $ft->num_ft }} du  {{ \Carbon\Carbon::parse($ft->date)->format('d/m/Y') }}
                
                   a 🕒 {{ \Carbon\Carbon::parse($ft->heure)->format('H\hi') }}</p></a>
            @endforeach
        @else
            <p>Aucune FT liée à cette descente.</p>
        @endif
    
      </div>
      <div class="modal-footer">
        <a href="{{ route('fts.create.from.descente', $descente->id) }}">
          <button type="button" class="btn btn-primary">Nouvelle FT</button>
        </a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>








  <div class="row material-grid">

    {{-- 🗓️ Informations générales --}}
    <div class="card p-0">
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

    {{-- 👥 Équipe & Actions --}}
    <div class="card  p-0">
      <div class="card-header bg-success text-white">👥 Équipe & Actions</div>
      <div class="card-body">
        <p><strong>👥 Équipe :</strong>
          @forelse ($descente->equipe ?? [] as $role)
            <span class="badge bg-secondary me-1">🌿 {{ $role }}</span>
          @empty
            <em>Aucune donnée</em>
          @endforelse
        </p>
        <p><strong>🛠️ Actions :</strong>
          @forelse ($descente->action ?? [] as $act)
            <span class="badge bg-success me-1">🛠️ {{ $act }}</span>
          @empty
            <em>Aucune action</em>
          @endforelse
        </p>
        <p><strong>🔍 Constats :</strong>
          @forelse ($descente->constat ?? [] as $c)
            <span class="badge bg-warning text-dark me-1">🔍 {{ $c }}</span>
          @empty
            <em>Aucun constat</em>
          @endforelse
        </p>
      </div>
    </div>

    {{-- 🧍 Personnes & Contact --}}
    <div class="card  p-0">
      <div class="card-header bg-info text-white">🧍 Personnes & Contact</div>
      <div class="card-body">
        <p><strong>Personne verbalisée :</strong> {{ $descente->pers_verb }}</p>
        <p><strong>Qualité personnes :</strong> {{ $descente->qte_pers }}</p>
        <p><strong>Adresse :</strong> {{ $descente->adresse }}</p>
        <p><strong>Contact :</strong> {{ $descente->contact }}</p>
      </div>
    </div>

    {{-- 📍 Localisation --}}
    <div class="card  p-0">
      <div class="card-header bg-warning text-dark">📍 Localisation</div>
      <div class="card-body">
        <p><strong>District :</strong> {{ $descente->dist }}</p>
        <p><strong>Commune :</strong> {{ $descente->comm }}</p>
        <p><strong>Fokontany :</strong> {{ $descente->fkt }}</p>
        <p><strong>Coordonnées :</strong> {{ $descente->x }}, {{ $descente->y }}</p>
      </div>
    </div>

    {{-- 📅 RDV & Pièces --}}
    <div class="card  p-0">
      <div class="card-header bg-primary text-white">📅 RDV & Pièces</div>
      <div class="card-body">
        <p><strong>Date RDV FT :</strong> {{ $descente->date_rdv_ft }}</p>
        <p><strong>Heure RDV FT :</strong> {{ $descente->heure_rdv_ft }}</p>
        <p><strong>📎 Pièces à fournir :</strong>
          @forelse ($descente->pieces_a_fournir ?? [] as $piece)
            <span class="badge bg-info me-1">📎 {{ $piece }}</span>
          @empty
            <em>Aucune pièce</em>
          @endforelse
        </p>
      </div>
    </div>

  </div>
</div>

@endsection
