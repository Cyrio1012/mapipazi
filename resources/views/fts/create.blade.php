@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📝 Nouvelle FT liée à la descente #{{ $descente->id }}</h2>

    <form action="{{ route('fts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_descent" value="{{ $descente->id }}">

        {{-- 📍 Localisation --}}
        <div class="card mb-3">
            <div class="card-header bg-warning text-dark">📍 Localisation liée</div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label for="dist_desc" class="form-label">District</label>
                    <input type="text" name="dist_desc" class="form-control" value="{{ old('dist_desc', $descente->dist) }}">
                </div>
                <div class="col-md-4">
                    <label for="comm_desc" class="form-label">Commune</label>
                    <input type="text" name="comm_desc" class="form-control" value="{{ old('comm_desc', $descente->comm) }}">
                </div>
                <div class="col-md-4">
                    <label for="fkt_desc" class="form-label">Fokontany</label>
                    <input type="text" name="fkt_desc" class="form-control" value="{{ old('fkt_desc', $descente->fkt) }}">
                </div>
                <div class="col-md-6">
                    <label for="x_desc" class="form-label">Longitude (X)</label>
                    <input type="number" step="0.000001" name="x_desc" class="form-control" value="{{ old('x_desc', $descente->x) }}">
                </div>
                <div class="col-md-6">
                    <label for="y_desc" class="form-label">Latitude (Y)</label>
                    <input type="number" step="0.000001" name="y_desc" class="form-control" value="{{ old('y_desc', $descente->y) }}">
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

        {{-- Autres champs FT --}}
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">📝 Informations FT</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="num_ft" class="form-label">Numéro FT</label>
                    <input type="text" name="num_ft" class="form-control" value="{{ old('num_ft') }}">
                </div>
                <div class="col-md-6">
                    <label for="antony_ft" class="form-label">Motif FT</label>
                    <input type="text" name="antony_ft" class="form-control" value="{{ old('antony_ft') }}">
                </div>
                <div class="col-md-6">
                    <label for="zone" class="form-label">Zone</label>
                    <select name="zone" class="form-select">
                        <option value="zc">ZC</option>
                        <option value="zi">ZI</option>
                        <option value="zd">ZD</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="destination" class="form-label">Destination</label>
                    <select name="destination" class="form-select">
                        <option value="h">H</option>
                        <option value="c">C</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">✅ Enregistrer la FT</button>
    </form>
</div>
@endsection
