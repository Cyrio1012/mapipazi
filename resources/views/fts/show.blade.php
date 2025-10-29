@extends('layouts.app')

@section('content')
<style>
    .fiche-container {
        max-width: 100%;
        padding: 30px;
        background-color: #fff;
        font-family: 'Roboto', sans-serif;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .fiche-title {
        font-size: 24px;
        font-weight: 500;
        color: #3f51b5;
        border-bottom: 2px solid #3f51b5;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }

    .section {
        margin-bottom: 25px;
    }

    .section h4 {
        font-size: 18px;
        font-weight: 500;
        color: #333;
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 15px;
    }

    .field {
        background-color: #f5f5f5;
        padding: 10px 15px;
        border-radius: 6px;
        font-size: 14px;
    }

    .field label {
        font-weight: 500;
        color: #555;
        display: block;
        margin-bottom: 4px;
    }

    ul {
        margin: 0;
        padding-left: 20px;
    }

    .btn-action {
        background-color: #3f51b5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 500;
        text-decoration: none;
        float: right;
    }

    .btn-action:hover {
        background-color: #303f9f;
    }
</style>

<div class="fiche-container">
    <div class="fiche-title">Fitanana an-Tsoratra n°{{ str_pad($fts->num_ft, 3, '0', STR_PAD_LEFT) }}</div>

    <div class="section">
        <h4>Informations générales</h4>
        <div class="grid">
            <div class="field"><label>Date</label>{{ $fts->date?->format('d/m/Y') }}</div>
            <div class="field"><label>Heure</label>{{ $fts->heure }}</div>
            <div class="field"><label>Numéro FT</label>{{ $fts->num_ft }}</div>
            <div class="field"><label>Motif</label>{{ $fts->antony_ft }}</div>
        </div>
    </div>

    <div class="section">
        <h4>Constats</h4>
        <div class="field">
            <ul>
                @foreach($fts->constat_desc ?? [] as $c)
                    <li>{{ $c }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="section">
        <h4>Localisation</h4>
        <div class="grid">
            <div class="field"><label>District</label>{{ $fts->dist_desc }}</div>
            <div class="field"><label>Commune</label>{{ $fts->comm_desc }}</div>
            <div class="field"><label>Fokontany</label>{{ $fts->fkt_desc }}</div>
            <div class="field"><label>PU</label>{{ $fts->pu }}</div>
            <div class="field"><label>Zone</label>{{ strtoupper($fts->zone) }}</div>
            <div class="field"><label>Destination</label>{{ strtoupper($fts->destination) }}</div>
            <div class="field"><label>X</label>{{ $fts->x_desc }}</div>
            <div class="field"><label>Y</label>{{ $fts->y_desc }}</div>
        </div>
    </div>

    <div class="section">
        <h4>Objet de la FT</h4>
        <div class="field">{{ $fts->objet_ft }}</div>
    </div>

    <div class="section">
        <h4>Personne venue</h4>
        <div class="grid">
            <div class="field"><label>Nom</label>{{ $fts->nom_pers_venue }}</div>
            <div class="field"><label>Qualité</label>{{ $fts->qte_pers_venue }}</div>
            <div class="field"><label>Contact</label>{{ $fts->contact }}</div>
            <div class="field"><label>Adresse</label>{{ $fts->adresse }}</div>
            <div class="field"><label>CIN</label>{{ $fts->cin }}</div>
        </div>
    </div>

    <div class="section">
        <h4>Pièces apportées</h4>
        <div class="field">
            <ul>
                @foreach($fts->pieces_apporter ?? [] as $p)
                    <li>{{ $p }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="section">
        <h4>Recommandations</h4>
        <div class="field">{{ $fts->recommandation }}</div>
    </div>

    <div class="section">
        <h4>Pièces complémentaires</h4>
        <div class="field">
            <ul>
                @foreach($fts->pieces_complement ?? [] as $pc)
                    <li>{{ $pc }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="section">
        <h4>Rendez-vous FT</h4>
        <div class="grid">
            <div class="field"><label>Délai</label>{{ $fts->delais }}</div>
            <div class="field"><label>Date RDV</label>{{ $fts->date_rdv_ft?->format('d/m/Y') }}</div>
            <div class="field"><label>Heure RDV</label>{{ $fts->heure_rdv_ft }}</div>
        </div>
    </div>

    <a href="{{ route('fts.export.pdf', $fts->id) }}" class="btn-action">Exporter PDF</a>
</div>
@endsection
