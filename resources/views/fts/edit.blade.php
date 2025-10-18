@extends('layouts.app')
@section('title', 'Créer une FT')

@section('content')
<div class="container">
  <h2 class="mb-4">📝 Nouvelle FT</h2>

  @if ($errors->any())
    <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('fts.store') }}">
    @csrf

    <div class="row">
      <div class="col-md-6 mb-3"><label>Numéro</label><input type="text" name="numero" class="form-control" value="{{ old('numero') }}"></div>
      <div class="col-md-6 mb-3"><label>Date FT</label><input type="date" name="date_ft" class="form-control" value="{{ old('date_ft') }}"></div>
      <div class="col-md-6 mb-3"><label>Heure FT</label><input type="time" name="heur_ft" class="form-control" value="{{ old('heur_ft') }}"></div>
      <div class="col-md-6 mb-3"><label>Personne convoquée</label><input type="text" name="personne_convoquer" class="form-control" value="{{ old('personne_convoquer') }}"></div>
      <div class="col-md-6 mb-3"><label>Propriétaire</label><input type="text" name="proprietaire" class="form-control" value="{{ old('proprietaire', $ft->proprietaire ?? '') }}"></div>
      <div class="col-md-6 mb-3"><label>Titre terrain</label><input type="text" name="titre_terrain" class="form-control" value="{{ old('titre_terrain') }}"></div>
      <div class="col-md-6 mb-3"><label>Immatriculation terrain</label><input type="text" name="immatriculation_t" class="form-control" value="{{ old('immatriculation_t') }}"></div>
      <div class="col-md-6 mb-3"><label>Commune</label><input type="text" name="commune" class="form-control" value="{{ old('commune', $ft->commune ?? '') }}"></div>
      <div class="col-md-6 mb-3"><label>Fokontany</label><input type="text" name="fkt" class="form-control" value="{{ old('fkt', $ft->fkt ?? '') }}"></div>
      <div class="col-md-6 mb-3"><label>Superficie</label><input type="text" name="superficie" class="form-control" value="{{ old('superficie') }}"></div>
      <div class="col-md-6 mb-3"><label>Superficie remblayée</label><input type="text" name="sup_remblais" class="form-control" value="{{ old('sup_remblais') }}"></div>
      <div class="col-md-6 mb-3"><label>Coordonnée X</label><input type="text" name="coord_x" class="form-control" value="{{ old('coord_x', $ft->coord_x ?? '') }}"></div>
      <div class="col-md-6 mb-3"><label>Coordonnée Y</label><input type="text" name="coord_y" class="form-control" value="{{ old('coord_y', $ft->coord_y ?? '') }}"></div>
      <div class="col-md-6 mb-3"><label>Délai dépôt dossier</label><input type="text" name="delais_dp_dossier" class="form-control" value="{{ old('delais_dp_dossier') }}"></div>
      <div class="col-md-6 mb-3"><label>Date RDV</label><input type="date" name="date_rdv" class="form-control" value="{{ old('date_rdv') }}"></div>
    </div>

    {{-- Infractions --}}
    <div class="mb-3">
      <label class="form-label fw-bold">Infractions</label><br>
      @foreach(['DEPOT_PV','ARRET_TRAVAUX','NON_RESPECT'] as $infraction)
        <div class="form-check form-check-inline">
          
          <label class="form-check-label">{{ $infraction }}</label>
        </div>
      @endforeach
    </div>

    {{-- Dossier administratif --}}
    <div class="mb-3">
      <label class="form-label fw-bold">Dossier administratif foncier</label><br>
      @foreach(['Pvd_alignement','csj','plan_off','acte_de_vente','acte_de_notoriete','procuration','prescription_d_urbanisme','permis_remblais','permis_construction'] as $doc)
        <div class="form-check form-check-inline">
         
          <label class="form-check-label">{{ Str::headline(str_replace('_', ' ', $doc)) }}</label>
        </div>
      @endforeach
    </div>

    <input type="hidden" name="id_descente" value="{{ $descente->id ?? $ft->id_descente ?? '' }}">

    <button type="submit" class="btn btn-success">✅ Enregistrer</button>
    <a href="{{ route('fts.index') }}" class="btn btn-secondary">↩️ Retour</a>
  </form>
</div>
@endsection
z