@extends('layouts.app')
@section('title', 'Nouvelle Demande')

@section('content')
<style>
    .form-section {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        padding: 24px;
    }

    .form-section h5 {
        font-weight: 500;
        color: #3f51b5;
        margin-bottom: 16px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 6px;
    }

    .form-label {
        font-weight: 500;
        font-size: 14px;
    }

    .form-control, .form-select {
        border-radius: 6px;
        font-size: 14px;
    }

    .form-check-label {
        font-size: 14px;
    }

    .form-check-inline {
        margin-right: 12px;
        margin-bottom: 6px;
    }

    .btn-submit {
        background-color: #3f51b5;
        color: white;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
    }

    .btn-submit:hover {
        background-color: #303f9f;
    }

    .alert-danger {
        background-color: #ffebee;
        border: 1px solid #f44336;
        color: #c62828;
        border-radius: 6px;
    }
    
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-primary">Nouvelle Demande</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('demandes.store') }}" method="POST">
        @csrf

        {{-- 🏷️ Informations de Référence --}}
        <div class="form-section">
            <h5>Informations de Référence</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="arrivalid" class="form-label required-field">Référence Arrivée</label>
                    <input type="text" name="arrivalid" class="form-control @error('arrivalid') is-invalid @enderror" 
                           value="{{ old('arrivalid') }}" required>
                    @error('arrivalid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="invoicingid" class="form-label">Référence Facturation</label>
                    <input type="text" name="invoicingid" class="form-control @error('invoicingid') is-invalid @enderror" 
                           value="{{ old('invoicingid') }}">
                    @error('invoicingid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="sendersce" class="form-label required-field">Service Émetteur</label>
                    <input type="text" name="sendersce" class="form-control @error('sendersce') is-invalid @enderror" 
                           value="{{ old('sendersce') }}" required>
                    @error('sendersce')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="exoyear" class="form-label required-field">Année d'Exercice</label>
                    <input type="number" name="exoyear" class="form-control @error('exoyear') is-invalid @enderror" 
                           value="{{ old('exoyear', date('Y')) }}" min="2000" max="2100" required>
                    @error('exoyear')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 👤 Informations du Demandeur --}}
        <div class="form-section">
            <h5>Informations du Demandeur</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="applicantname" class="form-label required-field">Nom du Demandeur</label>
                    <input type="text" name="applicantname" class="form-control @error('applicantname') is-invalid @enderror" 
                           value="{{ old('applicantname') }}" required>
                    @error('applicantname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="applicantaddress" class="form-label">Adresse du Demandeur</label>
                    <textarea name="applicantaddress" class="form-control @error('applicantaddress') is-invalid @enderror" 
                              rows="2">{{ old('applicantaddress') }}</textarea>
                    @error('applicantaddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 🏘️ Informations de la Propriété --}}
        <div class="form-section">
            <h5>Informations de la Propriété</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="propertyname" class="form-label">Nom de la Propriété</label>
                    <input type="text" name="propertyname" class="form-control @error('propertyname') is-invalid @enderror" 
                           value="{{ old('propertyname') }}">
                    @error('propertyname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="propertyowner" class="form-label required-field">Propriétaire</label>
                    <input type="text" name="propertyowner" class="form-control @error('propertyowner') is-invalid @enderror" 
                           value="{{ old('propertyowner') }}" required>
                    @error('propertyowner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="propertytitle" class="form-label">Titre de Propriété</label>
                    <input type="text" name="propertytitle" class="form-control @error('propertytitle') is-invalid @enderror" 
                           value="{{ old('propertytitle') }}">
                    @error('propertytitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="surfacearea" class="form-label">Surface Totale (m²)</label>
                    <input type="number" step="0.01" name="surfacearea" class="form-control @error('surfacearea') is-invalid @enderror" 
                           value="{{ old('surfacearea') }}">
                    @error('surfacearea')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="backfilledarea" class="form-label">Surface Remblayée (m²)</label>
                    <input type="number" step="0.01" name="backfilledarea" class="form-control @error('backfilledarea') is-invalid @enderror" 
                           value="{{ old('backfilledarea') }}">
                    @error('backfilledarea')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="roaltyamount" class="form-label">Montant </label>
                    <input type="number" step="0.01" name="roaltyamount" class="form-control @error('roaltyamount') is-invalid @enderror" 
                           value="{{ old('roaltyamount') }}">
                    @error('roaltyamount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 📍 Localisation --}}
        <div class="form-section">
            <h5>Localisation</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="locality" class="form-label">Localité</label>
                    <input type="text" name="locality" class="form-control @error('locality') is-invalid @enderror" 
                           value="{{ old('locality') }}">
                    @error('locality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="municipality" class="form-label required-field">Commune</label>
                    <input type="text" name="municipality" class="form-control @error('municipality') is-invalid @enderror" 
                           value="{{ old('municipality') }}" required>
                    @error('municipality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="xv" class="form-label">Coordonnée X</label>
                    <input type="number" step="0.0001" name="xv" class="form-control @error('xv') is-invalid @enderror" 
                           value="{{ old('xv') }}">
                    @error('xv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="yv" class="form-label">Coordonnée Y</label>
                    <input type="number" step="0.0001" name="yv" class="form-control @error('yv') is-invalid @enderror" 
                           value="{{ old('yv') }}">
                    @error('yv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            {{-- 🗺️ Carte pour les coordonnées --}}
            <div class="mt-4">
                <label class="form-label fw-bold">📍 Localisation géographique</label>
                <button type="button" class="btn btn-outline-primary btn-sm mb-2" id="locateBtn">
                    <i class="fas fa-map-marker-alt"></i> Voir ma position
                </button>
                <div id="map" style="height: 400px; border: 1px solid #ccc; border-radius: 6px;"></div>
            </div>
        </div>

        {{-- 🏗️ Informations Techniques --}}
        <div class="form-section">
            <h5>Informations Techniques</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="upr" class="form-label">UPR</label>
                    <select name="upr" class="form-select @error('upr') is-invalid @enderror">
                        <option value="">-- Choisir --</option>
                        <option value="UPR-A" {{ old('upr') == 'UPR-A' ? 'selected' : '' }}>UPR-A</option>
                        <option value="UPR-B" {{ old('upr') == 'UPR-B' ? 'selected' : '' }}>UPR-B</option>
                        <option value="UPR-C" {{ old('upr') == 'UPR-C' ? 'selected' : '' }}>UPR-C</option>
                        <option value="UPR-D" {{ old('upr') == 'UPR-D' ? 'selected' : '' }}>UPR-D</option>
                    </select>
                    @error('upr')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="sit_r" class="form-label">SIT_R</label>
                    <input type="text" name="sit_r" class="form-control @error('sit_r') is-invalid @enderror" 
                           value="{{ old('sit_r') }}">
                    @error('sit_r')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Catégorie</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="">-- Choisir --</option>
                        <option value="A" {{ old('category') == 'A' ? 'selected' : '' }}>A - Résidentiel</option>
                        <option value="B" {{ old('category') == 'B' ? 'selected' : '' }}>B - Commercial</option>
                        <option value="C" {{ old('category') == 'C' ? 'selected' : '' }}>C - Industriel</option>
                        <option value="D" {{ old('category') == 'D' ? 'selected' : '' }}>D - Agricole</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="opfinal" class="form-label">Avis final OP</label>
                    <select name="opfinal" class="form-select @error('opfinal') is-invalid @enderror">
                        <option value="">-- Choisir --</option>
                        <option value="Favorable" {{ old('opfinal') == 'Favorable' ? 'selected' : '' }}>Favorable</option>
                        <option value="Défavorable" {{ old('opfinal') == 'Défavorable' ? 'selected' : '' }}>Défavorable</option>
                        <option value="Sous réserve" {{ old('opfinal') == 'Sous réserve' ? 'selected' : '' }}>Sous réserve</option>
                    </select>
                    @error('opfinal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="urbanplanningregulations" class="form-label">Règlements d'Urbanisme</label>
                    <textarea name="urbanplanningregulations" class="form-control @error('urbanplanningregulations') is-invalid @enderror" 
                              rows="3">{{ old('urbanplanningregulations') }}</textarea>
                    @error('urbanplanningregulations')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 📅 Dates --}}
        <div class="form-section">
            <h5>Dates Importantes</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="arrivaldate" class="form-label required-field">Date d'Arrivée</label>
                    <input type="date" name="arrivaldate" class="form-control @error('arrivaldate') is-invalid @enderror" 
                           value="{{ old('arrivaldate', date('Y-m-d')) }}" required>
                    @error('arrivaldate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="invoicingdate" class="form-label">Date de Facturation</label>
                    <input type="date" name="invoicingdate" class="form-control @error('invoicingdate') is-invalid @enderror" 
                           value="{{ old('invoicingdate') }}">
                    @error('invoicingdate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="commissiondate" class="form-label">Date Commission</label>
                    <input type="date" name="commissiondate" class="form-control @error('commissiondate') is-invalid @enderror" 
                           value="{{ old('commissiondate') }}">
                    @error('commissiondate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="opiniondfdate" class="form-label">Date Avis DF</label>
                    <input type="date" name="opiniondfdate" class="form-control @error('opiniondfdate') is-invalid @enderror" 
                           value="{{ old('opiniondfdate') }}">
                    @error('opiniondfdate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 📝 Avis Commission --}}
        <div class="form-section">
            <h5>Avis de la Commission</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label for="commissionopinion" class="form-label">Avis détaillé</label>
                    <textarea name="commissionopinion" class="form-control @error('commissionopinion') is-invalid @enderror" 
                              rows="4">{{ old('commissionopinion') }}</textarea>
                    @error('commissionopinion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 💰 Informations Financières --}}
        <div class="form-section">
            <h5>Informations Financières</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="roaltyamount" class="form-label">Montant </label>
                    <input type="number" step="0.01" name="roaltyamount" class="form-control @error('roaltyamount') is-invalid @enderror" 
                           value="{{ old('roaltyamount') }}">
                    @error('roaltyamount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-submit flex-fill">
                <i class="fas fa-save"></i> Enregistrer la Demande
            </button>
            <a href="{{ route('demandes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser la carte si les champs coordonnées existent
    if (document.getElementById('map')) {
        // 📦 Définir les couches de base
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        });

        const satellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            attribution: 'Imagery © <a href="https://maps.google.com">Google Maps</a>',
            maxZoom: 19
        });

        // 🗺️ Initialiser la carte
        const map = L.map('map', {
            center: [-18.8792, 47.5079], // Coordonnées par défaut (Antananarivo)
            zoom: 13,
            layers: [satellite]
        });

        // 🔄 Contrôle de bascule
        const baseMaps = {
            "Vue standard 🗺️": osm,
            "Vue satellite 🌍": satellite
        };
        L.control.layers(baseMaps).addTo(map);

        // 📍 Marqueur pour la position
        let marker = null;

        // Fonction pour mettre à jour les champs de coordonnées
        function updateCoordinates(lat, lng) {
            document.querySelector('input[name="xv"]').value = lng;
            document.querySelector('input[name="yv"]').value = lat;
        }

        // Fonction pour mettre à jour le marqueur
        function updateMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup("📍 Position sélectionnée")
                .openPopup();
            map.setView([lat, lng], 15);
        }

        // 📍 Bouton "Voir ma position"
        document.getElementById('locateBtn').addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    updateCoordinates(lat, lng);
                    updateMarker(lat, lng);
                }, () => {
                    alert("Impossible d'obtenir votre position. Vérifiez les permissions de géolocalisation.");
                });
            } else {
                alert("La géolocalisation n'est pas supportée par votre navigateur.");
            }
        });

        // Gérer le clic sur la carte
        map.on('click', function(e) {
            updateCoordinates(e.latlng.lat, e.latlng.lng);
            updateMarker(e.latlng.lat, e.latlng.lng);
        });

        // Remplir les coordonnées existantes si disponibles
        const xvInput = document.querySelector('input[name="xv"]');
        const yvInput = document.querySelector('input[name="yv"]');
        
        if (xvInput.value && yvInput.value) {
            updateMarker(parseFloat(yvInput.value), parseFloat(xvInput.value));
        }
    }

    // Validation des champs numériques
    const numericFields = ['surfacearea', 'backfilledarea', 'roaltyamount', 'xv', 'yv'];
    numericFields.forEach(fieldName => {
        const field = document.querySelector(`input[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', function() {
                if (this.value && isNaN(parseFloat(this.value))) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });

    // Validation de l'année d'exercice
    const exoyearField = document.querySelector('input[name="exoyear"]');
    if (exoyearField) {
        exoyearField.addEventListener('input', function() {
            const year = parseInt(this.value);
            if (this.value && (year < 2000 || year > 2100)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
});
</script>
@endsection