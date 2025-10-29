@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📝 Nouvelle AP pour la descente n°{{ $descente->id }}</h2>

    <form action="{{ route('aps.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_descent" value="{{ $descente->id }}">

        <div class="container py-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🧭 AP Descente {{ $descente->num_pv }}</h4>
                </div>
                <div class="card-body">
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
                    <p> Taux {{ $type }}: {{ $taux_lettre }} ({{ number_format($taux, 0, '', ' ') }}Ar)</p>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100">✅ Enregistrer l'AP</button>
    </form>
</div>
@endsection
