@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"> Nouvelle Descente</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a des erreurs dans le formulaire :
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('descentes.store') }}" method="POST">
        @csrf

        {{-- 🗓️ Informations générales --}}
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">🗓️ Date & Références</div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}">
                </div>
                <div class="col-md-4">
                    <label for="heure" class="form-label">Heure</label>
                    <input type="time" name="heure" class="form-control" value="{{ old('heure') }}">
                </div>
                <div class="col-md-4">
                    <label for="ref_om" class="form-label">Réf. OM</label>
                    <input type="text" name="ref_om" class="form-control" value="{{ old('ref_om') }}">
                </div>
                <div class="col-md-4">
                    <label for="ref_pv" class="form-label">Réf. PV</label>
                    <select name="ref_pv" class="form-select">
                        <option value="">-- Choisir --</option>
                        <option value="pat" {{ old('ref_pv') == 'pat' ? 'selected' : '' }}>PAT</option>
                        <option value="fifafi" {{ old('ref_pv') == 'fifafi' ? 'selected' : '' }}>FIFAFI</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ref_rapport" class="form-label">Réf. Rapport</label>
                    <input type="text" name="ref_rapport" class="form-control" value="{{ old('ref_rapport') }}">
                </div>
                <div class="col-md-4">
                    <label for="num_pv" class="form-label">Numéro PV</label>
                    <input type="text" name="num_pv" class="form-control" value="{{ old('num_pv') }}">
                </div>
            </div>
        </div>

        {{-- 👥 Équipe & Actions --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">👥 Équipe & Actions</div>
            <div class="card-body">
                {{-- 👥 Équipe --}}
                <div class="mb-3">
                    <label class="form-label">👥 Équipe</label><br>
                    @foreach ($equipeOptions as $role)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="equipe[]" value="{{ $role }}" class="form-check-input"
                                {{ is_array(old('equipe')) && in_array($role, old('equipe')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $role }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- 🛠️ Actions --}}
                <div class="mb-3">
                    <label class="form-label">🛠️ Actions</label><br>
                    @foreach ($actionOptions as $act)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="action[]" value="{{ $act }}" class="form-check-input"
                                {{ is_array(old('action')) && in_array($act, old('action')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $act }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- 🔍 Constats --}}
                <div class="mb-3">
                    <label class="form-label">🔍 Constats</label><br>
                    @foreach ($constatOptions as $c)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="constat[]" value="{{ $c }}" class="form-check-input"
                                {{ is_array(old('constat')) && in_array($c, old('constat')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $c }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 🧍 Personnes & Contact --}}
        <div class="card mb-3">
            <div class="card-header bg-info text-white">🧍 Personnes & Contact</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="pers_verb" class="form-label">Personne verbalisée</label>
                    <input type="text" name="pers_verb" class="form-control" value="{{ old('pers_verb') }}">
                </div>
                <div class="col-md-6">
                    <label for="qte_pers" class="form-label">Quantité personnes</label>
                    <input type="text" name="qte_pers" class="form-control" value="{{ old('qte_pers') }}">
                </div>
                <div class="col-md-6">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}">
                </div>
                <div class="col-md-6">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                </div>
            </div>
        </div>
              @php
                  $locationData = $locations->map(fn($loc) => [
                      'fkt' => $loc->fkt,
                      'comm' => $loc->firaisana,
                      'dist' => $loc->distrika
                  ]);
              @endphp
        {{-- 📍 Localisation --}}
        <div class="card mb-3">
            <div class="card-header bg-warning text-dark">📍 Localisation</div>
            <div class="card-body row g-3">
                <div class="row">
                    {{-- DISTRICT --}}
                    <div class="col-md-4">
                        <label for="dist" class="form-label">District</label>
                        <input list="dist-list" name="dist" id="dist" class="form-control" value="{{ old('dist') }}">
                        <datalist id="dist-list">
                            @foreach ($locationData->pluck('dist')->unique() as $dist)
                                <option value="{{ $dist }}">
                            @endforeach
                        </datalist>
                    </div>

                    {{-- COMMUNE --}}
                    <div class="col-md-4">
                        <label for="comm" class="form-label">Commune</label>
                        <input list="comm-list" name="comm" id="comm" class="form-control" value="{{ old('comm') }}">
                        <datalist id="comm-list"></datalist>
                    </div>

                    {{-- FOKONTANY --}}
                    <div class="col-md-4">
                        <label for="fkt" class="form-label">Fokontany</label>
                        <input list="fkt-list" name="fkt" id="fkt" class="form-control" value="{{ old('fkt') }}">
                        <datalist id="fkt-list"></datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="x" class="form-label">Longitude (X)</label>
                    <input type="number" step="0.000001" name="x" class="form-control" value="{{ old('x') }}">
                </div>
                <div class="col-md-6">
                    <label for="y" class="form-label">Latitude (Y)</label>
                    <input type="number" step="0.000001" name="y" class="form-control" value="{{ old('y') }}">
                </div>
            </div>
        </div>

        {{-- 📅 RDV & Pièces --}}
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">📅 RDV & Pièces à fournir</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="date_rdv_ft" class="form-label">Date RDV FT</label>
                        <input type="date" name="date_rdv_ft" class="form-control" value="{{ old('date_rdv_ft') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="heure_rdv_ft" class="form-label">Heure RDV FT</label>
                        <input type="time" name="heure_rdv_ft" class="form-control" value="{{ old('heure_rdv_ft') }}">
                    </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">📎 Pièces à fournir</label><br>
                  @foreach ($piecesOption as $piece)
                      <div class="form-check form-check-inline">
                          <input type="checkbox" name="pieces_a_fournir[]" value="{{ $piece }}" class="form-check-input"
                              {{ is_array(old('pieces_a_fournir')) && in_array($piece, old('pieces_a_fournir')) ? 'checked' : '' }}>
                          <label class="form-check-label">{{ $piece }}</label>
                      </div>
                  @endforeach
              </div>
        </div>

        <button type="submit" class="btn btn-dark w-100">✅ Enregistrer la descente</button>
    </form>
</div>
<script>
    const locations = @json($locationData);
    const distInput = document.getElementById('dist');
    const commInput = document.getElementById('comm');
    const fktInput = document.getElementById('fkt');

    const commList = document.getElementById('comm-list');
    const fktList = document.getElementById('fkt-list');

    // 🧭 Mise à jour des communes selon district
    distInput.addEventListener('input', () => {
        const dist = distInput.value;
        const communes = [...new Set(locations.filter(l => l.dist === dist).map(l => l.comm))];
        commList.innerHTML = '';
        communes.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c;
            commList.appendChild(opt);
        });
        commInput.value = '';
        fktList.innerHTML = '';
        fktInput.value = '';
    });

    // 🧭 Mise à jour des fokontany selon commune
    commInput.addEventListener('input', () => {
        const comm = commInput.value;
        const fktListFiltered = locations.filter(l => l.comm === comm).map(l => l.fkt);
        fktList.innerHTML = '';
        [...new Set(fktListFiltered)].forEach(f => {
            const opt = document.createElement('option');
            opt.value = f;
            fktList.appendChild(opt);
        });
        fktInput.value = '';
    });

    // 🔁 Remplissage automatique si seul fokontany est saisi
    fktInput.addEventListener('input', () => {
        const fkt = fktInput.value.trim();
        const match = locations.find(l => l.fkt.toLowerCase() === fkt.toLowerCase());
        if (match) {
            commInput.value = match.comm;
            distInput.value = match.dist;
        }
    });
    // fktInput.addEventListener('input', () => {
    //     const fkt = fktInput.value;
    //     const match = locations.find(l => l.fkt.toLowerCase() === fkt.toLowerCase());
    //     if (match) {
    //         commInput.value = match.comm;
    //         distInput.value = match.dist;

    //         // Optionnel : recharger les listes liées
    //         const communes = [...new Set(locations.filter(l => l.dist === match.dist).map(l => l.comm))];
    //         commList.innerHTML = '';
    //         communes.forEach(c => {
    //             const opt = document.createElement('option');
    //             opt.value = c;
    //             commList.appendChild(opt);
    //         });

    //         const fktListFiltered = locations.filter(l => l.comm === match.comm).map(l => l.fkt);
    //         fktList.innerHTML = '';
    //         [...new Set(fktListFiltered)].forEach(f => {
    //             const opt = document.createElement('option');
    //             opt.value = f;
    //             fktList.appendChild(opt);
    //         });
    //     }
    // });
</script>
@endsection
