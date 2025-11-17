@extends('layouts.app')
@section('title', 'Cartographie des Descentes et Archives - Madagascar')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cartographie des Descentes et Archives - Madagascar</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
* {
margin: 0;
padding: 0;
box-sizing: border-box;
font-family: 'Inter', sans-serif;
}
body {
background-color: #f5f7fa;
color: #333;
height: 100vh;
display: flex;
flex-direction: column;
margin:0 !important;
}

.main-container {
    display: flex;
    flex: 1;
    height: calc(100vh - var(--topbar-height));
    width: 100%;
}

.map-container {
    position: relative;
    width: 100%;
    height: 100%;
    flex: 1;
}

#map {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
.map-controls {
position: absolute;
top: 4rem;
right: 1rem;
z-index: 1000;
display: flex;
flex-direction: column;
gap: 0.5rem;
}
.map-btn {
width: 40px;
height: 40px;
border-radius: 8px;
background-color: white;
border: none;
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
transition: all 0.2s;
}
.map-btn:hover {
background-color: #f8fafc;
box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}
.map-btn i {
font-size: 1.2rem;
color: #4b5563;
}
.map-btn.active {
background-color: #2563eb;
color: white;
}
.map-btn.active i {
color: white;
}

/* MODAL DÉTAIL */
.descente-detail {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 400px;
    max-height: calc(100vh - 2rem);
    background-color: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1150;
    overflow-y: auto;
    display: none;
}

.descente-detail.active {
    display: block;
}

.detail-header {
display: flex;
justify-content: between;
align-items: center;
margin-bottom: 1rem;
padding-bottom: 0.5rem;
border-bottom: 2px solid #e5e7eb;
}
.detail-title {
font-weight: 600;
color: #1e3a8a;
font-size: 1.2rem;
}
.close-detail {
background: none;
border: none;
font-size: 1.5rem;
cursor: pointer;
color: #6b7280;
}
.detail-content {
font-size: 0.9rem;
color: #4b5563;
line-height: 1.6;
}
.detail-section {
margin-bottom: 1rem;
}
.detail-section h4 {
color: #374151;
margin-bottom: 0.5rem;
font-size: 1rem;
}
.detail-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
gap: 0.8rem;
}
.detail-item {
display: flex;
flex-direction: column;
}
.detail-label {
font-weight: 600;
color: #6b7280;
font-size: 0.8rem;
margin-bottom: 0.2rem;
}
.detail-value {
color: #374151;
font-size: 0.9rem;
}

/* LÉGENDE - STYLE SIMPLIFIÉ SANS RÉDUCTION */
.legend-container {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background-color: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-width: 280px;
}

.legend-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.8rem;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.legend-content {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.legend-circle {
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    flex-shrink: 0;
}

.legend-label {
    font-size: 0.9rem;
    color: #4b5563;
    font-weight: 500;
}

/* CADRE FILTRE */
.filter-container {
    position: absolute;
    bottom: 1rem;
    left: 17rem;
    background-color: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-width: 280px;
    min-width: 250px;
}

.filter-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.8rem;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.filter-content {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.2rem;
}

.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    padding: 0.3rem 0;
}

.filter-checkbox input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.filter-checkbox-label {
    font-size: 0.85rem;
    color: #4b5563;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-color-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 1px solid #e5e7eb;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.filter-btn {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
}

.filter-btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
}

.filter-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
}

.filter-btn-secondary {
    background-color: #6b7280;
    color: white;
}

.filter-btn-secondary:hover {
    background-color: #4b5563;
}

.map-type-controls {
position: absolute;
top: 4rem;
right: 4.5rem;
z-index: 1000;
display: flex;
flex-direction: column;
gap: 0.5rem;
}
.loading {
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
background: white;
padding: 20px;
border-radius: 8px;
box-shadow: 0 4px 6px rgba(0,0,0,0.1);
z-index: 1000;
display: none;
}

/* POINTS SIMPLES - TAILLE RÉDUITE POUR MIEUX SÉPARER */
.simple-point {
    border-radius: 50%;
    width: 10px;
    height: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}
.simple-point:hover {
    transform: scale(1.8);
}

/* MODAL DE RECHERCHE */
.search-modal {
    position: absolute;
    top: 4rem;
    left: 16rem;
    z-index: 1000;
    width: 350px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    display: none;
    overflow: hidden;
}

.search-modal.active {
    display: block;
}

.search-modal-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: white;
    padding: 1.2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.search-modal-title {
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.close-search-modal {
    background: none;
    border: none;
    font-size: 1.3rem;
    cursor: pointer;
    color: white;
    opacity: 0.8;
}

.close-search-modal:hover {
    opacity: 1;
}

.search-modal-body {
    padding: 1.5rem;
}

.coord-type-selector {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.2rem;
    background: #f8f9fa;
    padding: 0.5rem;
    border-radius: 8px;
}

.coord-type-btn {
    flex: 1;
    padding: 0.6rem;
    border: none;
    border-radius: 6px;
    background: transparent;
    color: #6b7280;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.coord-type-btn.active {
    background: white;
    color: #2563eb;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.coord-input-group {
    margin-bottom: 1rem;
}

.coord-input-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.4rem;
}

.coord-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.coord-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.coord-buttons {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.coord-btn {
    flex: 1;
    padding: 0.75rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.coord-btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
}

.coord-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
}

.coord-btn-secondary {
    background-color: #6b7280;
    color: white;
}

.coord-btn-secondary:hover {
    background-color: #4b5563;
}

.coord-result {
    margin-top: 1rem;
    padding: 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    display: none;
    border-left: 4px solid transparent;
}

.coord-result.success {
    background-color: #f0f9ff;
    color: #0369a1;
    border-left-color: #0ea5e9;
    display: block;
}

.coord-result.error {
    background-color: #fef2f2;
    color: #dc2626;
    border-left-color: #ef4444;
    display: block;
}

.coord-system-info {
    font-size: 0.7rem;
    color: #6b7280;
    margin-top: 0.3rem;
    font-style: italic;
}

/* Ajustement responsive */
@media (max-width: 768px) {
    .descente-detail {
        width: calc(100% - 2rem);
        max-height: 300px;
    }
    
    .search-modal {
        width: calc(100% - 2rem);
    }
    
    .legend-container {
        max-width: 200px;
    }
    
    .filter-container {
        max-width: 200px;
        min-width: 180px;
    }
    
    .map-type-controls {
        right: 1rem;
    }
}
</style>
</head>
<body style="margin:0 !important;">

<div class="main-container">
    <div class="map-container">
        <div id="map"></div>
    </div>
</div>

<!-- MODAL DE RECHERCHE -->
<div class="search-modal" id="search-modal">
    <div class="search-modal-header">
        <h3 class="search-modal-title">
            <i class="fas fa-search-location"></i> Recherche de Coordonnées
        </h3>
        <button class="close-search-modal" id="close-search-modal">&times;</button>
    </div>
    <div class="search-modal-body">
        <div class="coord-type-selector">
            <button class="coord-type-btn active" data-type="laborde">
                <i class="fas fa-map-marked-alt"></i> Laborde
            </button>
            <button class="coord-type-btn" data-type="latlon">
                <i class="fas fa-globe-americas"></i> Lat/Lon
            </button>
        </div>

        <div id="laborde-fields" class="coord-fields">
            <div class="coord-input-group">
                <label for="coord-x">Coordonnée X (Laborde)</label>
                <input type="number" id="coord-x" class="coord-input" placeholder="Ex: 516531" step="any">
                <div class="coord-system-info">Système EPSG:8441 - Madagascar Laborde</div>
            </div>
            <div class="coord-input-group">
                <label for="coord-y">Coordonnée Y (Laborde)</label>
                <input type="number" id="coord-y" class="coord-input" placeholder="Ex: 802042" step="any">
                <div class="coord-system-info">Système EPSG:8441 - Madagascar Laborde</div>
            </div>
        </div>

        <div id="latlon-fields" class="coord-fields" style="display: none;">
            <div class="coord-input-group">
                <label for="coord-lat">Latitude (WGS84)</label>
                <input type="number" id="coord-lat" class="coord-input" placeholder="Ex: -18.879439" step="any" min="-25.6" max="-12.0">
                <div class="coord-system-info">WGS84 - Entre -25.6° et -12.0° (Madagascar)</div>
            </div>
            <div class="coord-input-group">
                <label for="coord-lon">Longitude (WGS84)</label>
                <input type="number" id="coord-lon" class="coord-input" placeholder="Ex: 47.543402" step="any" min="43.0" max="50.5">
                <div class="coord-system-info">WGS84 - Entre 43.0° et 50.5° (Madagascar)</div>
            </div>
        </div>

        <div class="coord-buttons">
            <button class="coord-btn coord-btn-secondary" id="clear-coord-search">
                <i class="fas fa-eraser"></i> Effacer
            </button>
            <button class="coord-btn coord-btn-primary" id="search-by-coord">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
        <div class="coord-result" id="coord-result"></div>
    </div>
</div>

<!-- CONTRÔLES -->
<div class="map-type-controls">
    <button class="map-btn active" id="view-oms" title="Vue OSM">
        <i class="fas fa-layer-group"></i>
    </button>
    <button class="map-btn" id="view-satellite" title="Vue Satellite">
        <i class="fas fa-satellite"></i>
    </button>
    <button class="map-btn" id="toggle-search-modal" title="Recherche par Coordonnées">
        <i class="fas fa-crosshairs"></i>
    </button>
</div>

<div class="map-controls">
    <button class="map-btn" id="zoom-in" title="Zoom In">
        <i class="fas fa-plus"></i>
    </button>
    <button class="map-btn" id="zoom-out" title="Zoom Out">
        <i class="fas fa-minus"></i>
    </button>
    <button class="map-btn" id="reset-map" title="Vue d'ensemble">
        <i class="fas fa-globe-americas"></i>
    </button>
    <button class="map-btn" id="locate-me" title="Me Localiser">
        <i class="fas fa-location-arrow"></i>
    </button>
</div>

<!-- CADRE FILTRE EN BAS À GAUCHE -->
<div class="filter-container" id="filter-container">
    <h3 class="filter-title">
        <i class="fas fa-filter"></i> Filtres d'affichage
    </h3>
    <div class="filter-content">
        <div class="filter-group">
            <div class="filter-group-title">Types de points</div>
            <label class="filter-checkbox">
                <input type="checkbox" id="filter-descentes" checked>
                <span class="filter-checkbox-label">
                    <span class="filter-color-indicator" style="background-color: #f50b0bff;"></span>
                    Descentes (sans FT)
                </span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" id="filter-ft" checked>
                <span class="filter-checkbox-label">
                    <span class="filter-color-indicator" style="background-color: #10b981;"></span>
                    FT établis
                </span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" id="filter-ap" checked>
                <span class="filter-checkbox-label">
                    <span class="filter-color-indicator" style="background-color: #FF8C00;"></span>
                    AP établis
                </span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" id="filter-archives" checked>
                <span class="filter-checkbox-label">
                    <span class="filter-color-indicator" style="background-color: #3b82f6;"></span>
                    Archives
                </span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" id="filter-special" checked>
                <span class="filter-checkbox-label">
                    <span class="filter-color-indicator" style="background-color: #8B4513;"></span>
                    Constructions spéciales
                </span>
            </label>
        </div>
        
        <div class="filter-actions">
            <button class="filter-btn filter-btn-secondary" id="reset-filters">
                <i class="fas fa-undo"></i> Réinitialiser
            </button>
            <button class="filter-btn filter-btn-primary" id="apply-filters">
                <i class="fas fa-check"></i> Appliquer
            </button>
        </div>
    </div>
</div>

<!-- LÉGENDE - SIMPLIFIÉE ET TOUJOURS VISIBLE -->
<div class="legend-container" id="legend-container">
    <h3 class="legend-title">
        <i class="fas fa-key"></i> Légende
    </h3>
    <div class="legend-content">
        <div class="legend-item">
            <div class="legend-color" style="background-color: #f50b0bff;"></div>
            <span class="legend-label">Descentes (sans FT)</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background-color: #10b981;"></div>
            <span class="legend-label">FT établis</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background-color: #FF8C00;"></div>
            <span class="legend-label">AP établis</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background-color: #3b82f6;"></div>
            <span class="legend-label">Archives</span>
        </div>
    <div class="legend-item">
    <div class="legend-color" style="background-color: #8B4513;"></div>
    <span class="legend-label">Construction sur zone de protection</span>
</div>
    </div>
</div>

<!-- DÉTAILS -->
<div class="descente-detail" id="descente-detail">
    <div class="detail-header">
        <h3 class="detail-title">Détails</h3>
        <button class="close-detail" id="close-detail">&times;</button>
    </div>
    <div class="detail-content" id="detail-content">
        Sélectionnez un point pour voir les détails
    </div>
</div>

<!-- LOADING -->
<div class="loading" id="loading">
    <i class="fas fa-spinner fa-spin"></i> Chargement des données...
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.8.0/proj4.js"></script>
<script>
// Données dynamiques depuis le contrôleur
const descentesData = @json($descentes ?? []);
const archivesData = @json($archives ?? []);

// DEBUG: Afficher les données reçues
console.log('📊 DONNÉES DESCENTES:', descentesData);
console.log('📊 DONNÉES ARCHIVES:', archivesData);
console.log('📊 NOMBRE DESCENTES:', descentesData.length);
console.log('📊 NOMBRE ARCHIVES:', archivesData.length);

// Afficher les premières descentes pour inspection
if (descentesData.length > 0) {
    console.log('🔍 PREMIÈRE DESCENTE:', descentesData[0]);
    console.log('🔍 CHAMPS DESCENTE:', Object.keys(descentesData[0]));
}

// Variables globales
let coordMarker = null;
let currentCoordType = 'laborde';
let activeLayers = {
    'descentes': true,
    'ft': true,
    'ap': true,
    'archives': true,
    'special': true
};

// Initialiser la carte centrée sur Madagascar
const map = L.map('map').setView([-18.766947, 46.869107], 6);

// Styles de carte
const mapStyles = {
  'OSM': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
  }),
  'Satellite': L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    attribution: 'Imagery © Google',
    maxZoom: 22
  })
};

mapStyles['OSM'].addTo(map);
let currentMapStyle = 'OSM';

// Groupes pour les marqueurs
const markers = L.featureGroup();
const descenteMarkers = L.featureGroup();
const ftMarkers = L.featureGroup();
const apMarkers = L.featureGroup();
const archiveMarkers = L.featureGroup();
const specialMarkers = L.featureGroup();

let descentesLayers = {};

// Configuration PROJ4
try {
    proj4.defs(
        "EPSG:8441",
        "+proj=omerc +lat_0=-18.9 +lonc=46.43722916666667 +alpha=18.9 +k=0.9995 +x_0=400000 +y_0=800000 +ellps=intl +towgs84=-189,-242,-91,0,0,0,0 +units=m +no_defs"
    );
    console.log("✅ Projection EPSG:8441 configurée");
} catch (e) {
    console.error("❌ Erreur configuration EPSG:8441:", e);
}

// FONCTION AMÉLIORÉE POUR VALIDER LES COORDONNÉES LABORDE
function validateLabordeCoordinates(x, y) {
    const MIN_X = 400000, MAX_X = 1000000;
    const MIN_Y = 400000, MAX_Y = 1000000;
    
    if (x < MIN_X || x > MAX_X || y < MIN_Y || y > MAX_Y) {
        console.log(`❌ Coordonnées hors plage: X=${x}, Y=${y}`);
        return false;
    }
    return true;
}

// FONCTION AMÉLIORÉE POUR FILTRER LES COORDONNÉES NULLES
function filterInvalidCoordinates(data, type = 'descente') {
    console.log(`🔍 Filtrage des ${type}s - Données initiales: ${data.length}`);
    
    const filteredData = data.filter(item => {
        let x, y;
        
        if (type === 'descente') {
            // Vérifier la structure des données de descente
            console.log('🔍 Structure descente:', item);
            
            x = parseFloat(item.x_laborde);
            y = parseFloat(item.y_laborde);
            
            console.log(`🔍 Descente ${item.id}: x_laborde=${item.x_laborde}, y_laborde=${item.y_laborde}`);
            console.log(`🔍 Descente ${item.id}: x_parsed=${x}, y_parsed=${y}`);
        } else {
            x = parseFloat(item.xv);
            y = parseFloat(item.yv);
        }
        
        // Vérification stricte des valeurs nulles, vides ou invalides
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y) || 
            x === null || y === null || x === undefined || y === undefined) {
            console.log(`❌ Point ${type} ${item.id} filtré - Coordonnées invalides:`, {x, y});
            return false;
        }
        
        // Validation des plages Laborde
        if (!validateLabordeCoordinates(x, y)) {
            console.log(`❌ Point ${type} ${item.id} filtré - Hors plage Laborde:`, {x, y});
            return false;
        }
        
        return true;
    });
    
    console.log(`✅ ${type}s après filtrage: ${filteredData.length} valides sur ${data.length}`);
    return filteredData;
}

// FONCTION DE CONVERSION PRÉCISE LABORDE -> WGS84
function labordeToWGS84(x, y) {
    console.log(`🔄 Conversion Laborde->WGS84: X=${x}, Y=${y}`);
    
    if (!x || !y || x == 0 || y == 0 || isNaN(x) || isNaN(y)) {
        console.log('❌ Coordonnées Laborde invalides pour conversion');
        return null;
    }
    
    if (!validateLabordeCoordinates(x, y)) {
        console.log('❌ Coordonnées hors des plages valides pour Madagascar');
        return null;
    }
    
    try {
        if (!proj4.defs("EPSG:8441")) {
            console.error("❌ Projection EPSG:8441 non définie");
            return null;
        }
        
        // Conversion précise avec proj4
        const fromProj = "EPSG:8441";
        const toProj = "EPSG:4326"; // WGS84
        const result = proj4(fromProj, toProj, [x, y]);
        const lon = result[0];
        const lat = result[1];
        
        console.log(`📍 Conversion PROJ4 réussie: Laborde(${x}, ${y}) -> WGS84(${lat.toFixed(6)}, ${lon.toFixed(6)})`);
        
        // Validation des coordonnées résultantes (limites de Madagascar)
        if (lat < -25.6 || lat > -12.0 || lon < 43.0 || lon > 50.5) {
            console.warn('⚠️ Coordonnées hors des limites de Madagascar:', lat, lon);
            return null;
        }
        
        return [lat, lon];
    } catch (error) {
        console.error('❌ Erreur de conversion Laborde->WGS84:', error);
        return null;
    }
}

// FONCTION POUR VÉRIFIER SI LA SURFACE EST SPÉCIFIÉE
function isSurfaceSpecified(surface) {
    if (!surface || surface === 'null' || surface === '' || 
        surface === 'N/A' || surface === 'Non spécifié') {
        return false;
    }
    
    const surfaceValue = parseFloat(surface);
    return !isNaN(surfaceValue) && surfaceValue > 0;
}

// FONCTION POUR CALCULER LE RAYON BASÉ SUR LA SURFACE
function calculateRadiusFromSurface(surface) {
    // Vérifier d'abord si la surface est spécifiée
    if (!isSurfaceSpecified(surface)) {
        return null; // Retourner null pour indiquer un point simple
    }
    
    // Convertir en nombre
    const surfaceValue = parseFloat(surface);
    
    // Facteur d'échelle réduit pour mieux séparer les points
    const scaleFactor = 0.2;
    
    // Calculer le rayon proportionnel à la racine carrée de la surface
    let radius = Math.sqrt(surfaceValue) * scaleFactor;
    
    // Limiter la taille minimale et maximale
    const minRadius = 50;   // Rayon minimum en mètres
    const maxRadius = 1500; // Rayon maximum réduit en mètres
    
    return Math.max(minRadius, Math.min(maxRadius, radius));
}

// FONCTION POUR OBTENIR LA CLASSE DE SURFACE
function getSurfaceClass(surface) {
    if (!isSurfaceSpecified(surface)) {
        return 'Non spécifiée';
    }
    
    const surfaceValue = parseFloat(surface);
    if (surfaceValue <= 500) return 'Très petite (≤ 500 m²)';
    if (surfaceValue <= 2000) return 'Petite (500-2 000 m²)';
    if (surfaceValue <= 5000) return 'Moyenne (2 000-5 000 m²)';
    return 'Grande (> 5 000 m²)';
}

// FONCTION POUR FORMATER LES SURFACES
function formatSurface(surface) {
    if (!isSurfaceSpecified(surface)) {
        return 'Non spécifié';
    }
    
    // Si c'est déjà formaté (contient "m²"), retourner tel quel
    if (typeof surface === 'string' && surface.includes('m²')) {
        return surface;
    }
    
    // Si c'est un nombre, formater avec unité
    const num = parseFloat(surface);
    if (!isNaN(num)) {
        return `${num.toLocaleString('fr-FR')} m²`;
    }
    
    return surface;
}

// FONCTION POUR FORMATER LES COORDONNÉES
function formatCoordinates(coord) {
    if (!coord || coord === 'null' || coord === '' || coord === 'N/A') {
        return 'Non spécifié';
    }
    
    const num = parseFloat(coord);
    if (!isNaN(num)) {
        return num.toLocaleString('fr-FR');
    }
    
    return coord;
}

// FONCTION DE CONVERSION WGS84 -> LABORDE
function wgs84ToLaborde(lat, lon) {
    if (!lat || !lon || isNaN(lat) || isNaN(lon)) {
        console.log('Coordonnées WGS84 invalides:', lat, lon);
        return null;
    }
    try {
        if (!proj4.defs("EPSG:8441")) {
            console.error("Projection EPSG:8441 non définie");
            return null;
        }
        // Conversion WGS84 vers Laborde
        const fromProj = "EPSG:4326";
        const toProj = "EPSG:8441";
        const result = proj4(fromProj, toProj, [lon, lat]);
        const x = result[0];
        const y = result[1];
        console.log(`📍 Conversion PROJ4: WGS84(${lat}, ${lon}) -> Laborde(${x.toFixed(2)}, ${y.toFixed(2)})`);
        return { x: Math.round(x), y: Math.round(y) };
    } catch (error) {
        console.error('❌ Erreur de conversion WGS84->Laborde:', error);
        return null;
    }
}

// FONCTION POUR FORMATER LA DATE EN jj/mm/aaaa
function formatDate(dateString) {
    if (!dateString || dateString === 'Non spécifié' || dateString === 'null') {
        return 'Non spécifié';
    }
    
    try {
        const cleanString = dateString.toString().trim();
        
        if (cleanString.match(/^\d{1,2}\/\d{1,2}\/\d{4}$/)) {
            return cleanString;
        }
        
        if (cleanString.match(/^\d{4}-\d{1,2}-\d{1,2}$/)) {
            const parts = cleanString.split('-');
            const day = String(parts[2]).padStart(2, '0');
            const month = String(parts[1]).padStart(2, '0');
            const year = parts[0];
            return `${day}/${month}/${year}`;
        }
        
        if (cleanString.match(/^\d{4}-\d{2}-\d{2}T/)) {
            const date = new Date(cleanString);
            if (!isNaN(date.getTime())) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
        }
        
        const date = new Date(cleanString);
        if (!isNaN(date.getTime())) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
        
        return cleanString;
    } catch (error) {
        return dateString;
    }
}

function getValueOrNotSpecified(value, isSurface = false, isCoordinate = false) {
    if (!value || value === 'null' || value === '' || value === 'N/A' || value === 'Non spécifié') {
        return 'Non spécifié';
    }
    
    // Si c'est une surface, appliquer le formatage
    if (isSurface) {
        return formatSurface(value);
    }
    
    // Si c'est une coordonnée, appliquer le formatage
    if (isCoordinate) {
        return formatCoordinates(value);
    }
    
    return value;
}

// FONCTION POUR APPLIQUER LES FILTRES
function applyFilters() {
    // Mettre à jour l'état des couches
    activeLayers = {
        'descentes': document.getElementById('filter-descentes').checked,
        'ft': document.getElementById('filter-ft').checked,
        'ap': document.getElementById('filter-ap').checked,
        'archives': document.getElementById('filter-archives').checked,
        'special': document.getElementById('filter-special').checked
    };
    
    // Appliquer les filtres aux groupes de marqueurs
    if (activeLayers.descentes) {
        map.addLayer(descenteMarkers);
    } else {
        map.removeLayer(descenteMarkers);
    }
    
    if (activeLayers.ft) {
        map.addLayer(ftMarkers);
    } else {
        map.removeLayer(ftMarkers);
    }
    
    if (activeLayers.ap) {
        map.addLayer(apMarkers);
    } else {
        map.removeLayer(apMarkers);
    }
    
    if (activeLayers.archives) {
        map.addLayer(archiveMarkers);
    } else {
        map.removeLayer(archiveMarkers);
    }
    
    if (activeLayers.special) {
        map.addLayer(specialMarkers);
    } else {
        map.removeLayer(specialMarkers);
    }
    
    console.log('✅ Filtres appliqués:', activeLayers);
}

// FONCTION POUR RÉINITIALISER LES FILTRES
function resetFilters() {
    document.getElementById('filter-descentes').checked = true;
    document.getElementById('filter-ft').checked = true;
    document.getElementById('filter-ap').checked = true;
    document.getElementById('filter-archives').checked = true;
    document.getElementById('filter-special').checked = true;
    
    applyFilters();
}

// FONCTION AMÉLIORÉE POUR AJOUTER LES DESCENTES
function addDescentesToMap(descentes) {
    let coordsValides = 0;
    let coordsInvalides = 0;
    let descentesAvecFT = 0;
    let descentesSansFT = 0;
    let descentesAvecAP = 0;
    let descentesAvecSurface = 0;
    let descentesSansSurface = 0;

    console.log(`🗺️ Début ajout des ${descentes.length} descentes à la carte`);

    descentes.forEach((descente, index) => {
        const x = parseFloat(descente.x_laborde);
        const y = parseFloat(descente.y_laborde);
        
        console.log(`🔍 Traitement descente ${index + 1}/${descentes.length}: ID=${descente.id}, X=${x}, Y=${y}, FT_ID=${descente.ft_id}, AP=${descente.ap}, Surface=${descente.sup_remblais}`);

        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
            console.log(`❌ Descente ${descente.id} ignorée - Coordonnées invalides`);
            coordsInvalides++;
            return;
        }

        const coords = labordeToWGS84(x, y);
        if (!coords) {
            console.log(`❌ Descente ${descente.id} ignorée - Conversion échouée`);
            coordsInvalides++;
            return;
        }

        coordsValides++;
        
        // DÉTERMINER LA COULEUR SELON FT_ID ET AP
        let pointColor, borderColor, pointType;
        let surfaceSpecifiee = false;
        let targetGroup = descenteMarkers; // Groupe par défaut
        
        if (descente.ap) {
            // AP établi - ORANGE FONCÉ POUR MEILLEURE VISIBILITÉ
            pointColor = '#FF8C00'; // Orange foncé plus visible
            borderColor = '#FF4500'; // Bordure orange-rouge
            pointType = 'AP établi';
            targetGroup = apMarkers;
            descentesAvecAP++;
            
            // Vérifier si la surface est spécifiée pour les AP
            surfaceSpecifiee = isSurfaceSpecified(descente.sup_remblais);
            if (surfaceSpecifiee) {
                descentesAvecSurface++;
            } else {
                descentesSansSurface++;
            }
        } else if (descente.ft_id && descente.ft_id !== 'null' && descente.ft_id !== '' && descente.ft_id !== 'Non spécifié') {
            // FT établi - POINT VERT
            pointColor = '#10b981';
            borderColor = '#059669';
            pointType = 'FT établi';
            targetGroup = ftMarkers;
            descentesAvecFT++;
        } else {
            // Pas de FT - POINT ROUGE
            pointColor   = '#f50b0bff';
            borderColor  = '#cc0000';
            pointType    = 'Descente';
            targetGroup = descenteMarkers;
            descentesSansFT++;
        }
        
        console.log(`✅ Descente ${descente.id} ajoutée: ${coords[0].toFixed(6)}, ${coords[1].toFixed(6)} - Type: ${pointType}, Surface: ${surfaceSpecifiee ? 'Oui' : 'Non'}`);

        let layer;
        
        // POUR TOUS LES AP AVEC SURFACE SPÉCIFIÉE, CRÉER UN CERCLE PROPORTIONNEL
        // Y COMPRIS POUR LA SURFACE DE 658 M²
        if (descente.ap && surfaceSpecifiee) {
            const radius = calculateRadiusFromSurface(descente.sup_remblais);
            const surfaceClass = getSurfaceClass(descente.sup_remblais);
            
            layer = L.circle(coords, {
                radius: radius,
                color: pointColor,
                fillColor: pointColor,
                fillOpacity: 0.5, // Opacité augmentée pour meilleure visibilité
                weight: 3 // Épaisseur augmentée
            });
            
            console.log(`📏 AP ${descente.id}: Surface ${descente.sup_remblais} m² -> Rayon ${Math.round(radius)} m`);
        } else {
            // Pour les autres cas (FT, descentes sans FT, AP sans surface), créer un point simple
            layer = L.marker(coords, {
                icon: L.divIcon({
                    html: `<div class="simple-point" style="background-color: ${pointColor}; border: 2px solid ${borderColor};"></div>`,
                    className: 'simple-point-container',
                    iconSize: [12, 12], // Taille légèrement augmentée
                    iconAnchor: [6, 6]
                })
            });
        }

        const surfaceClass = getSurfaceClass(descente.sup_remblais);
        const surfaceSpecifieeForPopup = isSurfaceSpecified(descente.sup_remblais);

        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: ${pointColor}; margin-bottom: 0.5rem; border-bottom: 2px solid ${pointColor}; padding-bottom: 0.5rem;">
                    ${pointType} #${descente.id}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. OM:</strong> ${getValueOrNotSpecified(descente.ref_om)}</p>
                    <p><strong>Surface:</strong> ${getValueOrNotSpecified(descente.sup_remblais, true)}</p>
                    <p><strong>FT ID:</strong> ${getValueOrNotSpecified(descente.ft_id)}</p>
                    <p><strong>AP:</strong> ${descente.ap ? 'Oui' : 'Non'}</p>
                    <p><strong>Date:</strong> ${formatDate(descente.date)}</p>
                    <p><strong>Adresse:</strong> ${getValueOrNotSpecified(descente.adresse)}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(descente.comm)}</p>
                    <p><strong>Constat:</strong> ${getValueOrNotSpecified(descente.constat)}</p>
                    ${descente.ap && surfaceSpecifieeForPopup ? `
                        <p><strong>Catégorie surface:</strong> ${surfaceClass}</p>
                        <p><strong>Type d'affichage:</strong> Cercle proportionnel (${Math.round(layer.options?.radius || 0)} m)</p>
                    ` : ''}
                    <p><strong>Coordonnées Laborde:</strong> X=${x}, Y=${y}</p>
                    <p><strong>Coordonnées WGS84:</strong> ${coords[0].toFixed(6)}, ${coords[1].toFixed(6)}</p>
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: ${pointColor}; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showDescenteDetail('${descente.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        layer.bindPopup(popupContent);

        descentesLayers[`descente_${descente.id}`] = layer;
        targetGroup.addLayer(layer);
    });

    console.log(`📊 RÉSULTAT DESCENTES: ${coordsValides} valides, ${coordsInvalides} invalides`);
    console.log(`📊 RÉPARTITION: ${descentesAvecAP} AP (${descentesAvecSurface} avec surface, ${descentesSansSurface} sans surface), ${descentesAvecFT} FT, ${descentesSansFT} sans FT`);
}

// FONCTION POUR AJOUTER LES ARCHIVES
function addArchivesToMap(archives) {
    let archivesValides = 0;
    let archivesAvecSurface = 0;
    let archivesSansSurface = 0;
    let archivesMarron = 0; // Compteur pour les archives marron
    
    console.log(`🗺️ Début ajout des ${archives.length} archives à la carte`);

    archives.forEach(archive => {
        const x = parseFloat(archive.xv);
        const y = parseFloat(archive.yv);
        
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
            return;
        }
        
        if (!validateLabordeCoordinates(x, y)) {
            return;
        }
        
        const coords = labordeToWGS84(x, y);
        if (!coords) {
            return;
        }
        
        archivesValides++;
        
        // Vérifier si l'archive correspond aux critères pour être marron
        const findingofLower = (archive.findingof || '').toLowerCase();
        const isMarron = findingofLower.includes('lit') ||
                        findingofLower.includes('digue') ||
                        findingofLower.includes('alignement') ||
                        findingofLower.includes('canal') ||
                        findingofLower.includes('voie') ||
                        findingofLower.includes('voi') ||
                        findingofLower.includes('publique') ||
                        findingofLower.includes('public') ||
                        findingofLower.includes('emprise');
        
        // Définir les couleurs selon la condition
        let pointColor, borderColor;
        let targetGroup = archiveMarkers;
        
        if (isMarron) {
            pointColor = '#8B4513'; // Marron
            borderColor = '#654321'; // Marron foncé
            targetGroup = specialMarkers;
            archivesMarron++;
        } else {
            pointColor = '#3b82f6'; // Bleu normal
            borderColor = '#1d4ed8'; // Bleu foncé normal
            targetGroup = archiveMarkers;
        }
        
        // Vérifier si la surface est spécifiée
        const surfaceSpecifiee = isSurfaceSpecified(archive.backfilledarea);
        const surfaceClass = getSurfaceClass(archive.backfilledarea);
        
        let layer;
        
        if (!surfaceSpecifiee) {
            // Surface non spécifiée - POINT SIMPLE
            archivesSansSurface++;
            layer = L.marker(coords, {
                icon: L.divIcon({
                    html: `<div class="simple-point" style="background-color: ${pointColor}; border: 2px solid ${borderColor};"></div>`,
                    className: 'simple-point-container',
                    iconSize: [8, 8],
                    iconAnchor: [4, 4]
                })
            });
        } else {
            // Surface spécifiée - CERCLE PROPORTIONNEL
            archivesAvecSurface++;
            const radius = calculateRadiusFromSurface(archive.backfilledarea);
            layer = L.circle(coords, {
                radius: radius,
                color: pointColor,
                fillColor: pointColor,
                fillOpacity: 0.3,
                weight: 2
            });
        }

        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: ${pointColor}; margin-bottom: 0.5rem; border-bottom: 2px solid ${pointColor}; padding-bottom: 0.5rem;">
                    Archive #${archive.id} ${isMarron ? '🚨' : ''}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. Arrivée:</strong> ${getValueOrNotSpecified(archive.arrivalid)}</p>
                    <p><strong>Date Arrivée:</strong> ${formatDate(archive.arrivaldate)}</p>
                    <p><strong>Service:</strong> ${getValueOrNotSpecified(archive.sendersce)}</p>
                    <p><strong>Demandeur:</strong> ${getValueOrNotSpecified(archive.applicantname)}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(archive.municipality)}</p>
                    <p><strong>Propriétaire:</strong> ${getValueOrNotSpecified(archive.property0wner)}</p>
                    <p><strong>Constat:</strong> ${getValueOrNotSpecified(archive.findingof)}</p>
                    <p><strong>Surface totale:</strong> ${getValueOrNotSpecified(archive.surfacearea, true)}</p>
                    <p><strong>Surface remblayée:</strong> ${getValueOrNotSpecified(archive.backfilledarea, true)}</p>
                    <p><strong>Catégorie surface:</strong> ${surfaceClass}</p>
                    ${isMarron ? '<p><strong style="color: #8B4513;">⚠️ Archive spéciale (marron)</strong></p>' : ''}
                    ${surfaceSpecifiee ? `<p><strong>Type d'affichage:</strong> Cercle proportionnel (${Math.round(layer.options.radius)} m)</p>` : '<p><strong>Type d\'affichage:</strong> Point simple (surface non spécifiée)</p>'}
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: ${pointColor}; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showArchiveDetail('${archive.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        layer.bindPopup(popupContent);

        descentesLayers[`archive_${archive.id}`] = layer;
        targetGroup.addLayer(layer);
    });

    console.log(`✅ ${archivesValides} archives affichées (${archivesAvecSurface} avec surface, ${archivesSansSurface} sans surface, ${archivesMarron} archives marron)`);
}

// Fonctions pour afficher les détails
function showDescenteDetail(descenteId) {
    const descente = descentesData.find(d => d.id == descenteId);
    if (!descente) return;

    // Déterminer le type et la couleur
    let typeColor, typeLabel;
    
    if (descente.ap) {
        typeColor = '#FF8C00'; // Orange foncé pour AP
        typeLabel = 'AP établi';
    } else if (descente.ft_id && descente.ft_id !== 'null' && descente.ft_id !== '' && descente.ft_id !== 'Non spécifié') {
        typeColor = '#10b981';
        typeLabel = 'FT établi';
    } else {
        typeColor = '#f50b0bff';
        typeLabel = 'Descente';
    }

    const surfaceClass = getSurfaceClass(descente.sup_remblais);
    const surfaceSpecifiee = isSurfaceSpecified(descente.sup_remblais);

    const detailContent = `
        <div class="detail-section">
            <h4 style="color: ${typeColor};">${typeLabel} #${descente.id}</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Réf. OM</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.ref_om)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">FT ID</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.ft_id)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">AP</span>
                    <span class="detail-value">${descente.ap ? 'Oui' : 'Non'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date</span>
                    <span class="detail-value">${formatDate(descente.date)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Heure</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.heure)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Réf. PV</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.ref_pv)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: ${typeColor};">Localisation</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Adresse</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.adresse)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Commune</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.comm)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">District</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.dist)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Fokontany</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.fkt)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: ${typeColor};">Informations techniques</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Surface (m²)</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.sup_remblais, true)}</span>
                </div>
                ${descente.ap ? `
                <div class="detail-item">
                    <span class="detail-label">Catégorie surface</span>
                    <span class="detail-value">${surfaceClass}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Type d'affichage</span>
                    <span class="detail-value">${surfaceSpecifiee ? 'Cercle proportionnel' : 'Point simple (surface non spécifiée)'}</span>
                </div>
                ` : ''}
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: ${typeColor};">Coordonnées</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Coordonnée X (Laborde)</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.x_laborde, false, true)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Coordonnée Y (Laborde)</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.y_laborde, false, true)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: ${typeColor};">Actions</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Action</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.action)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Constat</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.constat)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Personnes verbalisées</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.pers_verb)}</span>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detail-content').innerHTML = detailContent;
    document.getElementById('descente-detail').classList.add('active');
}

function showArchiveDetail(archiveId) {
    const archive = archivesData.find(a => a.id == archiveId);
    if (!archive) return;

    const surfaceClass = getSurfaceClass(archive.backfilledarea);
    const surfaceSpecifiee = isSurfaceSpecified(archive.backfilledarea);

    const detailContent = `
        <div class="detail-section">
            <h4 style="color: #3b82f6;">Informations Archive</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Réf. Arrivée</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.arrivalid)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date Arrivée</span>
                    <span class="detail-value">${formatDate(archive.arrivaldate)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.sendersce)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Année exercice</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.exoyear)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: #3b82f6;">Localisation</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Demandeur</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.applicantname)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Commune</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.municipality)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Localité</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.locality)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Propriétaire</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.property0wner)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: #3b82f6;">Coordonnées</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Coordonnée X (Laborde)</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.xv, false, true)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Coordonnée Y (Laborde)</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.yv, false, true)}</span>
                </div>
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: #3b82f6;">Informations techniques</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Surface totale (m²)</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.surfacearea, true)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Surface remblayée (m²)</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.backfilledarea, true)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Catégorie surface</span>
                    <span class="detail-value">${surfaceClass}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Type d'affichage</span>
                    <span class="detail-value">${surfaceSpecifiee ? 'Cercle proportionnel' : 'Point simple (surface non spécifiée)'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Zone</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.zoning)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Constat</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.findingof)}</span>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detail-content').innerHTML = detailContent;
    document.getElementById('descente-detail').classList.add('active');
}

// Fonctions pour les contrôles de carte
function changeMapStyle(style) {
    mapStyles[currentMapStyle].remove();
    mapStyles[style].addTo(map);
    currentMapStyle = style;
    document.getElementById('view-oms').classList.toggle('active', style === 'OSM');
    document.getElementById('view-satellite').classList.toggle('active', style === 'Satellite');
}

// FONCTION POUR RECHERCHER ET AFFICHER UN POINT PAR COORDONNÉES
function searchByCoordinates() {
    const resultDiv = document.getElementById('coord-result');
    
    let coords, x, y, lat, lon;

    if (currentCoordType === 'laborde') {
        // Recherche par Laborde
        x = document.getElementById('coord-x').value;
        y = document.getElementById('coord-y').value;
        
        if (!x || !y || isNaN(x) || isNaN(y)) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Veuillez entrer des coordonnées Laborde valides';
            return;
        }

        // Validation des plages
        if (!validateLabordeCoordinates(x, y)) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Coordonnées hors des plages valides pour Madagascar (X: 400000-600000, Y: 800000-1000000)';
            return;
        }

        // Convertir les coordonnées Laborde en WGS84
        coords = labordeToWGS84(parseFloat(x), parseFloat(y));
        
        if (!coords) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Conversion des coordonnées Laborde échouée. Vérifiez les valeurs.';
            return;
        }

        lat = coords[0];
        lon = coords[1];

    } else {
        lat = parseFloat(document.getElementById('coord-lat').value);
        lon = parseFloat(document.getElementById('coord-lon').value);
        
        if (!lat || !lon || isNaN(lat) || isNaN(lon)) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Veuillez entrer des coordonnées WGS84 valides';
            return;
        }

        if (lat < -25.6 || lat > -12.0 || lon < 43.0 || lon > 50.5) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Coordonnées hors des limites de Madagascar';
            return;
        }

        coords = [lat, lon];
    }

    if (coordMarker) {
        map.removeLayer(coordMarker);
    }

    coordMarker = L.marker(coords, {
        icon: L.divIcon({
            html: `<div class="simple-point" style="background-color: #dc2626; border: 2px solid #b91c1c;"></div>`,
            className: 'simple-point-container',
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        })
    }).addTo(map);

    const popupContent = `
        <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
            <h3 style="color: #dc2626; margin-bottom: 0.5rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">
                <i class="fas fa-crosshairs"></i> Point Recherché
            </h3>
            <div style="font-size: 0.9rem; color: #666;">
                <p><strong>Coordonnées WGS84:</strong><br>Lat: ${lat.toFixed(6)}<br>Lon: ${lon.toFixed(6)}</p>
                ${x && y ? `<p><strong>Coordonnées Laborde:</strong><br>X: ${x}<br>Y: ${y}</p>` : ''}
            </div>
        </div>
    `;
    
    coordMarker.bindPopup(popupContent).openPopup();
    map.setView(coords, 15);

    resultDiv.className = 'coord-result success';
    resultDiv.innerHTML = `<i class="fas fa-check-circle"></i> Point trouvé et affiché sur la carte<br>
                          <small>WGS84: ${lat.toFixed(6)}, ${lon.toFixed(6)}</small>`;
}

function changeCoordType(type) {
    currentCoordType = type;
    
    document.querySelectorAll('.coord-type-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.type === type);
    });
    
    document.getElementById('laborde-fields').style.display = type === 'laborde' ? 'block' : 'none';
    document.getElementById('latlon-fields').style.display = type === 'latlon' ? 'block' : 'none';
    
    document.getElementById('coord-result').className = 'coord-result';
    document.getElementById('coord-result').innerHTML = '';
}

// CHARGEMENT DES DONNÉES AVEC DÉBOGAGE AMÉLIORÉ
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Début du chargement des données...');
    
    // Contrôles de carte
    document.getElementById('zoom-in').addEventListener('click', () => map.zoomIn());
    document.getElementById('zoom-out').addEventListener('click', () => map.zoomOut());
    document.getElementById('reset-map').addEventListener('click', () => {
        map.setView([-18.766947, 46.869107], 6);
    });
    document.getElementById('locate-me').addEventListener('click', function() {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                map.setView([position.coords.latitude, position.coords.longitude], 10);
            }, function() {
                alert('Impossible de déterminer votre position.');
            });
        } else {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
        }
    });
    document.getElementById('close-detail').addEventListener('click', function() {
        document.getElementById('descente-detail').classList.remove('active');
    });
    document.getElementById('view-oms').addEventListener('click', () => changeMapStyle('OSM'));
    document.getElementById('view-satellite').addEventListener('click', () => changeMapStyle('Satellite'));

    // Recherche
    document.getElementById('toggle-search-modal').addEventListener('click', function() {
        const modal = document.getElementById('search-modal');
        modal.classList.toggle('active');
    });
    document.getElementById('close-search-modal').addEventListener('click', function() {
        document.getElementById('search-modal').classList.remove('active');
    });
    document.querySelectorAll('.coord-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            changeCoordType(this.dataset.type);
        });
    });
    document.getElementById('clear-coord-search').addEventListener('click', function() {
        document.getElementById('coord-x').value = '';
        document.getElementById('coord-y').value = '';
        document.getElementById('coord-lat').value = '';
        document.getElementById('coord-lon').value = '';
        document.getElementById('coord-result').className = 'coord-result';
        document.getElementById('coord-result').innerHTML = '';
        
        if (coordMarker) {
            map.removeLayer(coordMarker);
            coordMarker = null;
        }
    });
    document.getElementById('search-by-coord').addEventListener('click', searchByCoordinates);

    // Filtres
    document.getElementById('apply-filters').addEventListener('click', applyFilters);
    document.getElementById('reset-filters').addEventListener('click', resetFilters);

    // Afficher le loading
    document.getElementById('loading').style.display = 'block';
    
    setTimeout(() => {
        try {
            // Ajouter les groupes de marqueurs à la carte (initialement tous visibles)
            map.addLayer(descenteMarkers);
            map.addLayer(ftMarkers);
            map.addLayer(apMarkers);
            map.addLayer(archiveMarkers);
            map.addLayer(specialMarkers);
            
            console.log('🔍 FILTRAGE DES DONNÉES...');
            
            // Filtrer les données
            const validDescentes = filterInvalidCoordinates(descentesData, 'descente');
            const validArchives = filterInvalidCoordinates(archivesData, 'archive');
            
            console.log('📊 RÉSULTATS FILTRAGE:');
            console.log(`- Descentes: ${validDescentes.length} valides sur ${descentesData.length}`);
            console.log(`- Archives: ${validArchives.length} valides sur ${archivesData.length}`);
            
            // Ajouter les données à la carte
            if (validDescentes.length > 0) {
                console.log('🗺️ Ajout des descentes à la carte...');
                addDescentesToMap(validDescentes);
            } else {
                console.warn('⚠️ AUCUNE DESCENTE VALIDE APRÈS FILTRAGE');
                // Afficher un message à l'utilisateur
                alert('Aucune descente avec des coordonnées valides n\'a été trouvée. Vérifiez les données dans la base.');
            }
            
            if (validArchives.length > 0) {
                console.log('🗺️ Ajout des archives à la carte...');
                addArchivesToMap(validArchives);
            } else {
                console.warn('⚠️ AUCUNE ARCHIVE VALIDE APRÈS FILTRAGE');
            }
            
            // Ajuster la vue de la carte
            if (markers.getLayers().length > 0) {
                console.log('🎯 Ajustement de la vue de la carte...');
                map.fitBounds(markers.getBounds().pad(0.1));
                console.log(`✅ ${markers.getLayers().length} points affichés sur la carte`);
            } else {
                console.warn('⚠️ AUCUN POINT VALIDE À AFFICHER');
                map.setView([-18.766947, 46.869107], 6);
                alert('Aucun point valide à afficher sur la carte. Vérifiez les coordonnées dans la base de données.');
            }
            
        } catch (error) {
            console.error('❌ ERREUR CRITIQUE:', error);
            alert('Une erreur est survenue lors du chargement de la carte: ' + error.message);
        } finally {
            // Cacher le loading
            document.getElementById('loading').style.display = 'none';
            console.log('🏁 Chargement des données terminé');
        }
    }, 500);
});
</script>
</body>
</html>
@endsection