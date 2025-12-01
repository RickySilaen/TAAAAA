<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dinas Pertanian Kabupaten Toba')</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6.5 - Local Version -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-local.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <!-- Modern Style -->
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    
    <!-- Icon Fix CSS -->
    <link rel="stylesheet" href="{{ asset('css/icon-fix.css') }}">

    <style>
        :root {
            --primary-green: #2e7d32;
            --secondary-green: #388e3c;
            --light-green: #4caf50;
            --dark-green: #1b5e20;
            --yellow: #ffc107;
            --text-dark: #1a202c;
            --text-gray: #4a5568;
        }
        
        /* Force Font Awesome Icons */
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

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Navbar Modern */
        .navbar-modern {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar-modern .container-fluid {
            padding: 0.75rem 2rem;
        }

        .navbar-brand-modern {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .navbar-logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: white;
            padding: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .navbar-logo:hover {
            transform: scale(1.05);
        }

        .navbar-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .navbar-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 0.75rem;
            margin: 0;
        }

        .nav-link-modern {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem !important;
            margin: 0 0.25rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link-modern:hover,
        .nav-link-modern.active {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .btn-login-modern {
            background: var(--yellow) !important;
            color: var(--dark-green) !important;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255,193,7,0.3);
        }

        .btn-login-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255,193,7,0.4);
        }

        .btn-register-modern {
            background: transparent !important;
            color: white !important;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .btn-register-modern:hover {
            background: white !important;
            color: var(--primary-green) !important;
            transform: translateY(-2px);
        }

        /* Main Content */
        .main-content-public {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Footer Modern */
        .footer-modern {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: white;
            color: var(--primary-green);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 1.5rem;
            margin-top: 2rem;
            text-align: center;
            color: rgba(255,255,255,0.7);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-modern .container-fluid {
                padding: 0.75rem 1rem;
            }

            .navbar-title {
                font-size: 1rem;
            }

            .navbar-subtitle {
                font-size: 0.65rem;
            }

            .navbar-logo {
                width: 40px;
                height: 40px;
            }

            .main-content-public {
                margin-top: 70px;
            }
        }

        /* Navbar Toggle */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-modern navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand-modern" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" 
                     alt="Logo" 
                     class="navbar-logo"
                     onerror="this.src='https://ui-avatars.com/api/?name=Dinas+Pertanian&background=2e7d32&color=fff'">
                <div>
                    <div class="navbar-title">Dinas Pertanian Toba</div>
                    <div class="navbar-subtitle">Kabupaten Toba Samosir</div>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            <i class="fas fa-info-circle me-1"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('bantuan.publik') ? 'active' : '' }}" href="{{ route('bantuan.publik') }}">
                            <i class="fas fa-hand-holding-heart me-1"></i> Bantuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('laporan.publik') ? 'active' : '' }}" href="{{ route('laporan.publik') }}">
                            <i class="fas fa-chart-line me-1"></i> Laporan
                        </a>
                    </li>
                    @if(isset($showBerita) && $showBerita)
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('berita') ? 'active' : '' }}" href="{{ route('berita') }}">
                            <i class="fas fa-newspaper me-1"></i> Berita
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">
                            <i class="fas fa-envelope me-1"></i> Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content-public">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-modern">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo Dinas Pertanian Kabupaten Toba" class="footer-logo me-3" style="height: 50px; width: auto; background: white; padding: 5px; border-radius: 5px;">
                        <h5 class="footer-title mb-0">Dinas Pertanian<br>Kabupaten Toba</h5>
                    </div>
                    <p class="text-white-50">
                        Platform digital modern untuk pengelolaan sistem informasi pertanian, mendukung kemajuan sektor pertanian dan kesejahteraan petani Kabupaten Toba.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Menu</h6>
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('tentang') }}" class="footer-link">Tentang Kami</a>
                    <a href="{{ route('bantuan.publik') }}" class="footer-link">Program Bantuan</a>
                    <a href="{{ route('laporan.publik') }}" class="footer-link">Laporan Panen</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Layanan</h6>
                    <a href="{{ route('login') }}" class="footer-link">Login Sistem</a>
                    <a href="{{ route('register') }}" class="footer-link">Registrasi Petani</a>
                    <a href="{{ route('kontak') }}" class="footer-link">Hubungi Kami</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Kontak</h6>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Jl. Sisingamangaraja, Balige<br>
                        Kabupaten Toba Samosir
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-phone me-2"></i>
                        (0632) 21234
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        distan@tobakab.go.id
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Dinas Pertanian Kabupaten Toba. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Modern Features JS -->
    <script src="{{ asset('js/modern-features.js') }}"></script>

    @stack('scripts')
</body>
</html>
