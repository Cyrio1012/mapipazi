@extends('layouts.app')
@section('title', 'Cartographie')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
/* NOUVEAU STYLE POUR LES CONTRÔLES DE FILTRE PAR COMMUNE/DISTRICT */
.location-filter-controls {
    position: absolute;
    top: 4rem;
    left: 16rem;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 250px;
}
.location-filter-title {
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
.location-filter-type {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.8rem;
    background: #f8f9fa;
    padding: 0.5rem;
    border-radius: 6px;
}
.location-filter-btn {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    background: transparent;
    color: #6b7280;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.8rem;
}
.location-filter-btn.active {
    background: white;
    color: #2563eb;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.location-search-container {
    margin-bottom: 0.8rem;
}
.location-search-input {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.8rem;
    transition: all 0.2s;
}
.location-search-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
.location-results {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: white;
    display: none;
}
.location-result-item {
    padding: 0.6rem;
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.8rem;
    transition: all 0.2s;
}
.location-result-item:hover {
    background-color: #f8fafc;
}
.location-result-item:last-child {
    border-bottom: none;
}
.location-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}
.location-action-btn {
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
.location-action-btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
}
.location-action-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
}
.location-action-btn-secondary {
    background-color: #6b7280;
    color: white;
}
.location-action-btn-secondary:hover {
    background-color: #4b5563;
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

/* CORRECTION DES STYLES POUR LES POINTS ET BADGES */
.custom-marker-icon {
    background: transparent !important;
    border: none !important;
}

.simple-point-container {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 30px;
}

.simple-point {
    border-radius: 50%;
    width: 14px;
    height: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
    position: absolute;
    top: 8px;
    left: 8px;
    z-index: 1;
}

.simple-point:hover {
    transform: scale(1.5);
    z-index: 1000;
}

.constat-badge {
    position: absolute;
    top: -5px;
    right: -8px;
    background: white;
    border-radius: 8px;
    padding: 2px 6px;
    font-size: 9px;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    white-space: nowrap;
    z-index: 2;
    border: 1px solid;
    max-width: 70px;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

/* BADGE INDICATEUR DE CONSTAT - CORRIGÉ */
.constat-badge-container {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 30px;
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
   
    .location-filter-controls {
        min-width: 200px;
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
<!-- NOUVEAU CONTRÔLE DE FILTRE PAR COMMUNE/DISTRICT -->
<div class="location-filter-controls" id="location-filter-controls">
    <h3 class="location-filter-title">
        <i class="fas fa-map-marker-alt"></i> Filtre par Localisation
    </h3>
   
    <div class="location-filter-type">
        <button class="location-filter-btn active" data-type="commune">
            <i class="fas fa-city"></i> Commune
        </button>
        <button class="location-filter-btn" data-type="district">
            <i class="fas fa-map"></i> District
        </button>
    </div>
   
    <div class="location-search-container">
        <input type="text" id="location-search-input" class="location-search-input" placeholder="Rechercher une commune...">
        <div class="location-results" id="location-results"></div>
    </div>
   
    <div class="location-actions">
        <button class="location-action-btn location-action-btn-secondary" id="clear-location-filter">
            <i class="fas fa-eraser"></i> Effacer
        </button>
        <button class="location-action-btn location-action-btn-primary" id="export-pdf">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </button>
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
                    Constructions sur zone de protection
                </span>
            </label>
        </div>
       
        <div class="filter-actions">
            <button class="filter-btn filter-btn-secondary" id="reset-filters">
                <i class="fas fa-undo"></i> Réinitialiser
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
let currentLocationFilter = null;
let currentLocationType = 'commune';
let allMarkers = L.featureGroup();
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

// FONCTION POUR OBTENIR UN TEXTE DE CONSTAT COURT - CORRIGÉE
function getShortConstat(descente) {
    const constat = descente.constat || '';
    if (!constat || constat === 'Non spécifié' || constat === 'null' || typeof constat !== 'string') {
        return 'NC';
    }
    
    // Extraire les premiers mots (maximum 2-3 mots)
    const words = constat.split(' ').slice(0, 3);
    let shortText = words.join(' ');
    
    // Si le texte est trop long, le tronquer
    if (shortText.length > 12) {
        shortText = shortText.substring(0, 10) + '...';
    }
    
    return shortText;
}

// FONCTION POUR OBTENIR UN TEXTE DE CONSTAT COURT POUR LES ARCHIVES - CORRIGÉE
function getShortArchiveConstat(archive) {
    const constat = archive.findingof || '';
    if (!constat || constat === 'Non spécifié' || constat === 'null' || typeof constat !== 'string') {
        return 'NC';
    }
    
    // Extraire les premiers mots (maximum 2-3 mots)
    const words = constat.split(' ').slice(0, 3);
    let shortText = words.join(' ');
    
    // Si le texte est trop long, le tronquer
    if (shortText.length > 12) {
        shortText = shortText.substring(0, 10) + '...';
    }
    
    return shortText;
}

// FONCTIONS POUR LE FILTRAGE COMBINÉ LOCALISATION + TYPE

// FONCTION POUR VÉRIFIER SI UN TYPE DE MARQUEUR EST VISIBLE
function isMarkerTypeVisible(markerType) {
    switch(markerType) {
        case 'descente':
            return activeLayers.descentes;
        case 'ft':
            return activeLayers.ft;
        case 'ap':
            return activeLayers.ap;
        case 'archive':
            return activeLayers.archives;
        case 'special':
            return activeLayers.special;
        default:
            return true;
    }
}

// FONCTION POUR DÉTERMINER LE TYPE DE MARQUEUR D'UNE DESCENTE
function getMarkerType(descente) {
    if (descente.ap) {
        return 'ap';
    } else if (descente.ft_id && descente.ft_id !== 'null' && descente.ft_id !== '' && descente.ft_id !== 'Non spécifié') {
        return 'ft';
    } else {
        return 'descente';
    }
}

// FONCTION AMÉLIORÉE POUR CRÉER LES MARQUEURS AVEC BADGES
function createMarkerWithBadge(coords, pointColor, borderColor, shortConstat, popupContent, customData, markerType) {
    const icon = L.divIcon({
        html: `
            <div class="simple-point-container">
                <div class="simple-point" style="background-color: ${pointColor}; border: 2px solid ${borderColor};"></div>
                <div class="constat-badge" style="background-color: ${pointColor}; color: white; border-color: ${borderColor};">
                    ${shortConstat}
                </div>
            </div>
        `,
        className: 'custom-marker-icon',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    const marker = L.marker(coords, { icon: icon });
    
    // Stocker les données pour le filtrage
    marker.options.customData = customData;
    marker.options.markerType = markerType;
    
    // Ajouter le popup
    if (popupContent) {
        marker.bindPopup(popupContent);
    }
    
    return marker;
}

// FONCTION POUR APPLIQUER SEULEMENT LES FILTRES DE TYPE
function applyTypeFiltersOnly() {
    console.log('🎯 Application des filtres de type seulement');
    
    // Masquer tous les marqueurs d'abord
    allMarkers.eachLayer(layer => {
        map.removeLayer(layer);
    });
    
    // Afficher les marqueurs selon les filtres de type
    allMarkers.eachLayer(layer => {
        const markerType = layer.options.markerType;
        if (markerType && isMarkerTypeVisible(markerType)) {
            map.addLayer(layer);
        }
    });
    
    console.log('✅ Filtres de type appliqués');
}

// FONCTION AMÉLIORÉE POUR FILTRER PAR LOCALISATION AVEC LES FILTRES D'AFFICHAGE
function filterByLocation(location, type) {
    currentLocationFilter = { location, type };
    
    // Masquer tous les marqueurs d'abord
    allMarkers.eachLayer(layer => {
        map.removeLayer(layer);
    });
    
    // Afficher seulement les marqueurs correspondants aux deux critères
    allMarkers.eachLayer(layer => {
        const markerData = layer.options.customData;
        if (markerData) {
            let shouldShow = false;
            
            // Vérifier le filtre de localisation
            if (type === 'commune') {
                if (markerData.commune && markerData.commune.toLowerCase() === location.toLowerCase()) {
                    shouldShow = true;
                }
            } else if (type === 'district') {
                if (markerData.district && markerData.district.toLowerCase() === location.toLowerCase()) {
                    shouldShow = true;
                }
            }
            
            // Vérifier également les filtres d'affichage
            if (shouldShow) {
                const markerType = layer.options.markerType;
                shouldShow = isMarkerTypeVisible(markerType);
            }
            
            if (shouldShow) {
                map.addLayer(layer);
            }
        }
    });
    
    // Ajuster la vue pour montrer les marqueurs filtrés
    const visibleLayers = L.featureGroup();
    allMarkers.eachLayer(layer => {
        if (map.hasLayer(layer)) {
            visibleLayers.addLayer(layer);
        }
    });
    
    if (visibleLayers.getLayers().length > 0) {
        map.fitBounds(visibleLayers.getBounds().pad(0.1));
    }
    
    console.log(`📍 Filtrage par ${type}: ${location} avec filtres d'affichage`);
}

// FONCTION POUR APPLIQUER LES FILTRES AUTOMATIQUEMENT
function applyFilters() {
    // Mettre à jour l'état des filtres
    activeLayers = {
        'descentes': document.getElementById('filter-descentes').checked,
        'ft': document.getElementById('filter-ft').checked,
        'ap': document.getElementById('filter-ap').checked,
        'archives': document.getElementById('filter-archives').checked,
        'special': document.getElementById('filter-special').checked
    };
    
    console.log('🔧 Application des filtres:', activeLayers);
    
    // Si un filtre de localisation est actif
    if (currentLocationFilter) {
        filterByLocation(currentLocationFilter.location, currentLocationFilter.type);
    } else {
        // Appliquer seulement les filtres de type
        applyTypeFiltersOnly();
    }
}

// Effacer le filtre de localisation
function clearLocationFilter() {
    currentLocationFilter = null;
    document.getElementById('location-search-input').value = '';
    document.getElementById('location-results').style.display = 'none';
    
    // Réafficher tous les marqueurs selon les filtres de type actuels
    applyTypeFiltersOnly();
    
    // Recentrer sur Madagascar si aucun marqueur visible
    if (!hasVisibleMarkers()) {
        map.setView([-18.766947, 46.869107], 6);
    }
}

// FONCTION POUR VÉRIFIER S'IL Y A DES MARQUEURS VISIBLES
function hasVisibleMarkers() {
    let hasVisible = false;
    allMarkers.eachLayer(layer => {
        if (map.hasLayer(layer)) {
            hasVisible = true;
        }
    });
    return hasVisible;
}

// FONCTIONS POUR LE FILTRAGE PAR LOCALISATION
// Extraire les communes et districts uniques
function getUniqueLocations() {
    const communes = new Set();
    const districts = new Set();
   
    // Parcourir les descentes
    descentesData.forEach(descente => {
        if (descente.comm && descente.comm !== 'Non spécifié' && descente.comm !== 'null') {
            communes.add(descente.comm);
        }
        if (descente.dist && descente.dist !== 'Non spécifié' && descente.dist !== 'null') {
            districts.add(descente.dist);
        }
    });
   
    // Parcourir les archives
    archivesData.forEach(archive => {
        if (archive.municipality && archive.municipality !== 'Non spécifié' && archive.municipality !== 'null') {
            communes.add(archive.municipality);
        }
    });
   
    return {
        communes: Array.from(communes).sort(),
        districts: Array.from(districts).sort()
    };
}

// Recherche de localisation
function searchLocations(query) {
    const locations = getUniqueLocations();
    const currentLocations = currentLocationType === 'commune' ? locations.communes : locations.districts;
   
    const results = currentLocations.filter(loc =>
        loc.toLowerCase().includes(query.toLowerCase())
    );
   
    const resultsContainer = document.getElementById('location-results');
    resultsContainer.innerHTML = '';
   
    if (results.length > 0) {
        results.forEach(location => {
            const item = document.createElement('div');
            item.className = 'location-result-item';
            item.textContent = location;
            item.addEventListener('click', () => {
                document.getElementById('location-search-input').value = location;
                resultsContainer.style.display = 'none';
                filterByLocation(location, currentLocationType);
            });
            resultsContainer.appendChild(item);
        });
        resultsContainer.style.display = 'block';
    } else {
        resultsContainer.style.display = 'none';
    }
}

// FONCTION POUR EXPORTER EN PDF
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    const mapContainer = document.getElementById('map');
    const communeName = currentLocationFilter ? currentLocationFilter.location : 'Madagascar';
   
    // Afficher le loading
    const loading = document.getElementById('loading');
    loading.style.display = 'block';
    loading.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération du PDF...';
   
    // Temporairement cacher les contrôles pour une capture propre
    const controls = document.querySelectorAll('.map-controls, .map-type-controls, .filter-container, .legend-container, .location-filter-controls');
    const originalDisplay = [];
    controls.forEach(control => {
        originalDisplay.push(control.style.display);
        control.style.display = 'none';
    });
   
    setTimeout(() => {
        html2canvas(mapContainer, {
            useCORS: true,
            scale: 2,
            logging: false,
            backgroundColor: '#ffffff'
        }).then(canvas => {
            // Restaurer les contrôles
            controls.forEach((control, index) => {
                control.style.display = originalDisplay[index];
            });
           
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 190; // Largeur A4 moins marges
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
           
            // Ajouter le titre
            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            doc.text(`Commune: ${communeName}`, 105, 15, { align: 'center' });
           
            // Ajouter la date
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            const date = new Date().toLocaleDateString('fr-FR');
            doc.text(`Généré le: ${date}`, 105, 22, { align: 'center' });
           
            // Ajouter l'image de la carte
            doc.addImage(imgData, 'PNG', 10, 30, imgWidth, imgHeight);
           
            // Ajouter la légende
            const legendY = 30 + imgHeight + 10;
            doc.setFontSize(12);
            doc.setFont('helvetica', 'bold');
            doc.text('Légende:', 10, legendY);
           
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            const legendItems = [
                { color: '#f50b0bff', label: 'Descentes (sans FT)' },
                { color: '#10b981', label: 'FT établis' },
                { color: '#FF8C00', label: 'AP établis' },
                { color: '#3b82f6', label: 'Archives' },
                { color: '#8B4513', label: 'Constructions sur zone de protection' }
            ];
           
            legendItems.forEach((item, index) => {
                const yPos = legendY + 8 + (index * 5);
                doc.setFillColor(item.color);
                doc.rect(10, yPos - 3, 3, 3, 'F');
                doc.text(item.label, 15, yPos);
            });
           
            // Sauvegarder le PDF
            doc.save(`carte_${communeName.replace(/\s+/g, '_')}_${date.replace(/\//g, '-')}.pdf`);
           
            // Cacher le loading
            loading.style.display = 'none';
        }).catch(error => {
            console.error('Erreur lors de la génération du PDF:', error);
            alert('Erreur lors de la génération du PDF: ' + error.message);
           
            // Restaurer les contrôles en cas d'erreur
            controls.forEach((control, index) => {
                control.style.display = originalDisplay[index];
            });
           
            // Cacher le loading
            loading.style.display = 'none';
        });
    }, 1000);
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
            x = parseFloat(item.x_laborde);
            y = parseFloat(item.y_laborde);
        } else {
            x = parseFloat(item.xv);
            y = parseFloat(item.yv);
        }
       
        // Vérification stricte des valeurs nulles, vides ou invalides
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y) ||
            x === null || y === null || x === undefined || y === undefined) {
            return false;
        }
       
        // Validation des plages Laborde
        if (!validateLabordeCoordinates(x, y)) {
            return false;
        }
       
        return true;
    });
   
    console.log(`✅ ${type}s après filtrage: ${filteredData.length} valides sur ${data.length}`);
    return filteredData;
}

// FONCTION DE CONVERSION PRÉCISE LABORDE -> WGS84
function labordeToWGS84(x, y) {
    if (!x || !y || x == 0 || y == 0 || isNaN(x) || isNaN(y)) {
        return null;
    }
   
    if (!validateLabordeCoordinates(x, y)) {
        return null;
    }
   
    try {
        if (!proj4.defs("EPSG:8441")) {
            return null;
        }
       
        const fromProj = "EPSG:8441";
        const toProj = "EPSG:4326";
        const result = proj4(fromProj, toProj, [x, y]);
        const lon = result[0];
        const lat = result[1];
       
        if (lat < -25.6 || lat > -12.0 || lon < 43.0 || lon > 50.5) {
            return null;
        }
       
        return [lat, lon];
    } catch (error) {
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
    if (!isSurfaceSpecified(surface)) {
        return null;
    }
   
    const surfaceValue = parseFloat(surface);
    const scaleFactor = 0.2;
    let radius = Math.sqrt(surfaceValue) * scaleFactor;
    const minRadius = 50;
    const maxRadius = 1500;
   
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
   
    if (typeof surface === 'string' && surface.includes('m²')) {
        return surface;
    }
   
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
   
    if (isSurface) {
        return formatSurface(value);
    }
   
    if (isCoordinate) {
        return formatCoordinates(value);
    }
   
    return value;
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

// FONCTION CORRIGÉE POUR AJOUTER LES DESCENTES
function addDescentesToMap(descentes) {
    descentes.forEach((descente) => {
        const x = parseFloat(descente.x_laborde);
        const y = parseFloat(descente.y_laborde);
       
        if (!x || !y || x === 0 || y === 0 || isNaN(x) || isNaN(y)) {
            return;
        }
        
        const coords = labordeToWGS84(x, y);
        if (!coords) {
            return;
        }
       
        // Déterminer le type et la couleur
        let pointColor, borderColor, pointType, targetGroup, markerType;
       
        if (descente.ap) {
            pointColor = '#FF8C00';
            borderColor = '#FF4500';
            pointType = 'AP établi';
            targetGroup = apMarkers;
            markerType = 'ap';
        } else if (descente.ft_id && descente.ft_id !== 'null' && descente.ft_id !== '' && descente.ft_id !== 'Non spécifié') {
            pointColor = '#10b981';
            borderColor = '#059669';
            pointType = 'FT établi';
            targetGroup = ftMarkers;
            markerType = 'ft';
        } else {
            pointColor = '#f50b0bff';
            borderColor = '#cc0000';
            pointType = 'Descente';
            targetGroup = descenteMarkers;
            markerType = 'descente';
        }
       
        // Créer le badge avec le constat court
        const shortConstat = getShortConstat(descente);
        
        // Préparer les données de localisation pour le filtrage
        const customData = {
            commune: descente.comm,
            district: descente.dist
        };
        
        // Créer le contenu du popup
        const surfaceClass = getSurfaceClass(descente.sup_remblais);
        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: ${pointColor}; margin-bottom: 0.5rem; border-bottom: 2px solid ${pointColor}; padding-bottom: 0.5rem;">
                    ${pointType} #${descente.id}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. OM:</strong> ${getValueOrNotSpecified(descente.ref_om)}</p>
                    <p><strong>Surface:</strong> ${getValueOrNotSpecified(descente.sup_remblais, true)}</p>
                    <p><strong>Constat:</strong> ${descente.constat}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(descente.comm)}</p>
                    <p><strong>Date:</strong> ${formatDate(descente.date)}</p>
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: ${pointColor}; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showDescenteDetail('${descente.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        
        // Créer le marqueur avec la nouvelle fonction
        const marker = createMarkerWithBadge(
            coords, 
            pointColor, 
            borderColor, 
            descente.constat, 
            popupContent, 
            customData, 
            markerType
        );
       
        // Ajouter aux groupes appropriés
        targetGroup.addLayer(marker);
        allMarkers.addLayer(marker);
        descentesLayers[`descente_${descente.id}`] = marker;
    });
    
    console.log(`✅ ${descentes.length} descentes ajoutées à la carte`);
}

// FONCTION CORRIGÉE POUR AJOUTER LES ARCHIVES
function addArchivesToMap(archives) {
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
       
        let pointColor, borderColor, targetGroup, markerType;
       
        if (isMarron) {
            pointColor = '#8B4513';
            borderColor = '#654321';
            targetGroup = specialMarkers;
            markerType = 'special';
        } else {
            pointColor = '#3b82f6';
            borderColor = '#1d4ed8';
            targetGroup = archiveMarkers;
            markerType = 'archive';
        }
       
        const surfaceClass = getSurfaceClass(archive.backfilledarea);
        const shortConstat = getShortArchiveConstat(archive);
        
        // Préparer les données pour le filtrage
        const customData = {
            commune: archive.municipality,
            district: null
        };
        
        // Créer le contenu du popup
        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; max-width: 300px;">
                <h3 style="color: ${pointColor}; margin-bottom: 0.5rem; border-bottom: 2px solid ${pointColor}; padding-bottom: 0.5rem;">
                    Archive #${archive.id} ${isMarron ? '🚨' : ''}
                </h3>
                <div style="font-size: 0.85rem; color: #666;">
                    <p><strong>Réf. Arrivée:</strong> ${getValueOrNotSpecified(archive.arrivalid)}</p>
                    <p><strong>Constat:</strong> ${shortConstat}</p>
                    <p><strong>Commune:</strong> ${getValueOrNotSpecified(archive.municipality)}</p>
                    <p><strong>Date:</strong> ${formatDate(archive.arrivaldate)}</p>
                </div>
                <button style="width: 100%; padding: 0.4rem; background-color: ${pointColor}; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 0.5rem; font-size: 0.8rem;" onclick="showArchiveDetail('${archive.id}')">
                    Voir Détails Complets
                </button>
            </div>
        `;
        
        // Créer le marqueur avec la nouvelle fonction
        const marker = createMarkerWithBadge(
            coords, 
            pointColor, 
            borderColor, 
            shortConstat, 
            popupContent, 
            customData, 
            markerType
        );
       
        targetGroup.addLayer(marker);
        allMarkers.addLayer(marker);
        descentesLayers[`archive_${archive.id}`] = marker;
    });
    
    console.log(`✅ ${archives.length} archives ajoutées à la carte`);
}

// CHARGEMENT DES DONNÉES
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Début du chargement des données...');
   
    // Initialiser les écouteurs d'événements pour le filtre de localisation
    document.querySelectorAll('.location-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.location-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentLocationType = this.dataset.type;
            document.getElementById('location-search-input').placeholder = `Rechercher un ${currentLocationType === 'commune' ? 'commune' : 'district'}...`;
            document.getElementById('location-results').style.display = 'none';
        });
    });
   
    document.getElementById('location-search-input').addEventListener('input', function(e) {
        if (e.target.value.length >= 2) {
            searchLocations(e.target.value);
        } else {
            document.getElementById('location-results').style.display = 'none';
        }
    });
   
    document.getElementById('clear-location-filter').addEventListener('click', clearLocationFilter);
    document.getElementById('export-pdf').addEventListener('click', exportToPDF);
   
    // Cacher les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.location-search-container')) {
            document.getElementById('location-results').style.display = 'none';
        }
    });
    
    // Contrôles de carte existants
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
    document.getElementById('filter-descentes').addEventListener('change', applyFilters);
    document.getElementById('filter-ft').addEventListener('change', applyFilters);
    document.getElementById('filter-ap').addEventListener('change', applyFilters);
    document.getElementById('filter-archives').addEventListener('change', applyFilters);
    document.getElementById('filter-special').addEventListener('change', applyFilters);
   
    document.getElementById('reset-filters').addEventListener('click', resetFilters);
    
    // Afficher le loading
    document.getElementById('loading').style.display = 'block';
   
    setTimeout(() => {
        try {
            // Ajouter les groupes de marqueurs à la carte
            const markerGroups = {
                'descentes': descenteMarkers,
                'ft': ftMarkers, 
                'ap': apMarkers,
                'archives': archiveMarkers,
                'special': specialMarkers
            };
            
            // Ajouter tous les groupes à la carte initialement
            Object.values(markerGroups).forEach(group => {
                map.addLayer(group);
            });
           
            console.log('🔍 FILTRAGE DES DONNÉES...');
           
            const validDescentes = filterInvalidCoordinates(descentesData, 'descente');
            const validArchives = filterInvalidCoordinates(archivesData, 'archive');
           
            console.log('📊 RÉSULTATS FILTRAGE:');
            console.log(`- Descentes: ${validDescentes.length} valides sur ${descentesData.length}`);
            console.log(`- Archives: ${validArchives.length} valides sur ${archivesData.length}`);
           
            if (validDescentes.length > 0) {
                console.log('🗺️ Ajout des descentes à la carte...');
                addDescentesToMap(validDescentes);
            } else {
                console.warn('⚠️ AUCUNE DESCENTE VALIDE APRÈS FILTRAGE');
            }
           
            if (validArchives.length > 0) {
                console.log('🗺️ Ajout des archives à la carte...');
                addArchivesToMap(validArchives);
            } else {
                console.warn('⚠️ AUCUNE ARCHIVE VALIDE APRÈS FILTRAGE');
            }
           
            if (allMarkers.getLayers().length > 0) {
                console.log('🎯 Ajustement de la vue de la carte...');
                map.fitBounds(allMarkers.getBounds().pad(0.1));
                console.log(`✅ ${allMarkers.getLayers().length} points affichés sur la carte`);
            } else {
                console.warn('⚠️ AUCUN POINT VALIDE À AFFICHER');
                map.setView([-18.766947, 46.869107], 6);
            }
           
        } catch (error) {
            console.error('❌ ERREUR CRITIQUE:', error);
            alert('Une erreur est survenue lors du chargement de la carte: ' + error.message);
        } finally {
            document.getElementById('loading').style.display = 'none';
            console.log('🏁 Chargement des données terminé');
        }
    }, 500);
});

// Fonctions pour afficher les détails
function showDescenteDetail(descenteId) {
    const descente = descentesData.find(d => d.id == descenteId);
    if (!descente) return;
    
    // Déterminer le type et la couleur
    let typeColor, typeLabel;
   
    if (descente.ap) {
        typeColor = '#FF8C00';
        typeLabel = 'AP établi';
    } else if (descente.ft_id && descente.ft_id !== 'null' && descente.ft_id !== '' && descente.ft_id !== 'Non spécifié') {
        typeColor = '#10b981';
        typeLabel = 'FT établi';
    } else {
        typeColor = '#f50b0bff';
        typeLabel = 'Descente';
    }
    
    const surfaceClass = getSurfaceClass(descente.sup_remblais);
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
            </div>
        </div>
        <div class="detail-section">
            <h4 style="color: ${typeColor};">Informations techniques</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Surface (m²)</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.sup_remblais, true)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Catégorie surface</span>
                    <span class="detail-value">${surfaceClass}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Constat</span>
                    <span class="detail-value">${getValueOrNotSpecified(descente.constat)}</span>
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
                    <span class="detail-label">Propriétaire</span>
                    <span class="detail-value">${getValueOrNotSpecified(archive.property0wner)}</span>
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
            className: 'custom-marker-icon',
            iconSize: [30, 30],
            iconAnchor: [15, 15]
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
</script>
</body>
</html>
@endsection

@section('scripts')

@endsection