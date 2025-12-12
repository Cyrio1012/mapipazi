@extends('layouts.app')

@section('content')
<style>
    .material-container {
        max-width: 1200px;
        margin: auto;
        padding: 30px;
        background-color: #fafafa;
        font-family: 'Roboto', sans-serif;
    }

    .material-header {
        font-size: 24px;
        font-weight: 500;
        color: #3f51b5;
        margin-bottom: 20px;
        border-bottom: 2px solid #3f51b5;
        padding-bottom: 5px;
    }

    .material-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .material-actions .btn {
        font-weight: 500;
        border-radius: 4px;
    }

    .card-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #fff;
    }

    .card-header {
        font-weight: 500;
        font-size: 16px;
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        background-color: #e3f2fd;
        color: #0d47a1;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-body {
        padding: 16px;
        font-size: 14px;
        color: #333;
    }

    .badge {
        font-size: 13px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .modal-title {
        font-weight: 500;
        color: #3f51b5;
    }

    .modal-body p {
        font-size: 14px;
    }

    .alert-secondary {
        background-color: #f1f1f1;
        border: none;
        padding: 10px;
        border-radius: 4px;
    }
</style>

<div class="material-container">
    <div class="material-header">Détail de la descente n° {{ $descente->num_pv }}</div>

    <div class="material-actions">
        <a href="{{ route('descentes.index') }}" class="btn btn-outline-secondary">Retour</a>
        @if(auth()->user()->statut === 'agent' || auth()->user()->statut === 'admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">FT liée</button>
          @if(auth()->user()->statut === 'admin')
            @if($fts->count() != 0)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticAp">Établir AP</button>
            @endif
          @endif
        @endif
        <a href="{{ route('descentes.edit', $descente->id) }}" class="btn btn-outline-warning">Modifier</a>
       
    </div>

    {{-- Modals --}}
    <!-- Modal FT -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">FT liée au descente n° {{ $descente->num_pv }}</h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> @if ($fts->count() > 0 ) @foreach ($fts as $ft) <a href="{{ route('fts.show', $ft->id) }}">
                        <p class="alert alert-secondary">FT Numéro: {{ $ft->num_ft }} du {{ \Carbon\Carbon::parse($ft->date)->format('d/m/Y') }} a 🕒 {{ \Carbon\Carbon::parse($ft->heure)->format('H\hi') }}</p>
                    </a> @endforeach @else <p>Aucune FT liée à cette descente.</p> @endif </div>
                <div class="modal-footer"> <a href="{{ route('fts.create.from.descente', $descente->id) }}"> <button type="button" class="btn btn-primary">Nouvelle FT</button> </a> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> </div>
            </div>
        </div>
    </div> 
    
    <!-- Modal AP -->
@if($fts->count() != 0)
    <div class="modal fade" id="staticAp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticAp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Etablir l'Avis de Payement du Pv n° {{ $descente->num_pv }}</h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                   @php
                        $apRedevance = $info_ap->firstWhere('type', 'redevance');
                        $apamende = $info_ap->firstWhere('type', 'amende');
                    @endphp
                    @if ($apRedevance && $apamende)
                        {{-- ✅ Les deux AP existent --}}
                        <p class="alert alert-success">
                            Avis de paiement redevance déjà émis
                            <a href="{{ route('aps.show', $apRedevance) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                        </p>
                        <p class="alert alert-success">
                            Avis de paiement amende déjà émis
                            <a href="{{ route('aps.show', $apamende) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                        </p>

                    @elseif ($apRedevance && !$apamende)
                        {{-- ✅ Seulement redevance existe --}}
                        <p class="alert alert-success">
                            Avis de paiement redevance déjà émis
                            <a href="{{ route('aps.show', $apRedevance) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                        </p>
                        <a href="{{ route('aps.create', ['descente' => $descente->id, 'type' => 'amende']) }}">
                            <p class="alert alert-secondary">Etablir Avis de paiement amende</p>
                        </a>

                    @elseif (!$apRedevance && $apamende)
                        {{-- ✅ Seulement amende existe --}}
                        <p class="alert alert-success">
                            Avis de paiement amende déjà émis
                            <a href="{{ route('aps.show', $apamende) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                        </p>
                        <a href="{{ route('aps.create', ['descente' => $descente->id, 'type' => 'redevance']) }}">
                            <p class="alert alert-secondary">Etablir Avis de paiement Redevance</p>
                        </a>

                    @else
                        {{-- ❌ Aucun AP encore émis --}}
                        @if ($info_ft->zone === 'zc' || $info_ft->zone === 'zd')
                            <a href="{{ route('aps.create', ['descente' => $descente->id, 'type' => 'redevance']) }}">
                                <p class="alert alert-secondary">Etablir Avis de paiement Redevance</p>
                            </a>
                        @endif
                        <a href="{{ route('aps.create', ['descente' => $descente->id, 'type' => 'amende']) }}">
                            <p class="alert alert-secondary">Etablir Avis de paiement amende</p>
                        </a>
                    @endif
                
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> </div>
            </div>
        </div>
    </div>
 @endif 
    {{-- Cartes d'information --}}
    <div class="card-group">
        <div class="card">
            <div class="card-header">Informations générales</div>
            <div class="card-body">
                <p><strong>Date :</strong> {{ $descente->date }}</p>
                <p><strong>Heure :</strong> {{ $descente->heure }}</p>
                <p><strong>Réf. OM :</strong> {{ $descente->ref_om }}</p>
                <p><strong>Réf. PV :</strong> {{ $descente->ref_pv }}</p>
                <p><strong>Réf. Rapport :</strong> {{ $descente->ref_rapport }}</p>
                <p><strong>Numéro PV :</strong> {{ $descente->num_pv }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Équipe & Actions</div>
            <div class="card-body">
                <p><strong>Équipe :</strong></p>
                @forelse ($descente->equipe ?? [] as $role)
                <span class="badge bg-light text-dark">{{ $role }}</span>
                @empty
                <em>Aucune donnée</em>
                @endforelse

                <p class="mt-2"><strong>Actions :</strong></p>
                @forelse ($descente->action ?? [] as $act)
                <span class="badge bg-primary text-white">{{ $act }}</span>
                @empty
                <em>Aucune action</em>
                @endforelse

                <p class="mt-2"><strong>Constats :</strong></p>
                @forelse ($descente->constat ?? [] as $c)
                <span class="badge bg-warning text-dark">{{ $c }}</span>
                @empty
                <em>Aucun constat</em>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">Personnes & Contact</div>
            <div class="card-body">
                <p><strong>Personne verbalisée :</strong> {{ $descente->pers_verb }}</p>
                <p><strong>Nom complet :</strong> {{ $descente->qte_pers }}</p>
                <p><strong>Adresse :</strong> {{ $descente->adresse }}</p>
                <p><strong>Contact :</strong> {{ $descente->contact }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Localisation</div>
            <div class="card-body">
                <p><strong>District :</strong> {{ $descente->dist }}</p>
                <p><strong>Commune :</strong> {{ $descente->comm }}</p>
                <p><strong>Fokontany :</strong> {{ $descente->fkt }}</p>
                <p><strong>Coordonnées :</strong> {{ $descente->x }}, {{ $descente->y }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">RDV & Pièces</div>
            <div class="card-body">
                <p><strong>Date RDV FT :</strong> {{ $descente->date_rdv_ft }}</p>
                <p><strong>Heure RDV FT :</strong> {{ $descente->heure_rdv_ft }}</p>
                <p><strong>Pièces à fournir :</strong></p>
                @forelse ($descente->pieces_a_fournir ?? [] as $piece)
                <span class="badge bg-info text-dark">{{ $piece }}</span>
                @empty
                <em>Aucune pièce</em>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection