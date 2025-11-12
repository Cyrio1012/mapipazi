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
    height: calc(100vh - var(--topbar-height));detail-section /* Utilise la variable CSS du layout */
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
top: 1rem;
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

/* LÉGENDE */
.legend-container {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background-color: white;
    border-radius: 8px;
    padding: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-width: 250px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.legend-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e5e7eb;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.legend-header:hover {
    background-color: #e9ecef;
}

.legend-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-toggle {
    background: none;
    border: none;
    font-size: 1rem;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.legend-toggle:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: #374151;
}

.legend-content {
    padding: 1rem;
    transition: all 0.3s ease;
    max-height: 300px;
    overflow: hidden;
}

.legend-container.collapsed .legend-content {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.legend-container.collapsed .legend-toggle i {
    transform: rotate(180deg);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 0.8rem;
    transition: opacity 0.3s ease;
}

.legend-container.collapsed .legend-item {
    opacity: 0;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.legend-label {
    font-size: 0.9rem;
    color: #4b5563;
    font-weight: 500;
}

.map-type-controls {
position: absolute;
top: 1rem;
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

/* POINTS SIMPLES - TAILLE NORMALE */
.simple-point {
    border-radius: 50%;
    width: 12px;
    height: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}
.simple-point:hover {
    transform: scale(1.5);
}

/* MODAL DE RECHERCHE */
.search-modal {
    position: absolute;
    top: 1rem;
    left: 1rem;
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
    
    .map-type-controls {
        right: 1rem;
    }
}
</style>
</head>
<body style="margin:0 !important;">

<div class="main-container">
    <div class="map-container">
        <div style="width:2020px;" id="map"></div>
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

<!-- LÉGENDE -->
<div class="legend-container" id="legend-container">
    <div class="legend-header" id="legend-toggle">
        <h3 class="legend-title">
            <i class="fas fa-key"></i> Légende
        </h3>
        <button class="legend-toggle" id="legend-arrow">
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>
    <div class="legend-content" id="legend-content">
        <div class="legend-item">
            <div class="legend-color" style="background-color: #f6c23e;"></div>
            <span class="legend-label">Descentes</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background-color: #3b82f6;"></div>
            <span class="legend-label">Archives</span>
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

// Variables globales
let coordMarker = null;
let currentCoordType = 'laborde';

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

// Groupe pour les marqueurs
const markers = L.featureGroup();
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

// Fonctions utilitaires
function validateLabordeCoordinates(x, y) {
    const MIN_X = 400000, MAX_X = 600000;
    const MIN_Y = 800000, MAX_Y = 1000000;
    
    if (x < MIN_X || x > MAX_X || y < MIN_Y || y > MAX_Y) {
        return false;
    }
    return true;
}

function filterInvalidCoordinates(data, type = 'descente') {
    return data.filter(item => {
        let x, y;
        
        if (type === 'descente') {
            x = parseFloat(item.x_laborde);
            y = parseFloat(item.y_laborde);
        } else {
            x = parseFloat(item.xv);
            y = parseFloat(item.yv);
        }
        
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
            return false;
        }
        
        return validateLabordeCoordinates(x, y);
    });
}

// FONCTION DE CONVERSION PRÉCISE LABORDE -> WGS84
function labordeToWGS84(x, y) {
    if (!x || !y || x == 0 || y == 0 || isNaN(x) || isNaN(y)) {
        return null;
    }
    
    if (!validateLabordeCoordinates(x, y)) {
        console.log('Coordonnées hors des plages valides pour Madagascar');
        return null;
    }
    
    try {
        if (!proj4.defs("EPSG:8441")) {
            return null;
        }
        
        // Conversion précise avec proj4
        const fromProj = "EPSG:8441";
        const toProj = "EPSG:4326"; // WGS84
        const result = proj4(fromProj, toProj, [x, y]);
        const lon = result[0];
        const lat = result[1];
        
        console.log(`📍 Conversion PROJ4: Laborde(${x}, ${y}) -> WGS84(${lat.toFixed(6)}, ${lon.toFixed(6)})`);
        
        // Validation des coordonnées résultantes (limites de Madagascar)
        if (lat < -25.6 || lat > -12.0 || lon < 43.0 || lon > 50.5) {
            console.warn('Coordonnées hors des limites de Madagascar:', lat, lon);
            return null;
        }
        
        return [lat, lon];
    } catch (error) {
        console.error('❌ Erreur de conversion Laborde->WGS84:', error);
        return null;
    }
}

// FONCTION POUR RÉDUIRE/DÉVELOPPER LA LÉGENDE
function toggleLegend() {
    const legendContainer = document.getElementById('legend-container');
    const legendContent = document.getElementById('legend-content');
    const legendArrow = document.getElementById('legend-arrow');
    
    legendContainer.classList.toggle('collapsed');
    
    // Sauvegarder l'état dans le localStorage
    const isCollapsed = legendContainer.classList.contains('collapsed');
    localStorage.setItem('legendCollapsed', isCollapsed);
}

// RESTAURER L'ÉTAT DE LA LÉGENDE
function restoreLegendState() {
    const legendContainer = document.getElementById('legend-container');
    const isCollapsed = localStorage.getItem('legendCollapsed') === 'true';
    
    if (isCollapsed) {
        legendContainer.classList.add('collapsed');
    }
}

// ÉVÉNEMENTS POUR LA LÉGENDE
document.addEventListener('DOMContentLoaded', function() {
    const legendToggle = document.getElementById('legend-toggle');
    const legendArrow = document.getElementById('legend-arrow');
    
    if (legendToggle) {
        legendToggle.addEventListener('click', toggleLegend);
    }
    
    if (legendArrow) {
        legendArrow.addEventListener('click', function(e) {
            e.stopPropagation(); // Empêche le déclenchement double
            toggleLegend();
        });
    }
    
    // Restaurer l'état au chargement
    restoreLegendState();
});

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

// Fonction pour tester la conversion avec vos points connus
function testConversion() {
console.log('🧪 TEST DE CONVERSION AVEC PROJ4');
// Vos deux points connus
const pointsTest = [
                {
laborde: { x: 516531, y: 802042 },
wgs84: { lat: -18.879439, lon: 47.543402 },
description: "Terrain 1 - Référence"
                },
                {
laborde: { x: 517767, y: 801659 },
wgs84: { lat: -18.882273, lon: 47.545627 },
description: "Terrain 2 - À vérifier"
                }
            ];
pointsTest.forEach((point, index) => {
console.log(`\n--- ${point.description} ---`);
console.log('📌 Coordonnées Laborde:', point.laborde.x, point.laborde.y);
console.log('🎯 Position attendue WGS84:', point.wgs84.lat, point.wgs84.lon);
const result = labordeToWGS84(point.laborde.x, point.laborde.y);
console.log('🔄 Position calculée WGS84:', result);
if (result) {
const ecartLat = Math.abs(result[0] - point.wgs84.lat);
const ecartLon = Math.abs(result[1] - point.wgs84.lon);
console.log(`📏 Écart: Lat=${ecartLat.toFixed(6)}°, Lon=${ecartLon.toFixed(6)}°`);
// Conversion en mètres (approximative)
const ecartMetresLat = ecartLat * 111320; // 1° latitude ≈ 111.32 km
const ecartMetresLon = ecartLon * 111320 * Math.cos(point.wgs84.lat * Math.PI / 180);
const distanceMetres = Math.sqrt(ecartMetresLat*ecartMetresLat + ecartMetresLon*ecartMetresLon);
console.log(`📐 Distance approximative: ${distanceMetres.toFixed(0)} mètres`);
if (distanceMetres < 50) {
console.log('✅ PRÉCISION EXCELLENTE');
                    } else if (distanceMetres < 200) {
console.log('⚠️ Précision acceptable');
                    } else {
console.log('❌ Précision insuffisante');
                    }
                }
            });
        }

// Fonction pour déterminer la couleur selon le statut - TOUTES LES DESCENTES EN JAUNE
function getDescenteColor(descente) {
    // Retourne toujours la couleur jaune pour toutes les descentes
    return '#f6c23e'; // Jaune pour toutes les descentes
}

// Fonction pour formater les tableaux JSON
function formatArrayField(field) {
if (!field) return 'Non spécifié';
if (Array.isArray(field)) {
return field.join(', ');
            }
if (typeof field === 'string') {
try {
const parsed = JSON.parse(field);
return Array.isArray(parsed) ? parsed.join(', ') : field;
                } catch {
return field;
                }
            }
return field;
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

function getValueOrNotSpecified(value) {
    return value && value !== 'null' && value !== '' && value !== 'N/A' ? value : 'Non spécifié';
}

// Fonctions pour ajouter les points à la carte
function addDescentesToMap(descentes) {
    let coordsValides = 0;

    descentes.forEach(descente => {
        const x = parseFloat(descente.x_laborde);
        const y = parseFloat(descente.y_laborde);
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
            return;
        }

        const coords = labordeToWGS84(x, y);
        if (!coords) {
            return;
        }

        coordsValides++;

        // Créer un point simple jaune pour les descentes
        const marker = L.marker(coords, {
            icon: L.divIcon({
                html: `<div class="simple-point" style="background-color: #f6c23e; border: 2px solid #d4a417;"></div>`,
                className: 'simple-point-container',
                iconSize: [12, 12],
                iconAnchor: [6, 6]
            })
        });

        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: #f6c23e; margin-bottom: 0.5rem; border-bottom: 2px solid #f6c23e; padding-bottom: 0.5rem;">
                    Descente #${descente.id}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. OM:</strong> ${getValueOrNotSpecified(descente.ref_om)}</p>
                    <p><strong>Date:</strong> ${formatDate(descente.date)}</p>
                    <p><strong>Adresse:</strong> ${getValueOrNotSpecified(descente.adresse)}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(descente.comm)}</p>
                    <p><strong>Constat:</strong> ${getValueOrNotSpecified(descente.constat)}</p>
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: #f6c23e; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showDescenteDetail('${descente.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        marker.bindPopup(popupContent);

        descentesLayers[`descente_${descente.id}`] = marker;
        markers.addLayer(marker);
    });

    console.log(`✅ ${coordsValides} descentes affichées`);
}

function addArchivesToMap(archives) {
    let archivesValides = 0;
    
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
        
        // Créer un point simple bleu pour les archives
        const marker = L.marker(coords, {
            icon: L.divIcon({
                html: `<div class="simple-point" style="background-color: #3b82f6; border: 2px solid #1d4ed8;"></div>`,
                className: 'simple-point-container',
                iconSize: [12, 12],
                iconAnchor: [6, 6]
            })
        });

        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: #3b82f6; margin-bottom: 0.5rem; border-bottom: 2px solid #3b82f6; padding-bottom: 0.5rem;">
                    Archive #${archive.id}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. Arrivée:</strong> ${getValueOrNotSpecified(archive.arrivalid)}</p>
                    <p><strong>Date Arrivée:</strong> ${formatDate(archive.arrivaldate)}</p>
                    <p><strong>Service:</strong> ${getValueOrNotSpecified(archive.sendersce)}</p>
                    <p><strong>Demandeur:</strong> ${getValueOrNotSpecified(archive.applicantname)}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(archive.municipality)}</p>
                    <p><strong>Propriétaire:</strong> ${getValueOrNotSpecified(archive.property0wner)}</p>
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showArchiveDetail('${archive.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        marker.bindPopup(popupContent);

        descentesLayers[`archive_${archive.id}`] = marker;
        markers.addLayer(marker);
    });

    console.log(`✅ ${archivesValides} archives affichées`);
}

// Fonctions pour afficher les détails
function showDescenteDetail(descenteId) {
    const descente = descentesData.find(d => d.id == descenteId);
    if (!descente) return;

    const detailContent = `
        <div class="detail-section">
            <h4 style="color: #f6c23e;">Informations Générales</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Réf. OM</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.ref_om)}</span>
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
            <h4 style="color: #f6c23e;">Localisation</h4>
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
            <h4 style="color: #f6c23e;">Actions</h4>
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
            <h4 style="color: #3b82f6;">Informations techniques</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Surface (m²)</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.surfacearea)}</span>
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

// Gestion de la légende
function toggleLegend() {
    const legendContainer = document.getElementById('legend-container');
    legendContainer.classList.toggle('collapsed');
    localStorage.setItem('legendCollapsed', legendContainer.classList.contains('collapsed'));
}

function restoreLegendState() {
    const legendContainer = document.getElementById('legend-container');
    const isCollapsed = localStorage.getItem('legendCollapsed') === 'true';
    if (isCollapsed) {
        legendContainer.classList.add('collapsed');
    }
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
            iconSize: [16, 16],
            iconAnchor: [8, 8]
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

// Événements
document.addEventListener('DOMContentLoaded', function() {
    // Légende
    const legendToggle = document.getElementById('legend-toggle');
    const legendArrow = document.getElementById('legend-arrow');
    
    if (legendToggle) legendToggle.addEventListener('click', toggleLegend);
    if (legendArrow) legendArrow.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleLegend();
    });
    
    restoreLegendState();

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

    // Chargement des données
    document.getElementById('loading').style.display = 'block';
    
    setTimeout(() => {
        map.addLayer(markers);
        
        const validDescentes = filterInvalidCoordinates(descentesData, 'descente');
        const validArchives = filterInvalidCoordinates(archivesData, 'archive');
        
        console.log(`📊 Données après filtrage: ${validDescentes.length} descentes, ${validArchives.length} archives`);
        
        if (validDescentes.length > 0) {
            addDescentesToMap(validDescentes);
        }
        
        if (validArchives.length > 0) {
            addArchivesToMap(validArchives);
        }
        
        if (markers.getLayers().length > 0) {
            map.fitBounds(markers.getBounds().pad(0.1));
            console.log(`✅ ${markers.getLayers().length} points affichés`);
        } else {
            map.setView([-18.766947, 46.869107], 6);
            console.warn('⚠️ Aucun point valide à afficher');
        }
        
        document.getElementById('loading').style.display = 'none';
    }, 500);
});
</script>
</body>
</html>
@endsection