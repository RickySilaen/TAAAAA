<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Informasi Pertanian Digital Kabupaten Toba - Platform modern untuk pengelolaan data pertanian">
    <meta name="keywords" content="pertanian, toba, bantuan pertanian, laporan panen, dinas pertanian">

    <title>@yield('title', 'Dinas Pertanian Kabupaten Toba - Platform Digital Pertanian Modern')</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}">

    <!-- Google Fonts - Poppins & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6.5 - CDN Primary -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Font Awesome 6.5 - Local Fallback -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-local.css') }}">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon Fix CSS -->
    <link rel="stylesheet" href="{{ asset('css/icon-fix.css') }}">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Particles.js for background effects -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    @stack('styles')

    <style>
        /* ===== MODERN CSS VARIABLES ===== */
        :root {
            /* Colors */
            --primary-green: #2e7d32;
            --secondary-green: #388e3c;
            --dark-green: #1b5e20;
            --light-green: #4caf50;
            --accent-yellow: #ffc107;
            --accent-orange: #ff9800;
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
            --gradient-secondary: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            --gradient-accent: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            --gradient-overlay: linear-gradient(135deg, rgba(46, 125, 50, 0.95) 0%, rgba(27, 94, 32, 0.98) 100%);
            
            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
            --shadow-xl: 0 12px 48px rgba(0,0,0,0.15);
            --shadow-glow: 0 0 20px rgba(46, 125, 50, 0.3);
            
            /* Spacing */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 2rem;
            --spacing-lg: 3rem;
            --spacing-xl: 5rem;
            
            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 30px;
            --radius-full: 50px;
            
            /* Typography */
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Inter', sans-serif;
            
            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }

        /* ===== GLOBAL STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-secondary);
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            color: #2d3748;
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-primary);
            font-weight: 700;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition-normal);
        }
        
        /* ===== FORCE FONT AWESOME ICONS ===== */
        .fas, .far, .fab, .fa, .fa-solid, .fa-regular, .fa-brands,
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
            font-style: normal !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .fas, .fa-solid, .fa {
            font-weight: 900 !important;
        }
        
        .far, .fa-regular {
            font-weight: 400 !important;
        }
        
        .fab, .fa-brands {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400 !important;
        }

        /* ===== MODERN NAVBAR ===== */
        .navbar-ultra-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(46, 125, 50, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all var(--transition-normal);
        }

        .navbar-ultra-modern.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-md);
            padding: 0.75rem 0;
        }

        .navbar-brand-modern {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-green);
            gap: 12px;
            transition: var(--transition-normal);
        }

        .navbar-brand-modern:hover {
            transform: scale(1.02);
            color: var(--dark-green);
        }

        .navbar-brand-modern img {
            height: 50px;
            filter: drop-shadow(0 2px 8px rgba(46, 125, 50, 0.2));
            transition: var(--transition-normal);
        }

        .navbar-brand-modern:hover img {
            transform: rotate(-5deg) scale(1.05);
        }

        .brand-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .nav-link-ultra-modern {
            color: #4a5568;
            font-weight: 500;
            padding: 0.75rem 1.25rem !important;
            margin: 0 0.25rem;
            border-radius: var(--radius-full);
            position: relative;
            transition: var(--transition-normal);
            font-size: 0.95rem;
        }

        .nav-link-ultra-modern::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gradient-primary);
            transform: translateX(-50%);
            transition: width var(--transition-normal);
            border-radius: 10px;
        }

        .nav-link-ultra-modern:hover,
        .nav-link-ultra-modern.active {
            color: var(--primary-green);
            background: rgba(46, 125, 50, 0.05);
        }

        .nav-link-ultra-modern:hover::before,
        .nav-link-ultra-modern.active::before {
            width: 60%;
        }

        .nav-link-ultra-modern i {
            margin-right: 6px;
            font-size: 0.9rem;
        }

        /* ===== MODERN BUTTONS ===== */
        .btn-login-ultra-modern {
            background: var(--gradient-accent);
            color: #000;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: var(--radius-full);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
            transition: all var(--transition-normal);
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .btn-login-ultra-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login-ultra-modern:hover::before {
            left: 100%;
        }

        .btn-login-ultra-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.5);
            color: #000;
        }

        .btn-register-ultra-modern {
            background: transparent;
            color: var(--primary-green);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: var(--radius-full);
            border: 2px solid var(--primary-green);
            transition: all var(--transition-normal);
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .btn-register-ultra-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--primary-green);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
            z-index: 0;
        }

        .btn-register-ultra-modern span {
            position: relative;
            z-index: 1;
        }

        .btn-register-ultra-modern:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-register-ultra-modern:hover {
            color: #fff;
            border-color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
        }

        .btn-dashboard-ultra-modern {
            background: var(--gradient-primary);
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: var(--radius-full);
            border: none;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
            transition: all var(--transition-normal);
            font-size: 0.95rem;
        }

        .btn-dashboard-ultra-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
            color: #fff;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            min-height: calc(100vh - 80px);
            margin-top: 80px;
            padding: var(--spacing-md) 0;
        }

        /* ===== ULTRA MODERN FOOTER ===== */
        .footer-ultra-modern {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
            color: #fff;
            padding: 4rem 0 2rem;
            position: relative;
            overflow: hidden;
        }

        .footer-ultra-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
        }

        .footer-ultra-modern::after {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .footer-section {
            position: relative;
            z-index: 1;
        }

        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #fff;
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
            border-radius: 10px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.85);
            transition: var(--transition-normal);
            display: inline-flex;
            align-items: center;
        }

        .footer-links a i,
        .footer-links a i.fas {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            visibility: visible !important;
            display: inline-block !important;
            margin-right: 8px;
            color: rgba(255,255,255,0.7);
        }

        .footer-links a:hover {
            color: var(--accent-yellow);
            transform: translateX(5px);
        }

        .footer-links a:hover i {
            color: var(--accent-yellow);
        }

        .footer-contact {
            list-style: none;
            padding: 0;
        }

        .footer-contact li {
            margin-bottom: 1rem;
            display: flex;
            align-items: start;
            color: rgba(255,255,255,0.85);
        }

        .footer-contact i {
            color: var(--accent-yellow);
            margin-right: 12px;
            margin-top: 4px;
            font-size: 1.1rem;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            visibility: visible !important;
            display: inline-block !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all var(--transition-normal);
            backdrop-filter: blur(10px);
        }

        .social-icon i,
        .social-icon i.fab,
        .social-icon i.fa-brands {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400 !important;
            font-size: 1.2rem !important;
            color: #fff !important;
            visibility: visible !important;
            display: inline-block !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .social-icon:hover {
            background: var(--accent-yellow);
            color: #000;
            transform: translateY(-5px) rotate(10deg);
            box-shadow: 0 8px 20px rgba(255,193,7,0.4);
        }

        .social-icon:hover i {
            color: #000 !important;
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }

        .footer-link-accent {
            color: var(--accent-yellow);
            font-weight: 600;
        }

        .footer-link-accent:hover {
            color: #fff;
            text-decoration: underline;
        }

        .footer-link {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            transition: var(--transition-normal);
        }

        .footer-link:hover {
            color: var(--accent-yellow);
        }

        /* ===== SCROLL TO TOP BUTTON ===== */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 55px;
            height: 55px;
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: scale(0);
            transition: all var(--transition-normal);
            box-shadow: 0 4px 20px rgba(46, 125, 50, 0.3);
            z-index: 999;
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .scroll-to-top:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 6px 25px rgba(46, 125, 50, 0.5);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(46, 125, 50, 0.3); }
            50% { box-shadow: 0 0 40px rgba(46, 125, 50, 0.6); }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 991px) {
            .navbar-ultra-modern {
                padding: 0.75rem 0;
            }
            
            .nav-link-ultra-modern {
                margin: 0.25rem 0;
            }
            
            .btn-login-ultra-modern,
            .btn-register-ultra-modern,
            .btn-dashboard-ultra-modern {
                width: 100%;
                margin: 0.5rem 0;
            }
        }

        @media (max-width: 768px) {
            :root {
                --spacing-md: 1.5rem;
                --spacing-lg: 2rem;
                --spacing-xl: 3rem;
            }

            .brand-text {
                font-size: 0.95rem;
            }

            .navbar-brand-modern img {
                height: 40px;
            }

            .footer-ultra-modern {
                padding: 3rem 0 1.5rem;
            }

            .scroll-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand-modern {
                font-size: 1rem;
            }

            .brand-text {
                display: none;
            }

            .nav-link-ultra-modern {
                font-size: 0.9rem;
                padding: 0.5rem 1rem !important;
            }
        }

        /* ===== UTILITY CLASSES ===== */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: transform var(--transition-normal);
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .shadow-modern {
            box-shadow: var(--shadow-md);
        }

        .shadow-modern:hover {
            box-shadow: var(--shadow-lg);
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ===== ULTRA MODERN NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-ultra-modern">
        <div class="container">
            <a class="navbar-brand-modern" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo Dinas Pertanian Toba">
                <span class="brand-text">Dinas Pertanian Toba</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-success"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('bantuan.publik') ? 'active' : '' }}" href="{{ route('bantuan.publik') }}">
                            <i class="fas fa-hands-helping"></i> Bantuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('laporan.publik') ? 'active' : '' }}" href="{{ route('laporan.publik') }}">
                            <i class="fas fa-file-alt"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('transparansi.bantuan*') ? 'active' : '' }}" href="{{ route('transparansi.bantuan') }}">
                            <i class="fas fa-eye"></i> Transparansi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita') }}">
                            <i class="fas fa-newspaper"></i> Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            <i class="fas fa-info-circle"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-ultra-modern {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">
                            <i class="fas fa-envelope"></i> Kontak
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-dashboard-ultra-modern">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login-ultra-modern">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-register-ultra-modern">
                            <span><i class="fas fa-user-plus me-1"></i> Daftar</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ===== ULTRA MODERN FOOTER ===== -->
    <footer class="footer-ultra-modern">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <div class="d-flex align-items-center mb-4">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 8px; padding: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo" style="max-height: 40px; max-width: 40px; object-fit: contain;">
                            </div>
                            <h5 class="mb-0 text-white fw-bold">Dinas Pertanian<br>Kabupaten Toba</h5>
                        </div>
                        <p class="text-white-50 mb-4">
                            Platform digital modern untuk pengelolaan sistem informasi pertanian, mendukung kemajuan sektor pertanian dan kesejahteraan petani Kabupaten Toba.
                        </p>
                        <div class="social-icons">
                            <a href="#" class="social-icon" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h6 class="footer-title">Menu Cepat</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('home') }}"><i class="fas fa-angle-right me-2"></i> Beranda</a></li>
                            <li><a href="{{ route('bantuan.publik') }}"><i class="fas fa-angle-right me-2"></i> Bantuan</a></li>
                            <li><a href="{{ route('laporan.publik') }}"><i class="fas fa-angle-right me-2"></i> Laporan</a></li>
                            <li><a href="{{ route('tentang') }}"><i class="fas fa-angle-right me-2"></i> Tentang Kami</a></li>
                            <li><a href="{{ route('kontak') }}"><i class="fas fa-angle-right me-2"></i> Kontak</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h6 class="footer-title">Layanan Kami</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('bantuan.publik') }}"><i class="fas fa-angle-right me-2"></i> Pengajuan Bantuan</a></li>
                            <li><a href="{{ route('laporan.publik') }}"><i class="fas fa-angle-right me-2"></i> Laporan Hasil Panen</a></li>
                            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Konsultasi Online</a></li>
                            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Informasi Program</a></li>
                            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Data & Statistik</a></li>
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
                                <span>Jl. Pertanian No. 123<br>Kabupaten Toba, Sumatera Utara 22312</span>
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
                                <span>Senin - Jumat<br>08:00 - 16:00 WIB</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} <a href="https://distan.tobakab.go.id" target="_blank" class="footer-link-accent">Dinas Pertanian Kabupaten Toba</a>. 
                            Semua hak dilindungi.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Modern Features JavaScript -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar-ultra-modern');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
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
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Auto close navbar on mobile when clicking a link
        const navLinks = document.querySelectorAll('.nav-link-ultra-modern');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    navbarCollapse.classList.remove('show');
                }
            });
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s';
                document.body.style.opacity = '1';
            }, 100);
        });

        // Parallax effect for footer
        window.addEventListener('scroll', () => {
            const footer = document.querySelector('.footer-ultra-modern');
            const scrolled = window.pageYOffset;
            const coords = -(scrolled * 0.3) + 'px';
            if (footer) {
                footer.style.backgroundPositionY = coords;
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
