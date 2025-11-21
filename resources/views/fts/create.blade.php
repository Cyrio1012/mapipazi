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
        {{-- 👤 Personne venue & coordonnées --}}
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label">Num FT</label>
                <input type="text" name="num_ft" class="form-control" value="{{ old('num_ft') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', optional($descente->date)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Heure</label>
                <input type="time" name="heure" class="form-control" value="{{ old('heure', optional($descente->heure)->format('H:i')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Nom personne venue</label>
                <input type="text" name="nom_pers_venue" class="form-control" value="{{ old('nom_pers_venue') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Qualité personnes</label>
                <input type="text" name="qte_pers_venue" class="form-control" value="{{ old('qte_pers_venue') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $descente->adresse) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">CIN / N° pièce</label>
                <input type="text" name="cin" class="form-control" value="{{ old('cin') }}">
            </div>
        </div>
        {{-- 🏗️ Informations foncières --}}
        <div class="form-section">
            <h5>Informations foncières</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="num_ft" class="form-label">Nom proprietaire</label>
                    <input type="text" name="proprietaire" class="form-control" value="{{ old('proprietaire') }}">
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
                <input type="text" name="zone" list="zoneOptions" class="form-control" 
                    value="{{ old('zone', '') }}" placeholder="Tapez zc, zi ou zd">

                <datalist id="zoneOptions">
                    <option value="">Sélectionnez une zone</option>
                    
                    <!-- Zones Commerciales -->
                    <optgroup label="Zones Commerciales">
                        <option value="CC">Corridor commercial</option>
                        <option value="ZC">Zone Commerciale</option>
                        <option value="ZCP">Zone commerciale primaire</option>
                    </optgroup>
                    
                    <!-- Zones Résidentielles -->
                    <optgroup label="Zones Résidentielles">
                        <option value="ZHF">Zone d'habitat de densité forte</option>
                        <option value="ZRF">Zone résidentielle à forte densité</option>
                        <option value="ZRM">Zone résidentielle à moyenne densité</option>
                        <option value="ZRT">Zone résidentielle à très forte densité</option>
                    </optgroup>
                    
                    <!-- Zones de Développement -->
                    <optgroup label="Zones de Développement">
                        <option value="ZCM">Zone de développement mixte</option>
                        <option value="ZDMI">Zone de développement mixte, terrain enclavé</option>
                        <option value="ZU">Zone à urbaniser</option>
                        <option value="ZR">Zone à restructurer</option>
                    </optgroup>
                    
                    <!-- Zones Industrielles -->
                    <optgroup label="Zones Industrielles">
                        <option value="ZEI">Zone d'extension industrielle</option>
                        <option value="ZEN">Zone d'extension industrielle surface insuffisante</option>
                        <option value="ZIU">Zone industrielle Zone à urbaniser</option>
                    </optgroup>
                    
                    <!-- Zones d'Équipement et Administratives -->
                    <optgroup label="Zones d'Équipement et Administratives">
                        <option value="ZEA">Zone d'équipement public et administratif</option>
                        <option value="ZIA">Zone d'implantation d'activité Administrative</option>
                    </optgroup>
                    
                    <!-- Zones d'Extension -->
                    <optgroup label="Zones d'Extension">
                        <option value="ZE">Zone d'extension</option>
                    </optgroup>
                    
                    <!-- Espaces Verts et Loisirs -->
                    <optgroup label="Espaces Verts et Loisirs">
                        <option value="EPL">Espace vert et Loisirs</option>
                    </optgroup>
                    
                    <!-- Zones Hydrauliques et Eau -->
                    <optgroup label="Zones Hydrauliques et Eau">
                        <option value="ECP">Emprise du Canal public</option>
                        <option value="EOH">Ouvrages Hydrauliques (emprise)</option>
                        <option value="ZHW">Plan d'eau, inconstructible</option>
                    </optgroup>
                    
                    <!-- Zones Inconstructibles et Protégées -->
                    <optgroup label="Zones Inconstructibles et Protégées">
                        <option value="ZNC">Zone inconstructible</option>
                        <option value="ZNA">Zone agricole inconstructible</option>
                        <option value="ZNH">Zone humide, non constructible</option>
                        <option value="ZNP">Zone/périmètre de protection</option>
                        <option value="ZRI">Zone à remblayer, terrain enclavé</option>
                    </optgroup>
                    
                    <!-- Réserves Publiques -->
                    <optgroup label="Réserves Publiques">
                        <option value="REP">Reserves d'emprise publique</option>
                    </optgroup>
                </datalist>

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
        <div class="mb-3">
                <label class="form-label">pieces apporter</label><br>

                @forelse ($descente->pieces_a_fournir ?? [] as $act)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="piece_apporter[]" value="{{ $act }}" class="form-check-input"
                            {{ is_array(old('piece_apporter')) && in_array($act, old('piece_apporter')) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $act }}</label>
                    </div>
                @empty
                <span>-</span>
                @endforelse
        </div>

        <label for="" class="form-label mt-2"> Objet </label>
        <div class="col-md-12 mt-1">
            <textarea name="objet_ft"  class="form-control w-100" >{{ old('objet_ft') }}</textarea>
        </div>
        
        
        <button type="submit" class="btn btn-primary w-100 mt-2">✅ Enregistrer la FT</button>
    </form>
</div>
@endsection
