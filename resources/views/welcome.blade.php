<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selena | Event Tracking & Compliance</title>
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
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#solutions">Solutions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
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
                    <h1 class="display-4 fw-bold mb-4">Advanced Event Tracking & Compliance</h1>
                    <p class="lead mb-5">Selena provides comprehensive event monitoring and compliance solutions to help your business stay secure and audit-ready.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#demo" class="btn btn-primary">Request Demo</a>
                        <a href="#features" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="dashboard.jpg" alt="Selena Dashboard" class="img-fluid dashboard-preview">
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
                        <p class="mb-0">Compliance Accuracy</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">24/7</div>
                        <p class="mb-0">Real-time Monitoring</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">500+</div>
                        <p class="mb-0">Enterprise Clients</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-number">30+</div>
                        <p class="mb-0">Compliance Standards</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Powerful Features</h2>
                    <p class="lead text-muted">Selena offers a comprehensive suite of tools to monitor, track, and ensure compliance across your organization.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Real-time Alerts</h4>
                        <p>Get instant notifications for suspicious activities or compliance violations as they happen.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Advanced Analytics</h4>
                        <p>Comprehensive dashboards and reports to analyze event patterns and compliance status.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h4>Audit Trails</h4>
                        <p>Detailed, tamper-proof logs of all system events for compliance and forensic analysis.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4>Access Control</h4>
                        <p>Granular permission management to ensure proper access to sensitive data and systems.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h4>Automated Workflows</h4>
                        <p>Streamline compliance processes with customizable automated workflows and approvals.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <h4>Cloud & On-Premise</h4>
                        <p>Flexible deployment options to meet your organization's infrastructure requirements.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="compliance.png" alt="Compliance Solution" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">End-to-End Compliance Solutions</h2>
                    <p class="lead mb-4">Selena simplifies complex compliance requirements with automated tracking and reporting.</p>
                    
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Regulatory Compliance</h5>
                            <p class="text-muted">Stay compliant with GDPR, HIPAA, SOC 2, ISO 27001, and other major regulations.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Custom Policy Management</h5>
                            <p class="text-muted">Define and enforce your organization's specific policies with customizable rules.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="feature-icon" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Risk Assessment</h5>
                            <p class="text-muted">Identify and mitigate potential risks before they become compliance issues.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Trusted by Industry Leaders</h2>
                    <p class="lead text-muted">Don't just take our word for it. Here's what our customers say about Selena.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">Selena has transformed our compliance processes. What used to take weeks now takes hours, and our audit readiness has improved dramatically.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Chief Compliance Officer, FinCorp</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">The real-time alerts and detailed reporting have been game-changers for our security team. We've identified and resolved issues faster than ever before.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Michael Chen</h6>
                                <small class="text-muted">IT Director, TechGlobal</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <p class="mb-4">Implementing Selena helped us pass our SOC 2 audit with zero findings. The platform's documentation capabilities are exceptional.</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Client" class="client-img me-3">
                            <div>
                                <h6 class="mb-0">Emily Rodriguez</h6>
                                <small class="text-muted">Security Manager, HealthSecure</small>
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
                    <h2 class="fw-bold mb-4">Ready to Transform Your Compliance Process?</h2>
                    <p class="lead mb-5">Join thousands of organizations who trust Selena for their event tracking and compliance needs.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#demo" class="btn btn-light btn-lg">Request a Demo</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg">Contact Sales</a>
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
                    <p>Advanced event tracking and compliance solutions for modern enterprises.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Product</h5>
                    <div class="footer-links">
                        <a href="#features">Features</a>
                        <a href="#solutions">Solutions</a>
                        <a href="#pricing">Pricing</a>
                        <a href="#demo">Demo</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Resources</h5>
                    <div class="footer-links">
                        <a href="#">Documentation</a>
                        <a href="#">Guides</a>
                        <a href="#">Blog</a>
                        <a href="#">Support</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-4">Company</h5>
                    <div class="footer-links">
                        <a href="#">About Us</a>
                        <a href="#">Careers</a>
                        <a href="#">Partners</a>
                        <a href="#">Contact</a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="text-white mb-4">Legal</h5>
                    <div class="footer-links">
                        <a href="#">Privacy</a>
                        <a href="#">Terms</a>
                        <a href="#">Compliance</a>
                        <a href="{{ route('login') }}" id="login">Login</a>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-4" style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2023 Selena. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Designed with <i class="fas fa-heart text-danger"></i> for compliance professionals</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Navbar scroll effect
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