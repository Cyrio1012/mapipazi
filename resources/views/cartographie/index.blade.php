@extends('layouts.app')
@section('title', 'Cartographie des Descentes - Madagascar')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cartographie des Descentes - Madagascar</title>
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
header {
background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
color: white;
padding: 1rem 2rem;
display: flex;
justify-content: space-between;
align-items: center;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
z-index: 1000;
        }
.title-container {
display: flex;
align-items: center;
        }
.title-container i {
font-size: 1.8rem;
margin-right: 1rem;
        }
.title-group h1 {
font-size: 1.5rem;
font-weight: 700;
        }
.title-group p {
font-size: 0.9rem;
opacity: 0.9;
margin-top: 0.2rem;
        }
.action-buttons {
display: flex;
gap: 1rem;
        }
.btn {
padding: 0.6rem 1.2rem;
border-radius: 8px;
font-weight: 600;
cursor: pointer;
transition: all 0.3s ease;
border: none;
display: flex;
align-items: center;
gap: 0.5rem;
        }
.btn-primary {
background-color: white;
color: #2563eb;
        }
.btn-primary:hover {
background-color: #f0f4ff;
transform: translateY(-1px);
        }
.btn-secondary {
background-color: rgba(255, 255, 255, 0.2);
color: white;
        }
.btn-secondary:hover {
background-color: rgba(255, 255, 255, 0.3);
transform: translateY(-1px);
        }
.main-container {
display: flex;
flex: 1;
height: calc(97vh - 90px);

        }
.map-container {
flex: 1;
position: relative;
width: 100%;
        }
#map {
width: 100%;
height: 100%;
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

/* MODAL DÉTAIL DÉPLACÉ VERS LA GAUCHE */
.descente-detail {
    position: absolute;
    top: 1rem;
    left: 1rem;
    width: 400px;
    max-height: calc(100vh - 2rem);
    background-color: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    overflow-y: auto;
    display: none;
}

.descente-detail.active {
    display: block;
}

.detail-header {
display: flex;
justify-content: space-between;
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

/* SUPPRESSION DE LA RECHERCHE PRINCIPALE */
.search-container {
    display: none;
}

.legend-container {
position: absolute;
bottom: 1rem;
right: 1rem;
background-color: white;
border-radius: 8px;
padding: 1rem;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
z-index: 1000;
max-width: 250px;
        }
.legend-title {
font-size: 1rem;
font-weight: 600;
margin-bottom: 0.8rem;
color: #1e40af;
display: flex;
align-items: center;
gap: 0.5rem;
        }
.legend-item {
display: flex;
align-items: center;
gap: 0.8rem;
margin-bottom: 0.8rem;
        }
.legend-color {
width: 20px;
height: 20px;
border-radius: 50%;
flex-shrink: 0;
        }
.legend-label {
font-size: 0.9rem;
color: #4b5563;
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
.descente-marker {
background: rgba(255, 255, 255, 0.95);
border-radius: 50%;
border: 3px solid;
display: flex;
align-items: center;
justify-content: center;
font-weight: bold;
font-size: 12px;
box-shadow: 0 2px 8px rgba(0,0,0,0.3);
transition: all 0.3s ease;
        }
.descente-marker:hover {
transform: scale(1.1);
        }

/* MODAL DE RECHERCHE AMÉLIORÉ */
.search-modal {
    position: absolute;
    top: 4rem;
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
        top: 5rem;
    }
    
    .legend-container {
        max-width: 200px;
    }
    
    .map-type-controls {
        right: 1rem;
        top: 5rem;
    }
}
</style>
</head>
<body style="margin:0 !important;" >


<div style="margin:0 !important;" class="main-container">
<div style="margin:0 !important;"  class="map-container">
<div style="margin:-32px !important;width:2020px;height:97vh"  id="map"></div>

<!-- MODAL DE RECHERCHE AMÉLIORÉ -->
<div class="search-modal" id="search-modal">
    <div class="search-modal-header">
        <h3 class="search-modal-title">
            <i class="fas fa-search-location"></i> Recherche de Coordonnées
        </h3>
        <button class="close-search-modal" id="close-search-modal">&times;</button>
    </div>
    <div class="search-modal-body">
        <!-- Sélecteur de type de coordonnées -->
        <div class="coord-type-selector">
            <button class="coord-type-btn active" data-type="laborde">
                <i class="fas fa-map-marked-alt"></i> Laborde
            </button>
            <button class="coord-type-btn" data-type="latlon">
                <i class="fas fa-globe-americas"></i> Lat/Lon
            </button>
        </div>

        <!-- Champs Laborde (visible par défaut) -->
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

        <!-- Champs Lat/Lon (caché par défaut) -->
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

<!-- Contrôles de type de carte -->
<div class="map-type-controls">
<button class="map-btn active" id="view-oms" title="Vue OMS">
<i class="fas fa-layer-group"></i>
</button>
<button class="map-btn" id="view-satellite" title="Vue Satellite">
<i class="fas fa-satellite"></i>
</button>
<!-- Bouton pour recherche coordonnées -->
<button class="map-btn" id="toggle-search-modal" title="Recherche par Coordonnées">
    <i class="fas fa-crosshairs"></i>
</button>
</div>

<!-- Contrôles de la carte -->
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

<!-- Légende -->
<div class="legend-container">
<h3 class="legend-title"><i class="fas fa-key"></i> Légende</h3>
<div class="legend-item">
<div class="legend-color" style="background-color: #4e73df;"></div>
<span class="legend-label">Descente Planifiée</span>
</div>
<div class="legend-item">
<div class="legend-color" style="background-color: #f6c23e;"></div>
<span class="legend-label">Descente en Cours</span>
</div>
<div class="legend-item">
<div class="legend-color" style="background-color: #1cc88a;"></div>
<span class="legend-label">Descente Terminée</span>
</div>
</div>

<!-- DÉTAILS DÉPLACÉS VERS LA GAUCHE -->
<div class="descente-detail" id="descente-detail">
<div class="detail-header">
<h3 class="detail-title">Détails de la Descente</h3>
<button class="close-detail" id="close-detail">&times;</button>
</div>
<div class="detail-content" id="detail-content">
Sélectionnez une descente pour voir les détails
</div>
</div>

<!-- Loading -->
<div class="loading" id="loading">
<i class="fas fa-spinner fa-spin"></i> Chargement des données...
</div>
</div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.8.0/proj4.js"></script>
<script>
// Données dynamiques depuis le contrôleur
const descentesData = @json($descentes ?? []);
console.log('=== CHARGEMENT DES DONNÉES DESCENTES ===');
console.log('Nombre total de descentes:', descentesData.length);

// Variables globales
let coordMarker = null;
let currentCoordType = 'laborde';

// Initialiser la carte centrée sur Madagascar
const map = L.map('map').setView([-18.766947, 46.869107], 6);

// Définitions des styles de carte
const mapStyles = {
'OMS': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
maxZoom: 19
            }),
'Satellite': L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
attribution: 'Imagery © <a href="https://maps.google.com">Google Maps</a>',
maxZoom: 22
            })
        };

// Style de carte initial (OMS)
mapStyles['OMS'].addTo(map);
let currentMapStyle = 'OMS';

// Groupe pour les marqueurs
const markers = L.markerClusterGroup();
let descentesLayers = {};

// CONFIGURATION PROJ4 - SYSTÈME LABORDE MADAGASCAR (EPSG:8441)
try {
// Définition projection EPSG:8441 (Laborde Madagascar)
proj4.defs(
"EPSG:8441",
"+proj=omerc +lat_0=-18.9 +lonc=46.43722916666667 +alpha=18.9 +k=0.9995 +x_0=400000 +y_0=800000 +ellps=intl +towgs84=-189,-242,-91,0,0,0,0 +units=m +no_defs"
            );
console.log("✅ Projection EPSG:8441 (Laborde Madagascar) configurée avec succès");
        } catch (e) {
console.error("❌ Erreur configuration EPSG:8441:", e);
        }

// FONCTION DE CONVERSION PRÉCISE LABORDE -> WGS84
function labordeToWGS84(x, y) {
if (!x || !y || x == 0 || y == 0 || isNaN(x) || isNaN(y)) {
console.log('Coordonnées Laborde invalides:', x, y);
return null;
            }
try {
// Vérifier que la projection est définie
if (!proj4.defs("EPSG:8441")) {
console.error("Projection EPSG:8441 non définie");
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

// Fonction pour ajouter les descentes à la carte
function addDescentesToMap(descentes) {
// Nettoyer les layers existants
markers.clearLayers();
descentesLayers = {};
let coordsValides = 0;
let interventions = 0;

// Ajouter les descentes
descentes.forEach(descente => {
// Vérification robuste des coordonnées
const x = parseFloat(descente.x_laborde);
const y = parseFloat(descente.y_laborde);
if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
console.log(`❌ Coordonnées invalides pour la descente ${descente.id}:`, x, y);
return;
                }
// Convertir les coordonnées Laborde en WGS84 avec PROJ4
const coords = labordeToWGS84(x, y);
if (!coords) {
console.log(`❌ Conversion échouée pour la descente ${descente.id}`);
return;
                }
coordsValides++;
if (descente.action && descente.action !== '[]' && descente.action !== 'null') interventions++;

const markerColor = getDescenteColor(descente);

// Créer un marqueur personnalisé
const marker = L.marker(coords, {
icon: L.divIcon({
html: `<div class="descente-marker" style="border-color: ${markerColor}; color: ${markerColor}; width: 35px; height: 35px; background-color: ${markerColor}20;">
                    <i class="fas fa-map-marker-alt" style="color: ${markerColor}; font-size: 14px;"></i>
                </div>`,
className: 'descente-marker-container',
iconSize: [35, 35]
                    })
                });

// Popup d'information
const popupContent = `
                    <div style="font-family: 'Inter', sans-serif; max-width: 350px;">
                        <h3 style="color: ${markerColor}; margin-bottom: 0.5rem; border-bottom: 2px solid ${markerColor}; padding-bottom: 0.5rem;">
${descente.ref_om ? 'OM: ' + descente.ref_om : 'Descente #' + descente.id}
                        </h3>
                        <div style="font-size: 0.9rem; color: #666;">
                            <p><strong>Date:</strong> ${descente.date || 'Non spécifié'}</p>
                            <p><strong>Heure:</strong> ${descente.heure || 'Non spécifié'}</p>
${descente.ref_pv ? `<p><strong>Réf. PV:</strong> ${descente.ref_pv}</p>` : ''}
${descente.num_pv ? `<p><strong>Num. PV:</strong> ${descente.num_pv}</p>` : ''}
                            <p><strong>Adresse:</strong> ${descente.adresse || 'Non spécifié'}</p>
                            <p><strong>Commune:</strong> ${descente.comm || 'Non spécifié'}</p>
                            <p><strong>Coordonnées WGS84:</strong><br>Lat: ${coords[0].toFixed(6)}<br>Lon: ${coords[1].toFixed(6)}</p>
                            <p><strong>Coordonnées Laborde:</strong><br>X: ${x}<br>Y: ${y}</p>
                            <p><em><small>Conversion: EPSG:8441 → WGS84</small></em></p>
                        </div>
                        <button style="width: 100%; padding: 0.5rem; background-color: ${markerColor}; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem;" onclick="showDetail('${descente.id}')">
                            Voir Détails Complets
                        </button>
                    </div>
                `;
marker.bindPopup(popupContent);

// Stocker la référence
descentesLayers[descente.id] = marker;
markers.addLayer(marker);
            });

// Ajouter le groupe de marqueurs à la carte
map.addLayer(markers);

// Ajuster la vue si des marqueurs sont présents
if (coordsValides > 0) {
const group = new L.featureGroup(Object.values(descentesLayers));
map.fitBounds(group.getBounds().pad(0.1));
console.log(`✅ ${coordsValides} marqueurs affichés sur la carte avec conversion PROJ4`);
            } else {
console.warn('⚠️ Aucun marqueur valide à afficher');
// Recentrer sur Madagascar
map.setView([-18.766947, 46.869107], 6);
            }
        }

// Fonction pour afficher les détails complets
function showDetail(descenteId) {
const descente = descentesData.find(d => d.id == descenteId);
if (!descente) return;

const markerColor = getDescenteColor(descente);
const x = parseFloat(descente.x_laborde);
const y = parseFloat(descente.y_laborde);
const coords = labordeToWGS84(x, y);

const detailContent = `
                <div class="detail-section">
                    <h4 style="color: ${markerColor};">Informations Générales</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Date</span>
                            <span class="detail-value">${descente.date || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Heure</span>
                            <span class="detail-value">${descente.heure || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Réf. OM</span>
                            <span class="detail-value">${descente.ref_om || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Réf. PV</span>
                            <span class="detail-value">${descente.ref_pv || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Réf. Rapport</span>
                            <span class="detail-value">${descente.ref_rapport || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Numéro PV</span>
                            <span class="detail-value">${descente.num_pv || 'Non spécifié'}</span>
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h4 style="color: ${markerColor};">Équipe et Actions</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Équipe</span>
                            <span class="detail-value">${formatArrayField(descente.equipe)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Action</span>
                            <span class="detail-value">${formatArrayField(descente.action)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Constat</span>
                            <span class="detail-value">${formatArrayField(descente.constat)}</span>
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h4 style="color: ${markerColor};">Personnes et Localisation</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Personnes verbalisées</span>
                            <span class="detail-value">${descente.pers_verb || '0'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Quantité personnes</span>
                            <span class="detail-value">${descente.qte_pers || '0'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Adresse</span>
                            <span class="detail-value">${descente.adresse || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact</span>
                            <span class="detail-value">${descente.contact || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">District</span>
                            <span class="detail-value">${descente.dist || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Commune</span>
                            <span class="detail-value">${descente.comm || 'Non spécifié'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fokontany</span>
                            <span class="detail-value">${descente.fkt || 'Non spécifié'}</span>
                        </div>
                    </div>
                </div>
                <div class="detail-section">
                    <h4 style="color: ${markerColor};">Coordonnées</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">X Laborde</span>
                            <span class="detail-value">${descente.x_laborde}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Y Laborde</span>
                            <span class="detail-value">${descente.y_laborde}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Latitude WGS84</span>
                            <span class="detail-value">${coords ? coords[0].toFixed(6) : 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Longitude WGS84</span>
                            <span class="detail-value">${coords ? coords[1].toFixed(6) : 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Système</span>
                            <span class="detail-value">EPSG:8441 → WGS84 (PROJ4)</span>
                        </div>
                    </div>
                </div>
            `;
document.getElementById('detail-content').innerHTML = detailContent;
document.getElementById('descente-detail').classList.add('active');
        }

// Fonction pour changer le style de carte
function changeMapStyle(style) {
mapStyles[currentMapStyle].remove();
mapStyles[style].addTo(map);
currentMapStyle = style;
document.getElementById('view-oms').classList.toggle('active', style === 'OMS');
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

        // Convertir les coordonnées Laborde en WGS84
        coords = labordeToWGS84(parseFloat(x), parseFloat(y));
        
        if (!coords) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Conversion des coordonnées Laborde échouée';
            return;
        }

        lat = coords[0];
        lon = coords[1];

    } else {
        // Recherche par Lat/Lon
        lat = parseFloat(document.getElementById('coord-lat').value);
        lon = parseFloat(document.getElementById('coord-lon').value);
        
        if (!lat || !lon || isNaN(lat) || isNaN(lon)) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Veuillez entrer des coordonnées WGS84 valides';
            return;
        }

        // Validation des limites Madagascar
        if (lat < -25.6 || lat > -12.0 || lon < 43.0 || lon > 50.5) {
            resultDiv.className = 'coord-result error';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Coordonnées hors des limites de Madagascar';
            return;
        }

        coords = [lat, lon];
        
        // Convertir WGS84 vers Laborde
        const labordeCoords = wgs84ToLaborde(lat, lon);
        if (labordeCoords) {
            x = labordeCoords.x;
            y = labordeCoords.y;
        }
    }

    // Supprimer le marqueur précédent s'il existe
    if (coordMarker) {
        map.removeLayer(coordMarker);
    }

    // Créer un marqueur spécial pour la recherche
    coordMarker = L.marker(coords, {
        icon: L.divIcon({
            html: `<div class="descente-marker" style="border-color: #dc2626; color: #dc2626; width: 40px; height: 40px; background-color: rgba(255,255,255,0.9);">
                    <i class="fas fa-crosshairs"></i>
                   </div>`,
            className: 'coord-marker-container',
            iconSize: [40, 40]
        })
    }).addTo(map);

    // Popup d'information
    let popupContent = `
        <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
            <h3 style="color: #dc2626; margin-bottom: 0.5rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">
                <i class="fas fa-crosshairs"></i> Point Recherché
            </h3>
            <div style="font-size: 0.9rem; color: #666;">
    `;

    if (currentCoordType === 'laborde') {
        popupContent += `
                <p><strong>Coordonnées Laborde:</strong><br>X: ${x}<br>Y: ${y}</p>
                <p><strong>Coordonnées WGS84:</strong><br>Lat: ${lat.toFixed(6)}<br>Lon: ${lon.toFixed(6)}</p>
        `;
    } else {
        popupContent += `
                <p><strong>Coordonnées WGS84:</strong><br>Lat: ${lat.toFixed(6)}<br>Lon: ${lon.toFixed(6)}</p>
                ${x && y ? `<p><strong>Coordonnées Laborde:</strong><br>X: ${x}<br>Y: ${y}</p>` : ''}
        `;
    }

    popupContent += `
                <p><em><small>Recherche manuelle par coordonnées</small></em></p>
            </div>
        </div>
    `;
    
    coordMarker.bindPopup(popupContent).openPopup();

    // Centrer la carte sur le point
    map.setView(coords, 15);

    // Afficher le résultat
    resultDiv.className = 'coord-result success';
    let resultHTML = `<i class="fas fa-check-circle"></i> Point trouvé et affiché sur la carte<br>`;
    
    if (currentCoordType === 'laborde') {
        resultHTML += `<small>WGS84: ${lat.toFixed(6)}, ${lon.toFixed(6)}</small>`;
    } else {
        resultHTML += `<small>WGS84: ${lat.toFixed(6)}, ${lon.toFixed(6)}</small>`;
        if (x && y) {
            resultHTML += `<br><small>Laborde: X=${x}, Y=${y}</small>`;
        }
    }

    resultDiv.innerHTML = resultHTML;

    // Rechercher les descentes proches de ce point
    findNearbyDescentes(coords, x, y);
}

// FONCTION POUR TROUVER LES DESCENTES PROCHEs
function findNearbyDescentes(coordsWGS84, xLaborde, yLaborde) {
    const tolerance = 100; // Tolérance en mètres (Laborde)
    let nearbyDescentes = [];

    descentesData.forEach(descente => {
        const descX = parseFloat(descente.x_laborde);
        const descY = parseFloat(descente.y_laborde);
        
        if (!isNaN(descX) && !isNaN(descY)) {
            // Calcul de la distance euclidienne simple (approximative)
            const distance = Math.sqrt(Math.pow(descX - xLaborde, 2) + Math.pow(descY - yLaborde, 2));
            
            if (distance <= tolerance) {
                nearbyDescentes.push({
                    descente: descente,
                    distance: distance
                });
            }
        }
    });

    // Trier par distance
    nearbyDescentes.sort((a, b) => a.distance - b.distance);

    // Afficher les résultats
    const resultDiv = document.getElementById('coord-result');
    if (nearbyDescentes.length > 0) {
        resultDiv.innerHTML += `<br><strong>Descentes proches (${nearbyDescentes.length}):</strong><br>`;
        nearbyDescentes.slice(0, 3).forEach(item => {
            resultDiv.innerHTML += `• ${item.descente.ref_om || 'Sans réf.'} (${Math.round(item.distance)}m)<br>`;
        });
        if (nearbyDescentes.length > 3) {
            resultDiv.innerHTML += `<small>... et ${nearbyDescentes.length - 3} autres</small>`;
        }
    } else {
        resultDiv.innerHTML += `<br><small>Aucune descente trouvée à proximité</small>`;
    }
}

// FONCTION POUR CHANGER LE TYPE DE COORDONNÉES
function changeCoordType(type) {
    currentCoordType = type;
    
    // Mettre à jour les boutons
    document.querySelectorAll('.coord-type-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.type === type);
    });
    
    // Afficher/masquer les champs appropriés
    document.getElementById('laborde-fields').style.display = type === 'laborde' ? 'block' : 'none';
    document.getElementById('latlon-fields').style.display = type === 'latlon' ? 'block' : 'none';
    
    // Effacer les résultats précédents
    document.getElementById('coord-result').className = 'coord-result';
    document.getElementById('coord-result').innerHTML = '';
}

// ÉCOUTEURS D'ÉVÉNEMENTS

// Événements existants
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
document.getElementById('view-oms').addEventListener('click', () => changeMapStyle('OMS'));
document.getElementById('view-satellite').addEventListener('click', () => changeMapStyle('Satellite'));

// NOUVEAUX ÉVÉNEMENTS POUR LE MODAL DE RECHERCHE
document.getElementById('toggle-search-modal').addEventListener('click', function() {
    const modal = document.getElementById('search-modal');
    modal.classList.toggle('active');
});

document.getElementById('close-search-modal').addEventListener('click', function() {
    document.getElementById('search-modal').classList.remove('active');
});

// Sélecteur de type de coordonnées
document.querySelectorAll('.coord-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        changeCoordType(this.dataset.type);
    });
});

document.getElementById('clear-coord-search').addEventListener('click', function() {
    // Effacer tous les champs
    document.getElementById('coord-x').value = '';
    document.getElementById('coord-y').value = '';
    document.getElementById('coord-lat').value = '';
    document.getElementById('coord-lon').value = '';
    document.getElementById('coord-result').className = 'coord-result';
    document.getElementById('coord-result').innerHTML = '';
    
    // Supprimer le marqueur de recherche
    if (coordMarker) {
        map.removeLayer(coordMarker);
        coordMarker = null;
    }
});

document.getElementById('search-by-coord').addEventListener('click', function() {
    searchByCoordinates();
});

// Recherche par Entrée
document.getElementById('coord-x').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('search-by-coord').click();
    }
});

document.getElementById('coord-y').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('search-by-coord').click();
    }
});

document.getElementById('coord-lat').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('search-by-coord').click();
    }
});

document.getElementById('coord-lon').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('search-by-coord').click();
    }
});

// Fermer le modal en cliquant à l'extérieur
document.addEventListener('click', function(e) {
    const modal = document.getElementById('search-modal');
    const toggleBtn = document.getElementById('toggle-search-modal');
    
    if (modal.classList.contains('active') && 
        !modal.contains(e.target) && 
        !toggleBtn.contains(e.target)) {
        modal.classList.remove('active');
    }
});

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
document.getElementById('loading').style.display = 'block';
setTimeout(() => {
if (descentesData && descentesData.length > 0) {
// Tester la conversion d'abord
testConversion();
// Puis afficher les descentes
addDescentesToMap(descentesData);
                } else {
console.error('Aucune donnée de descente disponible');
alert('Aucune donnée de descente à afficher');
                }
document.getElementById('loading').style.display = 'none';
            }, 500);
        });
</script>
</body>
</html>
@endsection