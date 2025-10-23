@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📝 Nouvelle AP pour la descente n°{{ $descente->id }}</h2>

    <form action="{{ route('aps.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_descent" value="{{ $descente->id }}">

        <div class="row g-3">
            <div class="col-md-4">
                <label>Numéro AP</label>
                <input type="text" name="num_ap" class="form-control" value="{{ old('num_ap') }}">
            </div>
            <div class="col-md-4">
                <label>Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type') }}">
            </div>
            <div class="col-md-4">
                <label>Date AP</label>
                <input type="date" name="date_ap" class="form-control" value="{{ old('date_ap') }}">
            </div>

            <div class="col-md-4">
                <label>Surface remblayée (m²)</label>
                <input type="number" step="0.01" name="sup_remblais" class="form-control" value="{{ old('sup_remblais') }}">
            </div>
            <div class="col-md-4">
                <label>Commune de propriété</label>
                <input type="text" name="comm_propriete" class="form-control" value="{{ old('comm_propriete') }}">
            </div>
            <div class="col-md-4">
                <label>PU</label>
                <input type="text" name="pu" class="form-control" value="{{ old('pu') }}">
            </div>

            <div class="col-md-4">
                <label>Zone</label>
                <select name="zone" class="form-select">
                    <option value="zc">ZC</option>
                    <option value="zi">ZI</option>
                    <option value="zd">ZD</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Destination</label>
                <select name="destination" class="form-select">
                    <option value="h">H</option>
                    <option value="c">C</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Taux (%)</label>
                <input type="number" step="0.01" name="taux" class="form-control" value="{{ old('taux') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100">✅ Enregistrer l'AP</button>
    </form>
</div>
@endsection
