<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>APIPA - Protection contre les inondations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #70aae4;
            --secondary: #0195c5;
            --accent: #00a8e8;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .navbar-brand img {
            height: 50px;
            margin-right: 10px;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .btn-espace {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-espace:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 102, 204, 0.2);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(84, 185, 219, 0.2), rgba(0, 77, 153, 0.9)), 
                        url('{{ asset('assets/img/pelleAmphibie.png?auto=format&fit=crop&w=2070&q=80')}}');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0 90px;
            position: relative;
            overflow: hidden;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 600px;
        }
        
        .hero-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        
        .hero-wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }
        
        /* Section Styling */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--accent);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        /* Features */
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 168, 232, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        
        .feature-icon i {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .feature-card h4 {
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        /* Statistics */
        .stats-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 80px 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }
        
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* Services */
        .service-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .service-img {
            height: 200px;
            overflow: hidden;
        }
        
        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .service-card:hover .service-img img {
            transform: scale(1.05);
        }
        
        .service-content {
            padding: 25px;
        }
        
        /* Team */
        .team-card {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .team-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 5px solid #f0f8ff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .team-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Contact */
        .contact-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 40px;
            height: 100%;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        /* Footer */
        .footer {
            background: #1a2c42;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background: var(--accent);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }
        
        /* Bouton Doléance */
        .doleance-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            background: linear-gradient(135deg, var(--danger), #c82333);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-weight: 500;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .doleance-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
            }
            50% {
                box-shadow: 0 6px 20px rgba(220, 53, 69, 0.6);
            }
            100% {
                box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
            }
        }
        
        /* Modal Doléance */
        .modal-doleance .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }
        
        .modal-doleance .modal-header {
            background: linear-gradient(135deg, var(--danger), #c82333);
            color: white;
            border-bottom: none;
            padding: 25px 30px;
        }
        
        .modal-doleance .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        
        .modal-doleance .modal-header .btn-close:hover {
            opacity: 1;
        }
        
        .modal-doleance .modal-body {
            padding: 30px;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        
        .btn-submit-doleance {
            background: linear-gradient(135deg, var(--danger), #c82333);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-submit-doleance:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(220, 53, 69, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .doleance-btn {
                bottom: 20px;
                right: 20px;
                padding: 12px 20px;
                font-size: 0.9rem;
            }
            
            .doleance-btn i {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .doleance-btn span {
                display: none;
            }
            
            .doleance-btn {
                padding: 15px;
                width: 55px;
                height: 55px;
                justify-content: center;
            }
            
            .doleance-btn i {
                font-size: 1.3rem;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="/assets/img/Apipa.webp" alt="APIPA Logo">
                APIPA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#apropos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#missions">Missions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-espace" href="{{ route('login') }}">
                            <i class="fas fa-user-circle me-2"></i> Espace personnel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Protéger la plaine d'Antananarivo contre les inondations</h1>
                    <p>L'Autorité pour la Protection contre les Inondations de la Plaine d'Antananarivo (APIPA) veille à la sécurité des populations et des infrastructures face aux risques d'inondation.</p>
                    <div class="mt-4">
                        <a href="#missions" class="btn btn-light btn-lg me-3">Nos missions</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg">Nous contacter</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="apropos">
        <div class="container">
            <div class="section-title">
                <h2>À propos de l'APIPA</h2>
                <p>Créée pour répondre aux défis croissants des inondations dans la plaine d'Antananarivo, l'APIPA est l'autorité de référence en matière de prévention et de gestion des risques d'inondation.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="position-relative">
                        <div class="img-fluid rounded-3 shadow" style="background: linear-gradient(rgba(0, 102, 204, 0.7), rgba(0, 77, 153, 0.07)), url('{{ asset('assets/img/logo-30ans.png?fit=crop&w=350&q=80')}}'); height: 600px; background-size: cover; background-position: center;"></div>
                        <div class="position-absolute bottom-0 start-0 p-4 bg-white rounded-end shadow" style="width: 100%;">
                            <h4 class="text-primary">Antananarivo | APIPA</h4>
                            <p class="mb-0">protège la capitale depuis de trentenaire...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="mb-4">Notre mission: protéger, prévenir, sécuriser</h3>
                    <p class="mb-4">L'APIPA a été établie pour coordonner les efforts de prévention et de gestion des risques d'inondation dans la plaine d'Antananarivo, une région particulièrement vulnérable aux inondations en raison de sa topographie et des changements climatiques.</p>
                    <div class="row mt-5">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-4">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h5>Protection des populations</h5>
                                    <p>Sécurité des habitants face aux risques d'inondation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-4">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div>
                                    <h5>Infrastructures résilientes</h5>
                                    <p>Construction et entretien d'ouvrages de protection.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-4">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div>
                                    <h5>Système d'alerte précoce</h5>
                                    <p>Surveillance permanente et alertes en temps réel.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h5>Participation communautaire</h5>
                                    <p>Impliquer les communautés dans la prévention.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-5">
                    <span class="stat-number" data-count="150">150 émis</span>
                    <span class="stat-label">Avis de Paiement</span>
                </div>
                <div class="col-md-3 col-6 mb-5">
                    <span class="stat-number" data-count="85">75 %</span>
                    <span class="stat-label">Exécution budgetaire</span>
                </div>
                <div class="col-md-3 col-6 mb-5">
                    <span class="stat-number" data-count="2500">600 m</span>
                    <span class="stat-label">Digues entretenues</span>
                </div>
                <div class="col-md-3 col-6 mb-5">
                    <span class="stat-number" data-count="55">55 com.</span>
                    <span class="stat-label">Zones d'interventions</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Missions Section -->
    <section class="section bg-light" id="missions">
        <div class="container">
            <div class="section-title">
                <h2>Nos Missions</h2>
                <p>L'APIPA exerce plusieurs missions clés pour assurer la protection contre les inondations dans la plaine d'Antananarivo.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <h4>Gestion des bassins versants</h4>
                        <p>Aménagement et entretien des bassins versants pour réguler le débit des eaux et prévenir les crues soudaines.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                        <h4>Construction d'ouvrages</h4>
                        <p>Conception et construction de digues, barrages et canaux de drainage pour protéger les zones vulnérables.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Surveillance hydrologique</h4>
                        <p>Surveillance continue des niveaux d'eau et prévisions météorologiques pour anticiper les risques d'inondation.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>Sensibilisation publique</h4>
                        <p>Campagnes d'information et de formation pour préparer les populations aux situations d'urgence.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h4>Réglementation urbaine</h4>
                        <p>Élaboration et application de normes de construction pour limiter l'impact des inondations.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h4>Coordination d'urgence</h4>
                        <p>Coordination des interventions en cas d'inondation avec les services de secours et les autorités locales.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>L'APIPA propose une gamme de services pour les particuliers, les entreprises et les collectivités territoriales.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/remblai.webp?auto=format&fit=crop&w=2070&q=80') }}" alt="Études techniques">
                        </div>
                        <div class="service-content">
                            <h4>Études techniques</h4>
                            <p>Analyses de risques, études d'impact et évaluations hydrologiques pour vos projets de construction.</p>
                            <a href="#contact" class="btn btn-outline-primary mt-3">Demander une étude</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/remblai1.webp?auto=format&fit=crop&w=2070&q=80') }}" alt="Permis et autorisations">
                        </div>
                        <div class="service-content">
                            <h4>Permis et autorisations</h4>
                            <p>Délivrance de permis de construire et autorisations pour les projets en zones inondables.</p>
                            <a href="#contact" class="btn btn-outline-primary mt-3">Voir les démarches</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-img">
                            <img src="{{ asset('assets/img/remblai.jpg?auto=format&fit=crop&w=2070&q=80') }}" alt="Formation et conseil">
                        </div>
                        <div class="service-content">
                            <h4>Formation et conseil</h4>
                            <p>Formations sur la gestion des risques et conseils techniques pour les CTD.</p>
                            <a href="#contact" class="btn btn-outline-primary mt-3">S'inscrire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section bg-light" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contactez-nous</h2>
                <p>N'hésitez pas à nous contacter pour toute question ou demande d'information.</p>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="contact-info">
                        <h3 class="mb-4">Informations de contact</h3>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5>Adresse</h5>
                                <p>Rue Pasteur RAHAJASON<br>lot IVW 18 E, Anisizato-Est II</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h5>Téléphone</h5>
                                <p>+261 34 44 273 32<br>+261 34 05 578 90</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>Email</h5>
                                <p>apipatana.dg@gmail.com<br>dg.apipa@sadex.mg</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h5>Horaires de bureau</h5>
                                <p>Lundi-Vendredi: 8h00 - 16h00<br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="bg-white rounded-3 p-4 p-md-5 shadow">
                        <h3 class="mb-4">Envoyez-nous un message</h3>
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Adresse email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Sujet</label>
                                    <select class="form-select" id="subject">
                                        <option value="">Sélectionnez un sujet</option>
                                        <option value="information">Demande d'information</option>
                                        <option value="permit">Demande de permis</option>
                                        <option value="study">Demande d'étude</option>
                                        <option value="complaint">Réclamation</option>
                                        <option value="other">Autre</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-logo d-flex align-items-center">
                        <img src="{{ asset('assets/img/fav.png') }}" alt="APIPA Page" class="me-3"> L'APIPA 
                        <img src="{{ asset('assets/img/fbQr.png') }}" alt="APIPA Logo" class="me-3">
                    </a>
                    <p class="mt-3 mb-4" style="color: #bbb;">veille à la sécurité des populations et des infrastructures face aux risques d'inondation.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/share/17dR3rAVPc/https://www.facebook.com/share/17dR3rAVPc/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=%2B261344427332"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Liens rapides</h5>
                    <ul class="footer-links">
                        <li><a href="#accueil">Accueil</a></li>
                        <li><a href="#apropos">À propos</a></li>
                        <li><a href="#missions">Missions</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-5 mb-md-0">
                    <h5>Services</h5>
                    <ul class="footer-links">
                        <li><a href="#services">Études techniques</a></li>
                        <li><a href="#services">Permis et autorisations</a></li>
                        <li><a href="#services">Formation et conseil</a></li>
                        <li><a href="#services">Alertes d'inondation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5>Ressources</h5>
                    <ul class="footer-links">
                        <li><a href="#">Cartes des zones à risque</a></li>
                        <li><a href="#">Rapports annuels</a></li>
                        <li><a href="#">Réglementations</a></li>
                        <li><a href="#">Publications</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>Copyright &copy; 2025 APIPA (SADEx MapPezi). Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bouton Doléance -->
    <button class="doleance-btn" data-bs-toggle="modal" data-bs-target="#doleanceModal">
        <i class="fas fa-exclamation-circle"></i>
        <span>Doléance</span>
    </button>

    <!-- Modal Doléance -->
    <div class="modal fade modal-doleance" id="doleanceModal" tabindex="-1" aria-labelledby="doleanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doleanceModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Formulaire de doléance
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Veuillez remplir ce formulaire pour nous faire part de votre doléance. Nous traiterons votre demande dans les meilleurs délais.</p>
                    
                    <form id="doleanceForm" action="{{ route('doleances.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="doleanceNom" class="form-label">Nom complet *</label>
                            <input type="text" class="form-control" id="doleanceNom" name="nom" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="doleanceContact" class="form-label">Contact (téléphone ou email) *</label>
                            <input type="text" class="form-control" id="doleanceContact" name="contact" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="doleanceSujet" class="form-label">Sujet de la doléance *</label>
                            <select class="form-select" id="doleanceSujet" name="sujet" required>
                                <option value="" selected disabled>Sélectionnez un sujet</option>
                                <option value="travaux">Travaux d'aménagement</option>
                                <option value="permis">Problème de permis</option>
                                <option value="inondation">Situation d'inondation</option>
                                <option value="infrastructure">Infrastructure défectueuse</option>
                                <option value="personnel">Problème avec le personnel</option>
                                <option value="delai">Délais non respectés</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="doleanceMessage" class="form-label">Message détaillé *</label>
                            <textarea class="form-control" id="doleanceMessage" name="message" rows="5" placeholder="Décrivez votre doléance de manière détaillée..." required></textarea>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <label class="form-check-label" for="doleanceConfidentialite">
                                Vos informations resteront confidentielles et ne seront utilisées que pour traiter votre doléance.
                            </label>
                            <hr>
                            <label class="form-check-label" for="doleanceConfidentialite">
                                Ny APIPA dia mitandro mandrakariva ny tsiambaratelon'ny mpitaraina ary tsy hampiasa ny mombamomba anao afa-tsy amin'ny fanatanterahana ny fitarainanao.
                            </label>
                            <hr>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="doleanceConfidentialite" name="accept_confidentialite" required>
                            <label class="form-check-label" for="doleanceConfidentialite">
                                J'accepte que mes données personnelles soient traitées dans le cadre de cette doléance
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-submit-doleance">
                            <i class="fas fa-paper-plane me-2"></i> Envoyer la doléance
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Animate statistics counter
        function animateCounter() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const increment = target / 200;
                let current = 0;
                
                const updateCounter = () => {
                    if(current < target) {
                        current += increment;
                        counter.innerText = Math.floor(current);
                        setTimeout(updateCounter, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                updateCounter();
            });
        }
        
        // Trigger counter animation when section is in view
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        const statsSection = document.querySelector('.stats-section');
        if(statsSection) {
            observer.observe(statsSection);
        }
        
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if(window.scrollY > 50) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.05)';
            }
        });
        
      



// Dans DoleanceController::store()
public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'sujet' => 'required|string|max:255',
        'message' => 'required|string',
        'accept_confidentialite' => 'accepted',
    ]);

    $doleance = Doleance::create($validated);

    // Retourner une réponse JSON pour les requêtes AJAX
    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Doléance enregistrée avec succès',
            'id' => $doleance->id,
            'data' => $doleance
        ], 201);
    }

    return redirect()->back()
        ->with('success', 'Votre doléance a été enregistrée avec succès. Nous vous répondrons dans les plus brefs délais.');
}



document.getElementById('doleanceForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Bouton "en cours"
    const btn = this.querySelector('button[type="submit"]');
    const btnOriginal = btn.innerHTML;
    btn.innerHTML = '⏳ Envoi...';
    btn.disabled = true;
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // SUCCÈS
            showToast('success', result.message);
            
            // Fermer modal + reset
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('doleanceModal')).hide();
                this.reset();
            }, 1500);
            
        } else {
            // ÉCHEC
            showToast('error', result.message);
        }
        
    } catch (error) {
        showToast('error', '❌ Erreur de connexion');
        console.error(error);
    } finally {
        btn.innerHTML = btnOriginal;
        btn.disabled = false;
    }
});




function showToast(type, message) {
    // Crée un toast à la volée
    const toastHTML = `
        
    `;
    
    // Ajoute au container
    document.querySelector('.toast-container').insertAdjacentHTML('beforeend', toastHTML);
    
    // Affiche
    const toast = new bootstrap.Toast(document.querySelector('.toast-container .toast:last-child'));
    toast.show();
    
    // Supprime après
    setTimeout(() => toast._element.remove(), 5000);
}

    </script>


<!-- Container pour les toasts -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999"></div>
</body>
</html>