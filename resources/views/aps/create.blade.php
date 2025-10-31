@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📝 Nouvelle AP pour la descente n°{{ $descente->id }}</h2>

    <form action="{{ route('aps.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_descent" value="{{ $descente->id }}">
        <input type="hidden" name="ref_pv" value="{{ $descente->ref_pv }}">
        <input type="hidden" name="num_pv" value="{{ $descente->num_pv }}">
        <input type="hidden" name="date_pv" value="{{ $descente->date }}">
        <input type="hidden" name="date_ft" value="{{ $fts->date }}">
        <input type="hidden" name="num_ft" value="{{ $fts->id }}">
        <input type="hidden" name="type" value="{{ $_GET['type'] }}">
        <input type="hidden" name="sup_remblais" value="{{ $proprietes->sup_remblais }}">
        <input type="hidden" name="comm_propriete" value="{{ $proprietes->comm_desc }}">
        <input type="hidden" name="nom_proprietaire" value="{{ $proprietes->proprietaire }}">
        <input type="hidden" name="x" value="{{ $fts->x_desc }}">
        <input type="hidden" name="y" value="{{ $fts->y_desc }}">
        <input type="hidden" name="zone" value="{{ $fts->zone }}">
        <input type="hidden" name="titre" value="{{ $proprietes->titre }}">
        <input type="hidden" name="plle" value="{{ $proprietes->plle }}">
        <input type="hidden" name="imm" value="{{ $proprietes->imm }}">
        <input type="hidden" name="destination" value="{{ $fts->destination }}">
        <input type="hidden" name="taux" value="{{ $taux }}">

        <div class="container py-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🧭 AP Descente {{ $descente->num_pv }}</h4>
                </div>
                <div class="card-body">
                    <h1><span>{{ $_GET['type'] }}</span></h1>
                    <p> Proprietaire : {{ $proprietes->proprietaire }}</p>
                    <p> N° descente : {{ $descente->num_pv }}</p>
                    <p> Date descente : {{ $descente->date?->format('d/m/Y') }}</p>
                    <p> N°  : {{ $fts->num_ft }}</p>
                    <p> date FT : {{ $fts->date?->format('d/m/Y') }}</p>
                    <p> Titre : {{ $proprietes->titre }}</p>
                    <p> immatriculation : {{ $proprietes->imm }}</p>
                    <p> Date Plan : {{ $proprietes->date }}</p>
                    <p> coordonnées :    X : {{ $fts->x_desc }} Y : {{ $fts->y_desc }}</p>
                    <p> localisation : {{ $descente->fkt }}</p>
                    <p> sup :{{ $proprietes->sup_remblais }} </p>
                    <p> Taux : {{ $taux_lettre }} ({{ number_format($taux, 0, '', ' ') }}Ar)</p>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100">✅ Valider l'AP</button>
    </form>
</div>
@endsection
