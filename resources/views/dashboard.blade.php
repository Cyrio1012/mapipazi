@extends('layouts.app')
@section('title', 'Tableau Bord')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, #fdfdfd 0%, #f9f9f9 100%);
            color: #334155;
            line-height: 1.5;
            min-height: 100vh;
            font-size: 14px;
        }

        .dashboard-container {
            max-width: 90%;
            margin: 0 auto;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .header h1::before {
            content: "🏢";
            font-size: 2rem;
        }

        .date-display {
            background: var(--primary);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0.8rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info {
            font-size: 0.8rem;
        }

        .user-name {
            font-weight: 600;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--secondary);
        }

        /* Stats Cards */
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .stat-card.active {
            border: 2px solid var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
        }

        .stat-card.active::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .stat-card.active .stat-icon {
            transform: scale(1.05);
        }

        .stat-icon.primary { background: linear-gradient(135deg, #dbeafe, #93c5fd); color: var(--primary); }
        .stat-icon.success { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: var(--success); }
        .stat-icon.warning { background: linear-gradient(135deg, #fef3c7, #fcd34d); color: var(--warning); }
        .stat-icon.danger { background: linear-gradient(135deg, #fee2e2, #fca5a5); color: var(--danger); }
        .stat-icon.info { background: linear-gradient(135deg, #c7d2fe, #a5b4fc); color: #4f46e5; }

        .stat-info h3 {
            font-size: 0.85rem;
            color: var(--secondary);
            margin-bottom: 0.6rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
            background: linear-gradient(135deg, var(--dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 600;
        }

        .stat-change.positive { color: var(--success); }
        .stat-change.negative { color: var(--danger); }

        /* Chart Containers */
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .chart-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .chart-btn {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 6px;
            background: var(--light);
            color: var(--secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .chart-btn.active {
            background: var(--primary);
            color: white;
        }

        .chart-wrapper {
            position: relative;
            height: 250px;
        }

        /* Surface Report */
        .surface-report {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .section-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .view-all:hover {
            background: var(--primary);
            color: white;
        }

        .surface-total {
            text-align: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #dbeafe, #93c5fd);
            border-radius: 12px;
            color: var(--dark);
        }

        .surface-total h3 {
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
            color: var(--secondary);
        }

        .surface-total-value {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
        }

        .surface-total-change {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--success);
        }

        .distribution-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .distribution-item:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateX(3px);
        }

        .distribution-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.85rem;
        }

        .distribution-value {
            font-size: 0.75rem;
            color: var(--secondary);
        }

        .distribution-percentage {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateX(3px);
        }

        .detail-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.85rem;
        }

        .detail-value {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .zone-highlight {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
            border-left: 3px solid var(--success);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stat-card {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
            }
            
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .chart-wrapper {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container container py-3">
        <!-- Header -->
        <header class="header px-3 py-2 d-flex justify-content-between align-items-center">
            <h1>Tableau de Bord APIPA</h1>
            <div class="d-flex align-items-center gap-3">
                <div class="date-display" id="currentDate"></div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="row g-3 mb-4 stats-grid">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card active p-3 d-flex align-items-center gap-3" data-view="descente">
                    <div class="stat-icon primary">
                        🚗
                    </div>
                    <div class="stat-info">
                        <h3>DESCENTE</h3>
                        <div class="stat-value">156</div>
                        <div class="stat-change positive">
                            <span>↑ 15.2%</span> vs mois dernier
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card p-3 d-flex align-items-center gap-3" data-view="fitanana">
                    <div class="stat-icon success">
                        📋
                    </div>
                    <div class="stat-info">
                        <h3>FITANANA AN-TSORATRA</h3>
                        <div class="stat-value">89</div>
                        <div class="stat-change positive">
                            <span>↑ 8.7%</span> vs mois dernier
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card p-3 d-flex align-items-center gap-3" data-view="avis-paiement">
                    <div class="stat-icon warning">
                        💰
                    </div>
                    <div class="stat-info">
                        <h3>AVIS DE PAIEMENT</h3>
                        <div class="stat-value">342</div>
                        <div class="stat-change positive">
                            <span>↑ 12.3%</span> vs mois dernier
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card p-3 d-flex align-items-center gap-3" data-view="demande-pc">
                    <div class="stat-icon info">
                        💻
                    </div>
                    <div class="stat-info">
                        <h3>DEMANDE PC</h3>
                        <div class="stat-value">67</div>
                        <div class="stat-change negative">
                            <span>↑ 5.8%</span> vs mois dernier
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="row g-4 mb-4 charts-grid">
            <!-- Chart 1: Évolution des données -->
            <div class="col-lg-6">
                <div class="chart-container p-3">
                    <div class="chart-header">
                        <h2 id="chart1Title">Évolution des Descentes</h2>
                        <div class="chart-actions d-flex gap-2">
                            <button class="chart-btn btn btn-sm active" data-period="mensuel">Mensuel</button>
                            <button class="chart-btn btn btn-sm" data-period="trimestriel">Trimestriel</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Répartition -->
            <div class="col-lg-6">
                <div class="chart-container p-3">
                    <div class="chart-header">
                        <h2 id="chart2Title">Répartition par Zone</h2>
                        <div class="chart-actions d-flex gap-2">
                            <button class="chart-btn btn btn-sm active" data-type="zones">Zones</button>
                            <button class="chart-btn btn btn-sm" data-type="types">Types</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 3: Statut -->
            <div class="col-lg-6">
                <div class="chart-container p-3">
                    <div class="chart-header">
                        <h2 id="chart3Title">Statut des Descentes</h2>
                        <div class="chart-actions d-flex gap-2">
                            <button class="chart-btn btn btn-sm active" data-status="statut">Statut</button>
                            <button class="chart-btn btn btn-sm" data-status="retards">Retards</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 4: Performance -->
            <div class="col-lg-6">
                <div class="chart-container p-3">
                    <div class="chart-header">
                        <h2 id="chart4Title">Performance Mensuelle</h2>
                        <div class="chart-actions d-flex gap-2">
                            <button class="chart-btn btn btn-sm active" data-year="2024">2024</button>
                            <button class="chart-btn btn btn-sm" data-year="2023">2023</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surface Report -->
        <div class="surface-report p-3">
            <div class="section-header">
                <h2 id="surfaceTitle">Rapport des Descentes</h2>
                <a href="#" class="view-all">Voir tout</a>
            </div>
            <div class="row g-4 surface-content">
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3 surface-main">
                        <div class="surface-total">
                            <h3 id="surfaceSubtitle">Total des descentes effectuées</h3>
                            <div class="surface-total-value" id="surfaceTotal">156</div>
                            <div class="surface-total-change" id="surfaceChange">+15.2% vs mois dernier</div>
                        </div>
                        
                        <div class="surface-distribution d-flex flex-column gap-2">
                            <h3 class="mb-2 fs-6 fw-semibold text-dark" id="distributionTitle">Répartition par type de descente</h3>
                            <div id="distributionContent">
                                <!-- Le contenu sera généré dynamiquement -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="surface-details d-flex flex-column gap-2">
                        <h3 class="mb-2 fs-6 fw-semibold text-dark">Détail des données</h3>
                        <div id="detailsContent">
                            <!-- Le contenu sera généré dynamiquement -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données pour chaque vue (inchangé)
        const viewData = {
            'descente': {
                title: 'Descentes',
                surfaceTotal: '156',
                surfaceChange: '+15.2% vs mois dernier',
                distribution: [
                    { name: 'Descentes planifiées', value: '89', percentage: '57.1%' },
                    { name: 'Descentes urgentes', value: '42', percentage: '26.9%' },
                    { name: 'Descentes de contrôle', value: '18', percentage: '11.5%' },
                    { name: 'Descentes spéciales', value: '7', percentage: '4.5%' }
                ],
                details: [
                    { name: 'Descentes planifiées', value: '89' },
                    { name: 'Descentes urgentes', value: '42' },
                    { name: 'Descentes de contrôle', value: '18' },
                    { name: 'Descentes spéciales', value: '7' }
                ],
                charts: {
                    main: {
                        mensuel: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                            datasets: [
                                { label: 'Descentes effectuées', data: [22, 28, 35, 42, 38, 45], color: '#2563eb' },
                                { label: 'Descentes planifiées', data: [25, 30, 32, 38, 40, 42], color: '#10b981' }
                            ]
                        },
                        trimestriel: {
                            labels: ['T1', 'T2', 'T3', 'T4'],
                            datasets: [
                                { label: 'Descentes effectuées', data: [85, 125, 115, 105], color: '#2563eb' },
                                { label: 'Descentes planifiées', data: [87, 120, 110, 100], color: '#10b981' }
                            ]
                        }
                    },
                    distribution: {
                        zones: {
                            labels: ['CUA Centre', 'CUA Périphérie', 'Zone Industrielle', 'Zone Résidentielle', 'Zone Commerciale'],
                            data: [35, 28, 15, 12, 10],
                            colors: ['#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#dbeafe']
                        },
                        types: {
                            labels: ['Planifiées', 'Urgentes', 'Contrôle', 'Spéciales'],
                            data: [57, 27, 12, 4],
                            colors: ['#10b981', '#f59e0b', '#ef4444', '#64748b']
                        }
                    },
                    status: {
                        statut: {
                            labels: ['Complétées', 'En cours', 'Reportées', 'Annulées'],
                            data: [132, 18, 4, 2],
                            colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444']
                        },
                        retards: {
                            labels: ['Dans les délais', '1-3 jours', '4-7 jours', '> 7 jours'],
                            data: [120, 25, 8, 3],
                            colors: ['#10b981', '#f59e0b', '#f97316', '#ef4444']
                        }
                    },
                    performance: {
                        2024: {
                            labels: ['Efficacité', 'Ponctualité', 'Couverture', 'Rapports', 'Satisfaction'],
                            datasets: [
                                { label: '2024', data: [85, 78, 92, 88, 82], color: '#2563eb' },
                                { label: '2023', data: [78, 72, 85, 80, 75], color: '#64748b' }
                            ]
                        },
                        2023: {
                            labels: ['Efficacité', 'Ponctualité', 'Couverture', 'Rapports', 'Satisfaction'],
                            datasets: [
                                { label: '2023', data: [78, 72, 85, 80, 75], color: '#64748b' },
                                { label: '2022', data: [72, 68, 78, 75, 70], color: '#94a3b8' }
                            ]
                        }
                    }
                }
            },
            'fitanana': {
                title: 'Fitanana an-Tsoratra',
                surfaceTotal: '89',
                surfaceChange: '+8.7% vs mois dernier',
                distribution: [
                    { name: 'Fitanana validés', value: '67', percentage: '75.3%' },
                    { name: 'En attente validation', value: '15', percentage: '16.9%' },
                    { name: 'Fitanana rejetés', value: '7', percentage: '7.8%' }
                ],
                details: [
                    { name: 'Fitanana validés', value: '67' },
                    { name: 'En attente validation', value: '15' },
                    { name: 'Fitanana rejetés', value: '7' }
                ],
                charts: {
                    main: {
                        mensuel: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                            datasets: [
                                { label: 'Fitanana soumis', data: [12, 15, 18, 22, 20, 25], color: '#10b981' },
                                { label: 'Fitanana validés', data: [10, 12, 15, 18, 17, 22], color: '#2563eb' }
                            ]
                        },
                        trimestriel: {
                            labels: ['T1', 'T2', 'T3', 'T4'],
                            datasets: [
                                { label: 'Fitanana soumis', data: [45, 65, 55, 50], color: '#10b981' },
                                { label: 'Fitanana validés', data: [37, 55, 48, 45], color: '#2563eb' }
                            ]
                        }
                    },
                    distribution: {
                        zones: {
                            labels: ['CUA Centre', 'CUA Périphérie', 'Zone Industrielle', 'Autres zones'],
                            data: [45, 25, 15, 15],
                            colors: ['#10b981', '#34d399', '#6ee7b7', '#a7f3d0']
                        },
                        types: {
                            labels: ['Validation terrain', 'Contrôle qualité', 'Expertise technique', 'Audit'],
                            data: [40, 30, 20, 10],
                            colors: ['#10b981', '#f59e0b', '#ef4444', '#64748b']
                        }
                    },
                    status: {
                        statut: {
                            labels: ['Validés', 'En attente', 'Rejetés', 'En correction'],
                            data: [67, 15, 7, 10],
                            colors: ['#10b981', '#f59e0b', '#ef4444', '#3b82f6']
                        },
                        retards: {
                            labels: ['Dans délais', '1-2 jours', '3-5 jours', '> 5 jours'],
                            data: [60, 18, 8, 3],
                            colors: ['#10b981', '#f59e0b', '#f97316', '#ef4444']
                        }
                    },
                    performance: {
                        2024: {
                            labels: ['Validation', 'Qualité', 'Délais', 'Exactitude', 'Conformité'],
                            datasets: [
                                { label: '2024', data: [88, 92, 85, 90, 87], color: '#10b981' },
                                { label: '2023', data: [82, 85, 78, 83, 80], color: '#64748b' }
                            ]
                        },
                        2023: {
                            labels: ['Validation', 'Qualité', 'Délais', 'Exactitude', 'Conformité'],
                            datasets: [
                                { label: '2023', data: [82, 85, 78, 83, 80], color: '#64748b' },
                                { label: '2022', data: [78, 80, 72, 78, 75], color: '#94a3b8' }
                            ]
                        }
                    }
                }
            },
            'avis-paiement': {
                title: 'Avis de Paiement',
                surfaceTotal: '342',
                surfaceChange: '+12.3% vs mois dernier',
                distribution: [
                    { name: 'Paiements reçus', value: '285', percentage: '83.3%' },
                    { name: 'En attente paiement', value: '42', percentage: '12.3%' },
                    { name: 'Paiements en retard', value: '15', percentage: '4.4%' }
                ],
                details: [
                    { name: 'Paiements reçus', value: '285' },
                    { name: 'En attente paiement', value: '42' },
                    { name: 'Paiements en retard', value: '15' }
                ],
                charts: {
                    main: {
                        mensuel: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                            datasets: [
                                { label: 'Avis émis', data: [45, 52, 58, 65, 72, 78], color: '#f59e0b' },
                                { label: 'Paiements reçus', data: [38, 45, 50, 58, 65, 70], color: '#10b981' }
                            ]
                        },
                        trimestriel: {
                            labels: ['T1', 'T2', 'T3', 'T4'],
                            datasets: [
                                { label: 'Avis émis', data: [155, 195, 185, 175], color: '#f59e0b' },
                                { label: 'Paiements reçus', data: [133, 173, 165, 158], color: '#10b981' }
                            ]
                        }
                    },
                    distribution: {
                        zones: {
                            labels: ['CUA Centre', 'CUA Périphérie', 'Zone Industrielle', 'Zone Résidentielle'],
                            data: [40, 30, 20, 10],
                            colors: ['#f59e0b', '#fbbf24', '#fcd34d', '#fde68a']
                        },
                        types: {
                            labels: ['Taxes foncières', 'Redevances', 'Services', 'Amendes'],
                            data: [55, 25, 15, 5],
                            colors: ['#f59e0b', '#ef4444', '#10b981', '#64748b']
                        }
                    },
                    status: {
                        statut: {
                            labels: ['Payés', 'En attente', 'En retard', 'Annulés'],
                            data: [285, 42, 15, 8],
                            colors: ['#10b981', '#f59e0b', '#ef4444', '#64748b']
                        },
                        retards: {
                            labels: ['< 7 jours', '7-15 jours', '15-30 jours', '> 30 jours'],
                            data: [8, 4, 2, 1],
                            colors: ['#f59e0b', '#f97316', '#ef4444', '#dc2626']
                        }
                    },
                    performance: {
                        2024: {
                            labels: ['Recouvrement', 'Délais', 'Efficacité', 'Automatisation', 'Satisfaction'],
                            datasets: [
                                { label: '2024', data: [85, 78, 92, 75, 88], color: '#f59e0b' },
                                { label: '2023', data: [78, 72, 85, 65, 82], color: '#64748b' }
                            ]
                        },
                        2023: {
                            labels: ['Recouvrement', 'Délais', 'Efficacité', 'Automatisation', 'Satisfaction'],
                            datasets: [
                                { label: '2023', data: [78, 72, 85, 65, 82], color: '#64748b' },
                                { label: '2022', data: [72, 68, 78, 58, 75], color: '#94a3b8' }
                            ]
                        }
                    }
                }
            },
            'demande-pc': {
                title: 'Demandes PC',
                surfaceTotal: '67',
                surfaceChange: '+5.8% vs mois dernier',
                distribution: [
                    { name: 'Demandes approuvées', value: '45', percentage: '67.2%' },
                    { name: 'En cours traitement', value: '15', percentage: '22.4%' },
                    { name: 'Demandes rejetées', value: '7', percentage: '10.4%' }
                ],
                details: [
                    { name: 'Demandes approuvées', value: '45' },
                    { name: 'En cours traitement', value: '15' },
                    { name: 'Demandes rejetées', value: '7' }
                ],
                charts: {
                    main: {
                        mensuel: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                            datasets: [
                                { label: 'Demandes reçues', data: [8, 10, 12, 15, 18, 22], color: '#4f46e5' },
                                { label: 'Demandes traitées', data: [6, 8, 10, 12, 15, 18], color: '#10b981' }
                            ]
                        },
                        trimestriel: {
                            labels: ['T1', 'T2', 'T3', 'T4'],
                            datasets: [
                                { label: 'Demandes reçues', data: [30, 45, 40, 35], color: '#4f46e5' },
                                { label: 'Demandes traitées', data: [24, 37, 33, 30], color: '#10b981' }
                            ]
                        }
                    },
                    distribution: {
                        zones: {
                            labels: ['CUA Centre', 'CUA Périphérie', 'Zone Industrielle', 'Zone Mixte'],
                            data: [35, 25, 20, 20],
                            colors: ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc']
                        },
                        types: {
                            labels: ['Nouvelle construction', 'Extension', 'Rénovation', 'Changement usage'],
                            data: [40, 25, 20, 15],
                            colors: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444']
                        }
                    },
                    status: {
                        statut: {
                            labels: ['Approuvées', 'En traitement', 'Rejetées', 'En révision'],
                            data: [45, 15, 7, 10],
                            colors: ['#10b981', '#3b82f6', '#ef4444', '#f59e0b']
                        },
                        retards: {
                            labels: ['Dans délais', '1-2 semaines', '3-4 semaines', '> 1 mois'],
                            data: [35, 20, 8, 4],
                            colors: ['#10b981', '#f59e0b', '#f97316', '#ef4444']
                        }
                    },
                    performance: {
                        2024: {
                            labels: ['Traitement', 'Validation', 'Qualité', 'Innovation', 'Satisfaction'],
                            datasets: [
                                { label: '2024', data: [78, 85, 88, 75, 82], color: '#4f46e5' },
                                { label: '2023', data: [72, 78, 82, 68, 75], color: '#64748b' }
                            ]
                        },
                        2023: {
                            labels: ['Traitement', 'Validation', 'Qualité', 'Innovation', 'Satisfaction'],
                            datasets: [
                                { label: '2023', data: [72, 78, 82, 68, 75], color: '#64748b' },
                                { label: '2022', data: [68, 72, 78, 62, 70], color: '#94a3b8' }
                            ]
                        }
                    }
                }
            }
        };

        // Variables globales pour les graphiques
        let mainChart, distributionChart, statusChart, performanceChart;
        let currentView = 'descente';
        let currentPeriod = 'mensuel';
        let currentType = 'zones';
        let currentStatus = 'statut';
        let currentYear = '2024';

        // Date actuelle
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('fr-FR', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Initialisation des graphiques
        function initializeCharts() {
            // Chart 1: Évolution principale
            const mainCtx = document.getElementById('mainChart').getContext('2d');
            mainChart = new Chart(mainCtx, {
                type: 'line',
                data: { labels: [], datasets: [] },
                options: getLineChartOptions()
            });

            // Chart 2: Répartition
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            distributionChart = new Chart(distributionCtx, {
                type: 'doughnut',
                data: { labels: [], datasets: [] },
                options: getDoughnutChartOptions()
            });

            // Chart 3: Statut
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'bar',
                data: { labels: [], datasets: [] },
                options: getBarChartOptions()
            });

            // Chart 4: Performance
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            performanceChart = new Chart(performanceCtx, {
                type: 'radar',
                data: { labels: [], datasets: [] },
                options: getRadarChartOptions()
            });
        }

        // Options des graphiques
        function getLineChartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        position: 'top',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    } 
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.1)' },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            };
        }

        function getDoughnutChartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        position: 'right',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    } 
                }
            };
        }

        function getBarChartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.1)' },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            };
        }

        function getRadarChartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    r: {
                        angleLines: { color: 'rgba(0,0,0,0.1)' },
                        grid: { color: 'rgba(0,0,0,0.1)' },
                        suggestedMin: 0,
                        suggestedMax: 100,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            };
        }

        // Mise à jour des graphiques
        function updateCharts(view) {
            const data = viewData[view].charts;
            
            // Chart 1: Évolution principale
            const mainData = data.main[currentPeriod];
            mainChart.data.labels = mainData.labels;
            mainChart.data.datasets = mainData.datasets.map(dataset => ({
                label: dataset.label,
                data: dataset.data,
                borderColor: dataset.color,
                backgroundColor: dataset.color + '20',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }));
            mainChart.update();

            // Chart 2: Répartition
            const distributionData = data.distribution[currentType];
            distributionChart.data.labels = distributionData.labels;
            distributionChart.data.datasets = [{
                data: distributionData.data,
                backgroundColor: distributionData.colors,
                borderWidth: 1,
                borderColor: '#fff'
            }];
            distributionChart.update();

            // Chart 3: Statut
            const statusData = data.status[currentStatus];
            statusChart.data.labels = statusData.labels;
            statusChart.data.datasets = [{
                label: 'Nombre',
                data: statusData.data,
                backgroundColor: statusData.colors,
                borderWidth: 0,
                borderRadius: 6
            }];
            statusChart.update();

            // Chart 4: Performance
            const performanceData = data.performance[currentYear];
            performanceChart.data.labels = performanceData.labels;
            performanceChart.data.datasets = performanceData.datasets.map(dataset => ({
                label: dataset.label,
                data: dataset.data,
                backgroundColor: dataset.color + '20',
                borderColor: dataset.color,
                borderWidth: 1.5,
                pointBackgroundColor: dataset.color,
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: dataset.color
            }));
            performanceChart.update();
        }

        // Gestion des clics sur les cartes
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('click', function() {
                const view = this.dataset.view;
                statCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                updateView(view);
                currentView = view;
            });
        });

        // Gestion des boutons de graphiques
        document.querySelectorAll('.chart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.parentElement;
                parent.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Mettre à jour les paramètres selon le type de bouton
                if (this.dataset.period) {
                    currentPeriod = this.dataset.period;
                } else if (this.dataset.type) {
                    currentType = this.dataset.type;
                } else if (this.dataset.status) {
                    currentStatus = this.dataset.status;
                } else if (this.dataset.year) {
                    currentYear = this.dataset.year;
                }

                updateCharts(currentView);
            });
        });

        // Fonction pour mettre à jour l'affichage
        function updateView(view) {
            const data = viewData[view];
            
            // Mettre à jour les titres
            document.getElementById('surfaceTitle').textContent = `Rapport des ${data.title}`;
            document.getElementById('surfaceSubtitle').textContent = `Total des ${data.title.toLowerCase()}`;
            document.getElementById('distributionTitle').textContent = `Répartition des ${data.title.toLowerCase()}`;
            
            // Mettre à jour les valeurs principales
            document.getElementById('surfaceTotal').textContent = data.surfaceTotal;
            document.getElementById('surfaceChange').textContent = data.surfaceChange;
            
            // Mettre à jour la distribution
            const distributionContent = document.getElementById('distributionContent');
            distributionContent.innerHTML = data.distribution.map(item => `
                <div class="distribution-item">
                    <div class="distribution-info d-flex flex-column gap-1">
                        <div class="distribution-name">${item.name}</div>
                        <div class="distribution-value">${item.value} (${item.percentage})</div>
                    </div>
                    <div class="distribution-percentage">${item.percentage}</div>
                </div>
            `).join('');
            
            // Mettre à jour les détails
            const detailsContent = document.getElementById('detailsContent');
            detailsContent.innerHTML = data.details.map((item, index) => `
                <div class="detail-item ${index === 2 ? 'zone-highlight' : ''}">
                    <div class="detail-name">${item.name}</div>
                    <div class="detail-value">${item.value}</div>
                </div>
            `).join('');
            
            // Mettre à jour les graphiques
            updateCharts(view);
        }

        // Initialisation
        initializeCharts();
        updateView(currentView);
    </script>
   
@endsection

@section('scripts')

@endsection