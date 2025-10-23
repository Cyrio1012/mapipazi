@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📝 Nouvelle FT liée à la descente num : {{ $descente->num_pv    }}</h2>
    {{-- Résumé de la descente --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <strong class="text-primary">Résumé de la descente n°{{ $descente->num_pv }}</strong>
        </div>
        <div class="card-body row g-3 small text-dark">
            <div class="col-md-4"><strong>Descente du </strong> {{ $descente->date?->format('d-m-Y') }} à {{ $descente->heure?->format('H:i') }}</div>
            <div class="col-md-4"><strong>Réf. OM :</strong> {{ $descente->ref_om }}</div>
            <div class="col-md-4"><strong>Réf. PV :</strong> {{ $descente->ref_pv }}</div>
            <div class="col-md-4"><strong>Réf. Rapport :</strong> {{ $descente->ref_rapport }}</div>
            <div class="col-md-4"><strong>Personne verbalisée :</strong> {{ $descente->pers_verb }}({{ $descente->qte_pers }})</div>
            <div class="col-md-4"><strong>Adresse :</strong> {{ $descente->adresse }}</div>
            <div class="col-md-4"><strong>Contact :</strong> {{ $descente->contact }}</div>
            <div class="col-md-4"><strong>Lieu :</strong> {{ $descente->fkt }}/{{ $descente->comm }}</div>
            <div class="col-md-4"><strong>Coordonnées :</strong> X: {{ $descente->x }},  Y: {{ $descente->y }}</div>
            <div class="col-md-4"><strong>RDV FT :</strong> {{ $descente->date_rdv_ft }} à {{ $descente->heure_rdv_ft }}</div>
            <div class="col-md-12">
                <strong>Équipe :</strong>
                @foreach($descente->equipe ?? [] as $e)
                    <span class="badge bg-secondary me-1">{{ $e }}</span>
                @endforeach
            </div>
            <div class="col-md-12">
                <strong>Actions :</strong>
                @foreach($descente->action ?? [] as $a)
                    <span class="badge bg-primary me-1">{{ $a }}</span>
                @endforeach
            </div>
            <div class="col-md-12">
                <strong>Constats :</strong>
                @foreach($descente->constat ?? [] as $c)
                    <span class="badge bg-warning text-dark me-1">{{ $c }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <form action="{{ route('fts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_descent" value="{{ $descente->id }}">
        {{-- 🏗️ Informations foncières --}}
        <div class="form-section">
            <h5>Informations foncières</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="num_ft" class="form-label">Numéro FT</label>
                    <input type="text" name="num_ft" class="form-control" value="{{ old('num_ft') }}">
                </div>
                <div class="col-md-6">
                    <label for="antony_ft" class="form-label">Motif FT</label>
                    <input type="text" name="antony_ft" class="form-control" value="{{ old('antony_ft') }}">
                </div>
                <div class="col-md-4">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" value="{{ old('titre') }}">
                </div>
                <div class="col-md-4">
                    <label for="plle" class="form-label">PLLE</label>
                    <input type="text" name="plle" class="form-control" value="{{ old('plle') }}">
                </div>
                <div class="col-md-4">
                    <label for="imm" class="form-label">immatriculation</label>
                    <input type="text" name="imm" class="form-control" value="{{ old('imm') }}">
                </div>
                <div class="col-md-6">
                    <label for="x_desc" class="form-label">Longitude (X)</label>
                    <input type="number" step="0.000001" name="x_desc" class="form-control" value="{{ old('x_desc', $descente->x) }}">
                </div>
                <div class="col-md-6">
                    <label for="y_desc" class="form-label">Latitude (Y)</label>
                    <input type="number" step="0.000001" name="y_desc" class="form-control" value="{{ old('y_desc', $descente->y) }}">
                </div>
                <div class="col-md-4">
                    <label for="superficie" class="form-label">Superficie (m²)</label>
                    <input type="number" step="0.001" name="superficie" class="form-control" value="{{ old('superficie') }}">
                </div>
                <div class="col-md-4">
                    <label for="sup_remblais" class="form-label">Surface remblayée (m²)</label>
                    <input type="number" step="0.001" name="sup_remblais" class="form-control" value="{{ old('sup_remblais') }}">
                </div>
                <div class="col-md-4">
                    <label for="comm_desc" class="form-label">Commune du terrain</label>
                    <input type="text" name="comm_desc" class="form-control" value="{{ old('comm_desc') }}">
                </div>
                <div class="col-md-4">
                    <label for="pu" class="form-label">PU</label>
                    <input type="text" name="pu" class="form-control" value="{{ old('pu') }}">
                </div>
                <div class="col-md-4">
                    <label for="zone" class="form-label">Zone</label>
                    <select name="zone" class="form-select">
                        <option value="">-- Choisir --</option>
                        <option value="zc" {{ old('zone') == 'zc' ? 'selected' : '' }}>ZC</option>
                        <option value="zi" {{ old('zone') == 'zi' ? 'selected' : '' }}>ZI</option>
                        <option value="zd" {{ old('zone') == 'zd' ? 'selected' : '' }}>ZD</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="destination" class="form-label">Destination</label>
                    <select name="destination" class="form-select">
                        <option value="">-- Choisir --</option>
                        <option value="h" {{ old('destination') == 'h' ? 'selected' : '' }}>Habitation</option>
                        <option value="c" {{ old('destination') == 'c' ? 'selected' : '' }}>Commerce</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- 🔍 Constat lié --}}
        <div class="card mb-3">
            <div class="card-header bg-info text-white">🔍 Constat lié</div>
            <div class="card-body">
                @php
                    $constats = ['Infraction', 'Présence suspecte', 'Non-conformité', 'Absence'];
                    $selectedConstats = old('constat_desc', $descente->constat ?? []);
                @endphp
                @foreach ($constats as $c)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="constat_desc[]" value="{{ $c }}" class="form-check-input"
                            {{ in_array($c, $selectedConstats) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $c }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">✅ Enregistrer la FT</button>
    </form>
</div>
@endsection
