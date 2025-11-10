<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dinas Pertanian Kabupaten Toba')</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #2e7d32;
            --secondary-green: #388e3c;
            --light-green: #4caf50;
            --dark-green: #1b5e20;
            --accent-yellow: #ffc107;
            --text-dark: #1a202c;
            --text-gray: #4a5568;
            --text-light: #718096;
            --bg-light: #f7fafc;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* === MODERN NAVBAR === */
        .navbar-modern {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar-modern.scrolled {
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
        }

        .navbar-modern .container-fluid {
            padding: 0.875rem 2rem;
        }

        .navbar-brand-modern {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-brand-modern:hover {
            transform: scale(1.02);
        }

        .navbar-logo {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: white;
            padding: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            object-fit: contain;
        }

        .navbar-logo:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
            transform: rotate(5deg);
        }

        .navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-title {
            color: white;
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .navbar-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .navbar-nav {
            gap: 0.25rem;
        }

        .nav-link-modern {
            color: white !important;
            font-weight: 500;
            padding: 0.625rem 1.25rem !important;
            margin: 0 0.15rem;
            border-radius: 30px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .nav-link-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transition: left 0.3s ease;
        }

        .nav-link-modern:hover::before {
            left: 0;
        }

        .nav-link-modern:hover,
        .nav-link-modern.active {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .nav-link-modern.active {
            font-weight: 600;
        }

        /* === MODERN BUTTONS === */
        .btn-login-modern {
            background: linear-gradient(135deg, var(--accent-yellow) 0%, #ffb300 100%) !important;
            color: var(--dark-green) !important;
            font-weight: 700;
            padding: 0.625rem 1.75rem;
            border-radius: 30px;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(255,193,7,0.3);
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .btn-login-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,193,7,0.4);
            background: linear-gradient(135deg, #ffb300 0%, var(--accent-yellow) 100%) !important;
        }

        .btn-register-modern {
            background: transparent !important;
            color: white !important;
            font-weight: 700;
            padding: 0.625rem 1.75rem;
            border-radius: 30px;
            border: 2px solid white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .btn-register-modern:hover {
            background: white !important;
            color: var(--primary-green) !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.3);
        }

        /* Mobile Toggle */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.75rem;
            height: 1.75rem;
        }

        /* === MAIN CONTENT === */
        .main-content-guest {
            min-height: calc(100vh - 80px);
        }

        /* === MODERN FOOTER === */
        .footer-modern {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            padding: 4rem 0 1.5rem;
            margin-top: 5rem;
            position: relative;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-yellow), var(--light-green), var(--accent-yellow));
        }

        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent-yellow);
            border-radius: 2px;
        }

        .footer-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-link i {
            margin-right: 0.5rem;
            width: 20px;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
        }

        .social-icon:hover {
            background: var(--accent-yellow);
            color: var(--dark-green);
            transform: translateY(-5px) rotate(10deg);
            box-shadow: 0 6px 20px rgba(255,193,7,0.4);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
        }

        .footer-bottom p {
            color: rgba(255,255,255,0.7);
            margin: 0;
            font-size: 0.9rem;
        }

        /* === RESPONSIVE === */
        @media (max-width: 992px) {
            .navbar-modern .container-fluid {
                padding: 0.75rem 1.5rem;
            }

            .navbar-title {
                font-size: 1.1rem;
            }

            .navbar-subtitle {
                font-size: 0.7rem;
            }

            .navbar-logo {
                width: 48px;
                height: 48px;
            }

            .btn-login-modern,
            .btn-register-modern {
                padding: 0.5rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-logo {
                width: 42px;
                height: 42px;
            }

            .navbar-title {
                font-size: 1rem;
            }

            .navbar-subtitle {
                font-size: 0.65rem;
            }

            .footer-modern {
                padding: 3rem 0 1rem;
            }

            .btn-login-modern,
            .btn-register-modern {
                width: 100%;
                margin-top: 0.5rem;
            }
        }

        /* === SCROLL TO TOP === */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(46,125,50,0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(46,125,50,0.4);
        }

        /* === ANIMATIONS === */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- === MODERN NAVBAR === -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo Dinas Pertanian Toba" style="height: 50px; margin-right: 12px;">
                <span class="brand-text">Dinas Pertanian Toba</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('bantuan.publik') ? 'active' : '' }}" href="{{ route('bantuan.publik') }}">
                            <i class="fas fa-hands-helping me-1"></i> Bantuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('laporan.publik') ? 'active' : '' }}" href="{{ route('laporan.publik') }}">
                            <i class="fas fa-file-alt me-1"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            <i class="fas fa-info-circle me-1"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">
                            <i class="fas fa-envelope me-1"></i> Kontak
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-dashboard-modern">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login-modern">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-register-modern">
                            <i class="fas fa-user-plus me-1"></i> Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- === KONTEN UTAMA === -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- === MODERN FOOTER === -->
    <footer class="footer-modern">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo" style="height: 45px; margin-right: 12px;">
                            <h5 class="mb-0 text-white">Dinas Pertanian</h5>
                        </div>
                        <p class="text-white-50">
                            Melayani masyarakat Kabupaten Toba dengan sepenuh hati untuk kemajuan sektor pertanian dan kesejahteraan petani.
                        </p>
                        <div class="social-icons mt-3">
                            <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h6 class="footer-title">Menu Cepat</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('home') }}"><i class="fas fa-angle-right me-1"></i> Beranda</a></li>
                            <li><a href="{{ route('bantuan.publik') }}"><i class="fas fa-angle-right me-1"></i> Bantuan</a></li>
                            <li><a href="{{ route('laporan.publik') }}"><i class="fas fa-angle-right me-1"></i> Laporan</a></li>
                            <li><a href="{{ route('tentang') }}"><i class="fas fa-angle-right me-1"></i> Tentang Kami</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h6 class="footer-title">Layanan Kami</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('bantuan.publik') }}"><i class="fas fa-angle-right me-1"></i> Pengajuan Bantuan</a></li>
                            <li><a href="{{ route('laporan.publik') }}"><i class="fas fa-angle-right me-1"></i> Laporan Masyarakat</a></li>
                            <li><a href="#"><i class="fas fa-angle-right me-1"></i> Konsultasi Online</a></li>
                            <li><a href="#"><i class="fas fa-angle-right me-1"></i> Informasi Program</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h6 class="footer-title">Hubungi Kami</h6>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. Pertanian No. 123<br>Kabupaten Toba, Sumatera Utara</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>(0632) 123-4567</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>info@distan.tobakab.go.id</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>Sen - Jum: 08:00 - 16:00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} <a href="https://distan.tobakab.go.id" target="_blank" class="footer-link-accent">Dinas Pertanian Kabupaten Toba</a>. 
                            Semua hak dilindungi.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                        <a href="#" class="footer-link me-3"><i class="fas fa-shield-alt me-1"></i> Kebijakan Privasi</a>
                        <a href="#" class="footer-link"><i class="fas fa-file-contract me-1"></i> Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modern Features JS -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-modern');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.footer-section, .main-content > *').forEach(el => {
            observer.observe(el);
        });
    </script>

    @stack('scripts')
</body>
</html>