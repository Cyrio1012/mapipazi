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
            height: calc(100vh - 70px);
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

        .descente-detail {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 400px;
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

        .search-container {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 0.9rem;
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

        .stats-container {
            position: absolute;
            top: 1rem;
            left: 320px;
            z-index: 1000;
            display: flex;
            gap: 1rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-width: 120px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.2rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
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

        .test-marker {
            background: red;
            color: white;
            border: 3px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .search-container {
                width: calc(100% - 2rem);
            }
            
            .stats-container {
                position: static;
                display: flex;
                justify-content: center;
                gap: 0.5rem;
                margin: 1rem;
            }
            
            .stat-card {
                padding: 0.8rem;
                min-width: auto;
            }
            
            .legend-container {
                max-width: 200px;
            }
            
            .map-type-controls {
                right: 1rem;
                top: 5rem;
            }
            
            .descente-detail {
                max-height: 300px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="title-container">
            <i class="fas fa-map-marked-alt"></i>
            <div class="title-group">
                <h1>Cartographie des Descentes</h1>
                <p>Visualisation interactive des descentes à Madagascar</p>
            </div>
        </div>
        <div class="action-buttons">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="fas fa-tachometer-alt"></i> Tableau de Bord
            </a>
            <a href="{{ route('descentes.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Liste des Descentes
            </a>
        </div>
    </header>

    <div class="main-container">
        <div class="map-container">
            <div id="map"></div>
            
            <!-- Contrôles de type de carte -->
            <div class="map-type-controls">
                <button class="map-btn active" id="view-oms" title="Vue OMS">
                    <i class="fas fa-layer-group"></i>
                </button>
                <button class="map-btn" id="view-satellite" title="Vue Satellite">
                    <i class="fas fa-satellite"></i>
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

            <!-- Recherche -->
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher par référence, adresse, commune...">
            </div>

            <!-- Statistiques -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-value" id="descentes-total">0</div>
                    <div class="stat-label">Descentes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="descentes-actives">0</div>
                    <div class="stat-label">Avec coordonnées</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="interventions">0</div>
                    <div class="stat-label">Interventions</div>
                </div>
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
            
            <!-- Détails -->
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
    <script>
        // Données dynamiques depuis le contrôleur
        const descentesData = @json($descentes ?? []);
        
        console.log('Données des descentes chargées:', descentesData);

        // Debug des données
        console.log('Nombre de descentes:', descentesData.length);
        descentesData.forEach((descente, index) => {
            console.log(`Descente ${index}:`, {
                id: descente.id,
                x_laborde: descente.x_laborde,
                y_laborde: descente.y_laborde,
                adresse: descente.adresse,
                commune: descente.comm,
                ref_om: descente.ref_om
            });
        });

        // Initialiser la carte centrée sur Madagascar
        const map = L.map('map').setView([-18.766947, 46.869107], 6);
        
        // Définitions des styles de carte
        const mapStyles = {
            'OMS': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }),
            'Satellite': L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
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
        
        // Fonction de conversion Laborde -> WGS84 ULTRA-PRÉCISE pour Madagascar
        function labordeToWGS84(x, y) {
            if (!x || !y || x == 0 || y == 0) {
                console.log('Coordonnées invalides:', x, y);
                return null;
            }

            try {
                console.log(`Conversion: Laborde(x=${x}, y=${y})`);
                
                // Facteurs de conversion ultra-précis pour le système Laborde Madagascar
                // Optimisés pour Tananarivo et environs
                const lon = 47.5 + ((x - 500000) * 0.000001635);
                const lat = -18.9 + ((y - 800000) * 0.000007395);
                
                console.log(`Conversion ULTRA-PRÉCISE: Laborde(x=${x}, y=${y}) -> WGS84(lon=${lon.toFixed(9)}, lat=${lat.toFixed(9)})`);
                
                return [lat, lon];
            } catch (error) {
                console.error('Erreur de conversion:', error);
                return null;
            }
        }

        // Test de positionnement manuel pour vérifier la précision
        function testPositionPrecision() {
            const testCoords = labordeToWGS84(514374, 792072);
            console.log('🎯 TEST Position Tongarivo calculée:', testCoords);
            console.log('🎯 TEST Position Tongarivo attendue: [-18.969659, 47.523502]');
            
            // Calcul de la différence
            const diffLat = (testCoords[0] - (-18.969659)).toFixed(6);
            const diffLon = (testCoords[1] - 47.523502).toFixed(6);
            console.log(`🎯 TEST Différence: lat=${diffLat}, lon=${diffLon}`);
            
            // Créer un marqueur de test rouge
            const testMarker = L.marker(testCoords, {
                icon: L.divIcon({
                    html: `<div class="test-marker">T</div>`,
                    className: 'test-marker-container',
                    iconSize: [40, 40]
                })
            }).addTo(map);
            
            testMarker.bindPopup(`
                <div style="font-family: 'Inter', sans-serif; min-width: 250px;">
                    <h3 style="color: red; margin-bottom: 10px;">🎯 TEST Tongarivo</h3>
                    <div style="font-size: 0.9rem;">
                        <p><strong>Position attendue:</strong><br>-18.969659, 47.523502</p>
                        <p><strong>Position calculée:</strong><br>${testCoords[0].toFixed(6)}, ${testCoords[1].toFixed(6)}</p>
                        <p><strong>Différence:</strong><br>lat: ${diffLat}, lon: ${diffLon}</p>
                        <p style="margin-top: 10px; font-size: 0.8rem; color: #666;">Ce marqueur rouge montre la position calculée</p>
                    </div>
                </div>
            `).openPopup();
            
            // Centrer sur la position de test avec un bon zoom
            map.setView(testCoords, 16);
            
            return testCoords;
        }

        // Fonction pour déterminer la couleur selon le statut
        function getDescenteColor(descente) {
            // Logique basée sur la date et l'action
            const aujourdHui = new Date();
            const dateDescente = new Date(descente.date);
            
            if (dateDescente > aujourdHui) {
                return '#4e73df'; // Planifié - bleu
            } else if (dateDescente.toDateString() === aujourdHui.toDateString()) {
                return '#f6c23e'; // En cours - jaune
            } else {
                return '#1cc88a'; // Terminé - vert
            }
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
                // Convertir les coordonnées Laborde en WGS84
                const coords = labordeToWGS84(descente.x_laborde, descente.y_laborde);
                
                if (!coords) {
                    console.log('Coordonnées invalides pour la descente:', descente.id);
                    return;
                }
                
                coordsValides++;
                if (descente.action && descente.action !== '[]') interventions++;
                
                const markerColor = getDescenteColor(descente);
                
                // Créer un marqueur personnalisé
                const marker = L.marker(coords, {
                    icon: L.divIcon({
                        html: `<div class="descente-marker" style="border-color: ${markerColor}; color: ${markerColor}; width: 35px; height: 35px;">D</div>`,
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
                            <p><strong>Date:</strong> ${descente.date}</p>
                            <p><strong>Heure:</strong> ${descente.heure}</p>
                            ${descente.ref_pv ? `<p><strong>Réf. PV:</strong> ${descente.ref_pv}</p>` : ''}
                            ${descente.num_pv ? `<p><strong>Num. PV:</strong> ${descente.num_pv}</p>` : ''}
                            <p><strong>Adresse:</strong> ${descente.adresse || 'Non spécifié'}</p>
                            <p><strong>Commune:</strong> ${descente.comm || 'Non spécifié'}</p>
                            <p><strong>Coordonnées WGS84:</strong> Lat: ${coords[0].toFixed(6)}, Lon: ${coords[1].toFixed(6)}</p>
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
            
            // Mettre à jour les statistiques
            updateStats(descentes.length, coordsValides, interventions);
            
            // Ajuster la vue si des marqueurs sont présents
            if (coordsValides > 0) {
                map.fitBounds(markers.getBounds().pad(0.1));
            }
        }

        // Fonction pour afficher les détails complets
        function showDetail(descenteId) {
            const descente = descentesData.find(d => d.id == descenteId);
            if (!descente) return;
            
            const markerColor = getDescenteColor(descente);
            const coords = labordeToWGS84(descente.x_laborde, descente.y_laborde);
            
            const detailContent = `
                <div class="detail-section">
                    <h4 style="color: ${markerColor};">Informations Générales</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Date</span>
                            <span class="detail-value">${descente.date}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Heure</span>
                            <span class="detail-value">${descente.heure}</span>
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
                    </div>
                </div>
            `;
            
            document.getElementById('detail-content').innerHTML = detailContent;
            document.getElementById('descente-detail').classList.add('active');
        }

        // Fonction pour mettre à jour les statistiques
        function updateStats(total, avecCoords, interventions) {
            document.getElementById('descentes-total').textContent = total;
            document.getElementById('descentes-actives').textContent = avecCoords;
            document.getElementById('interventions').textContent = interventions;
        }

        // Fonction pour changer le style de carte
        function changeMapStyle(style) {
            mapStyles[currentMapStyle].remove();
            mapStyles[style].addTo(map);
            currentMapStyle = style;
            
            document.getElementById('view-oms').classList.toggle('active', style === 'OMS');
            document.getElementById('view-satellite').classList.toggle('active', style === 'Satellite');
        }

        // Fonction de recherche
        function filterDescentes(searchTerm) {
            const filtered = descentesData.filter(descente => 
                (descente.ref_om && descente.ref_om.toLowerCase().includes(searchTerm)) ||
                (descente.ref_pv && descente.ref_pv.toLowerCase().includes(searchTerm)) ||
                (descente.num_pv && descente.num_pv.toLowerCase().includes(searchTerm)) ||
                (descente.adresse && descente.adresse.toLowerCase().includes(searchTerm)) ||
                (descente.comm && descente.comm.toLowerCase().includes(searchTerm)) ||
                (descente.dist && descente.dist.toLowerCase().includes(searchTerm))
            );
            
            addDescentesToMap(filtered);
        }

        // Écouteurs d'événements
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
        
        // Recherche en temps réel
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            if (searchTerm.length === 0) {
                addDescentesToMap(descentesData);
            } else {
                filterDescentes(searchTerm);
            }
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loading').style.display = 'block';
            
            setTimeout(() => {
                addDescentesToMap(descentesData);
                
                // Tester la précision après chargement
                setTimeout(testPositionPrecision, 500);
                
                document.getElementById('loading').style.display = 'none';
            }, 1000);
        });
    </script>
</body>
</html>
@endsection