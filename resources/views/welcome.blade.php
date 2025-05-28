<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selena | Suivi d'Événements & Conformité</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6c63ff;
            --secondary-color: #4d44db;
            --dark-color: #2f2e41;
            --light-color: #f8f9fa;
            --accent-color: #ff6584;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
            overflow-x: hidden;
        }

        .navbar {
            padding: 20px 0;
            transition: all 0.3s;
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .hero-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background-color: rgba(108, 99, 255, 0.1);
            border-radius: 50%;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background-color: rgba(108, 99, 255, 0.1);
            border-radius: 50%;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(108, 99, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--primary-color);
            font-size: 24px;
        }

        .feature-card {
            padding: 30px;
            border-radius: 15px;
            transition: all 0.3s;
            height: 100%;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .dashboard-preview {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: all 0.5s;
            border: 15px solid white;
        }

        .dashboard-preview:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0);
        }

        .stats-card {
            padding: 30px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stats-number {
            font-size: 48px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .testimonial-card {
            padding: 30px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 60px;
            color: rgba(108, 99, 255, 0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .client-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
            display: block;
            margin-bottom: 10px;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: var(--primary-color);
            transform: translateY(-5px);
        }
        .safety-score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(var(--primary-color) 0% 75%, #ddd 75% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: var(--dark-color);
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color: var(--primary-color); font-size: 24px;">
                <i class="fas fa-shield-alt me-2"></i>Selena
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#fonctionnalites">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#solutions">Solutions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tarifs">Tarifs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#temoignages">Témoignages</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary" href="{{route('login')}}">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Suivi Avancé des Événements & Conformité</h1>
                    <p class="lead mb-5">Selena offre des solutions complètes de suivi d'événements et de conformité pour garantir la sécurité et la préparation aux audits de votre entreprise.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#demo" class="btn btn-primary">Demander une Démo</a>
                        <a href="#fonctionnalites" class="btn btn-outline-primary">En Savoir Plus</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="dashboard.jpg" alt="Tableau de Bord Selena" class="img-fluid dashboard-preview">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">98%</div>
                        <p class="mb-0">Précision de la Conformité</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">24/7</div>
                        <p class="mb-0">Surveillance en Temps Réel</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">500+</div>
                        <p class="mb-0">Clients Entreprises</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">30+</div>
                        <p class="mb-0">Normes de Conformité</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Fonctionnalités Puissantes</h2>
                    <p class="lead text-muted">Selena propose une suite complète d'outils pour surveiller, suivre et garantir la conformité dans votre organisation.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Alertes en Temps Réel</h4>
                        <p>Recevez des notifications instantanées pour les activités suspectes ou les violations de conformité dès qu'elles se produisent.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Analytique Avancée</h4>
                        <p>Tableaux de bord et rapports complets pour analyser les tendances des événements et l'état de conformité.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h4>Pistes d'Audit</h4>
                        <p>Journaux détaillés et inviolables de tous les événements du système pour la conformité et l'analyse forensique.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4>Contrôle d'Accès</h4>
                        <p>Gestion granulaire des autorisations pour garantir un accès approprié aux données et systèmes sensibles.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h4>Flux de Travail Automatisés</h4>
                        <p>Simplifiez les processus de conformité avec des flux de travail automatisés et personnalisables.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <h4>Cloud & Sur Site</h4>
                        <p>Options de déploiement flexibles pour répondre aux besoins d'infrastructure de votre organisation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Safety Score Visualization Section -->
    <section id="safety-score" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="checklist-work-initiation.jpg" alt="Checklist d'Initiation du Travail" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Score de Sécurité pour l'Initiation du Travail</h2>
                    <p class="lead mb-4">Validez la sécurité des opérations avec des checklists dynamiques et un score de sécurité en temps réel.</p>
                    <div class="safety-score-circle mb-4">75%</div>
                    <p class="text-muted">Un score de sécurité ≥75% garantit un <strong>Feu Vert Sécuritaire</strong> pour démarrer les travaux. En cas de score inférieur, des actions correctives sont automatiquement assignées.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="compliance.png" alt="Solution de Conformité" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Solutions de Conformité de Bout en Bout</h2>
                    <p class="lead mb-4">Selena simplifie les exigences complexes de conformité grâce à un suivi et des rapports automatisés.</p>

                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Conformité Réglementaire</h5>
                            <p class="text-muted">Restez conforme aux normes GDPR, HIPAA, SOC 2, ISO 27001 et autres réglementations majeures.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Gestion de Politiques Personnalisées</h5>
                            <p class="text-muted">Définissez et appliquez les politiques spécifiques de votre organisation avec des règles personnalisables.</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Évaluation des Risques</h5>
                            <p class="text-muted">Identifiez et atténuez les risques potentiels avant qu'ils ne deviennent des problèmes de conformité.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="temoignages" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Approuvé par les Leaders de l'Industrie</h2>
                    <p class="lead text-muted">Ne nous croyez pas sur parole. Voici ce que nos clients disent de Selena.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">Selena a transformé nos processus de conformité. Ce qui prenait des semaines ne prend plus que quelques heures, et notre préparation aux audits s'est considérablement améliorée.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Responsable de la Conformité, FinCorp</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">Les alertes en temps réel et les rapports détaillés ont été des changements majeurs pour notre équipe de sécurité. Nous avons identifié et résolu les problèmes plus rapidement que jamais.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Michael Chen</h6>
                                <small class="text-muted">Directeur Informatique, TechGlobal</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">L'implémentation de Selena nous a permis de passer notre audit SOC 2 sans aucune observation. Les capacités de documentation de la plateforme sont exceptionnelles.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Emily Rodriguez</h6>
                                <small class="text-muted">Responsable de la Sécurité, HealthSecure</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-4">Prêt à Transformer Votre Processus de Conformité ?</h2>
                    <p class="lead mb-5">Rejoignez des milliers d'organisations qui font confiance à Selena pour leurs besoins en suivi d'événements et conformité.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#demo" class="btn btn-light btn-lg">Demander une Démo</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg">Contacter les Ventes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-shield-alt me-2"></i>Selena
                    </h4>
                    <p>Solutions avancées de suivi d'événements et de conformité pour les entreprises modernes.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Produit</h5>
                    <div class="footer-links">
                        <a href="#fonctionnalites">Fonctionnalités</a>
                        <a href="#solutions">Solutions</a>
                        <a href="#tarifs">Tarifs</a>
                        <a href="#demo">Démo</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Ressources</h5>
                    <div class="footer-links">
                        <a href="#">Documentation</a>
                        <a href="#">Guides</a>
                        <a href="#">Blog</a>
                        <a href="#">Support</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Entreprise</h5>
                    <div class="footer-links">
                        <a href="#">À Propos</a>
                        <a href="#">Carrières</a>
                        <a href="#">Partenaires</a>
                        <a href="#">Contact</a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="text-white mb-4">Légal</h5>
                    <div class="footer-links">
                        <a href="#">Confidentialité</a>
                        <a href="#">Conditions</a>
                        <a href="#">Conformité</a>
                        <a href="https://selena.quibblebyte.com/login" id="login">Connexion</a>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-4" style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2023 Selena. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Conçu avec <i class="fas fa-heart text-danger"></i> pour les professionnels de la conformité</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Effet de défilement de la barre de navigation
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
