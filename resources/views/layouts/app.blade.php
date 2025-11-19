<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Bantuan Pertanian - Dinas Pertanian Kabupaten Toba')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modern Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/modern-navbar-sidebar.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-modern.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-enhancements.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/icon-fix.css') }}?v={{ time() }}">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SVG Icon Replacer - AUTO REPLACE ALL FONTAWESOME ICONS -->
    <script src="{{ asset('js/svg-icon-replacer.js') }}"></script>
    
    <!-- Icon Debug & Fix -->
    <script src="{{ asset('js/icon-debug.js') }}"></script>
    
    <!-- Dashboard JS -->
    <script src="{{ asset('js/dashboard-enhanced.js') }}" defer></script>
    <script src="{{ asset('js/dashboard-modern.js') }}" defer></script>
    <script src="{{ asset('js/dashboard-interactive.js') }}" defer></script>

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-dark: #2D3748;
            --sidebar-white: #FFFFFF;
            --text-gray: #4A5568;
            --moss-green: #38A169;
            --leaf-green: #48BB78;
            --toba-purple: #6B46C1;
            --earth-brown: #8B5E3C;
            --chart-blue: #63B3ED;
            --chart-yellow: #F6E05E;
            --chart-orange: #ED8936;
            --light-bg: #F7FAFC;
            --border-color: #E2E8F0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        .main-header {
            background-color: var(--primary-dark);
            color: white;
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 70px;
        }

        .main-header .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .main-header .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .main-header .navbar-toggler {
            border: none;
            color: white;
        }

        .main-header .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .search-box {
            position: relative;
            max-width: 300px;
            margin: 0 auto;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: none;
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box .fa-search {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            margin-right: 1rem;
        }

        .notification-bell .fa-bell {
            font-size: 1.2rem;
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #EF4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-menu .dropdown-toggle::after {
            color: white;
        }

        .user-menu .dropdown-menu {
            border: none;
            box-shadow: var(--shadow);
            margin-top: 0.5rem;
        }

        /* Sidebar Styles - Enhanced Responsive */
        .sidebar,
        .modern-sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            background-color: var(--sidebar-white);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar,
        .modern-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track,
        .modern-sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb,
        .modern-sidebar::-webkit-scrollbar-thumb {
            background: rgba(107, 70, 193, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover,
        .modern-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(107, 70, 193, 0.5);
        }

        .sidebar.collapsed,
        .modern-sidebar.collapsed {
            transform: translateX(-100%);
        }

        /* Sidebar Backdrop for Mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--leaf-green);
            color: white;
        }

        .sidebar-header h6 {
            margin: 0;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-item {
            margin: 0.25rem 0;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--text-gray);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin: 0 0.5rem 0 0;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--moss-green);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-menu .nav-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar-menu .nav-link:hover {
            background-color: rgba(72, 187, 120, 0.1);
            color: var(--moss-green);
            transform: translateX(5px);
        }

        .sidebar-menu .nav-link.active {
            background-color: var(--moss-green);
            color: white;
            font-weight: 600;
        }

        .sidebar-menu .nav-link.active::before {
            transform: scaleY(1);
            background: white;
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            background-color: var(--sidebar-white);
        }

        .sidebar-footer .nav-link {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        .sidebar-footer .nav-link:hover {
            color: #EF4444;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .sidebar,
            .modern-sidebar {
                transform: translateX(-100%);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
            }

            .sidebar.show,
            .modern-sidebar.show {
                transform: translateX(0);
            }

            /* Touch-friendly menu items */
            .sidebar-menu .nav-link,
            .sidebar-menu-link {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }

            /* Sticky sidebar header on mobile */
            .sidebar-header,
            .sidebar-header-modern {
                position: sticky;
                top: 0;
                z-index: 1001;
            }
        }

        @media (max-width: 576px) {
            .sidebar,
            .modern-sidebar {
                width: 85%;
                max-width: 300px;
            }
        }

        /* Main Content - Enhanced Responsive */
        .main-content,
        .main-content-modern {
            margin-left: 280px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .main-content.expanded,
        .main-content-modern.expanded {
            margin-left: 0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content,
            .main-content-modern {
                margin-left: 0;
                padding: 1.5rem;
            }

            .main-content.expanded,
            .main-content-modern.expanded {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .main-content,
            .main-content-modern {
                padding: 1rem;
            }
        }

        /* Cards and Panels */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .card-header-agriculture {
            background: linear-gradient(135deg, var(--leaf-green), var(--moss-green));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-header-agriculture h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Buttons */
        .btn-agriculture {
            background: linear-gradient(135deg, var(--toba-purple), var(--moss-green));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-agriculture:hover {
            background: linear-gradient(135deg, var(--moss-green), var(--leaf-green));
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
        }

        .btn-secondary-agriculture {
            background-color: var(--earth-brown);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-agriculture:hover {
            background-color: #6B4423;
            transform: translateY(-2px);
        }

        /* Tab Buttons */
        .tab-button {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .tab-button.active {
            background: linear-gradient(135deg, var(--moss-green), var(--leaf-green)) !important;
            color: white !important;
            border-color: var(--moss-green) !important;
            box-shadow: 0 2px 8px rgba(56, 178, 172, 0.3);
        }

        .tab-button.active i {
            color: white !important;
        }

        /* Tables */
        .table-agriculture {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-agriculture thead th {
            background-color: var(--leaf-green);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table-agriculture tbody tr:nth-child(even) {
            background-color: #F8F9FA;
        }

        .table-agriculture tbody tr:hover {
            background-color: rgba(72, 187, 120, 0.05);
        }

        .table-agriculture td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-sent {
            background-color: rgba(34, 197, 94, 0.1);
            color: #16A34A;
        }

        .status-processing {
            background-color: rgba(239, 68, 68, 0.1);
            color: #DC2626;
        }

        /* Avatar Styles */
        .avatar {
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar.avatar-xs {
            width: 32px;
            height: 32px;
        }

        .avatar.avatar-sm {
            width: 40px;
            height: 40px;
        }

        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
        }

        .badge.badge-sm {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        /* Button Group Styles */
        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin: 0 1px;
        }

        .btn-group .btn:first-child {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .btn-group .btn:last-child {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-state i {
            opacity: 0.5;
        }

        /* Modal Styles */
        .modal-header.bg-gradient-info {
            background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%) !important;
            border: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        /* Card Hover Effects */
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
            margin: 2rem 0;
        }

        /* Agricultural Theme Colors */
        .agricultural-primary {
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
        }
        .agricultural-secondary {
            background: linear-gradient(135deg, #8D6E63, #A1887F);
        }
        .agricultural-accent {
            background: linear-gradient(135deg, #FFD54F, #FFEB3B);
        }

        /* Notification Panel */
        .notification-panel {
            position: fixed;
            top: 90px;
            right: 20px;
            width: 350px;
            max-height: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            z-index: 1100;
            display: none;
        }

        .notification-panel.show {
            display: block;
        }

        .notification-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--leaf-green);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .notification-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #F8F9FA;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .search-box {
                display: none;
            }

            .notification-panel {
                width: calc(100vw - 40px);
                right: 10px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-header {
                height: 60px;
                padding: 0.5rem 0;
            }

            .main-content {
                margin-top: 60px;
                padding: 1rem;
            }

            .sidebar {
                width: 250px;
            }

            .btn-agriculture, .btn-secondary-agriculture {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--leaf-green);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--moss-green);
        }
    </style>
</head>

<body>
    <!-- Modern Navbar -->
    <nav class="modern-navbar">
        <div class="navbar-container">
            <!-- Sidebar Toggle -->
            <button class="sidebar-toggle-btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-logo">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="brand-text">
                    <div class="brand-title">Dinas Pertanian Toba</div>
                    <div class="brand-subtitle">Sistem Informasi Pertanian</div>
                </div>
            </a>

            <!-- Search Box -->
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="globalSearch" placeholder="Cari data, laporan, bantuan...">
                    <button class="search-clear" id="searchClear">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Navbar Actions -->
            <div class="navbar-actions">
                @auth
                <!-- Notification Bell -->
                <div class="notification-container">
                    <button class="notification-btn" id="notificationToggle">
                        <i class="fas fa-bell"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </button>
                </div>

                <!-- User Menu -->
                <div class="user-menu-container dropdown">
                    <button class="user-menu-btn" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->role }}</div>
                        </div>
                        <i class="fas fa-chevron-down user-menu-arrow"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i>Profil Saya
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('notifications.index') }}">
                            <i class="fas fa-bell me-2"></i>Notifikasi
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Sidebar Backdrop (for mobile) -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Modern Sidebar -->
    <div class="modern-sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header-modern">
            <h6>MENU NAVIGASI</h6>
            @auth
            <div class="user-welcome">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</div>
            @endauth
        </div>

        <!-- Sidebar Menu -->
        <nav class="sidebar-menu-modern">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <!-- Admin Menu -->
                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">DASHBOARD</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <span class="sidebar-menu-text">Dashboard</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">MANAJEMEN USER</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}" href="{{ route('admin.petugas.index') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <span class="sidebar-menu-text">Kelola Petugas</span>
                            @php
                                $total_petugas = \App\Models\User::where('role', 'petugas')->count();
                            @endphp
                            @if($total_petugas > 0)
                                <span class="sidebar-badge badge-info">{{ $total_petugas }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('admin.petani.*') ? 'active' : '' }}" href="{{ route('admin.petani.index') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="sidebar-menu-text">Kelola Petani</span>
                            @php
                                $total_petani = \App\Models\User::where('role', 'petani')->count();
                                $petani_pending = \App\Models\User::where('role', 'petani')->where('is_verified', false)->count();
                            @endphp
                            @if($total_petani > 0)
                                <span class="sidebar-badge badge-success">{{ $total_petani }}</span>
                            @endif
                            @if($petani_pending > 0)
                                <span class="sidebar-badge badge-warning">{{ $petani_pending }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">DATA & LAPORAN</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('input.data') ? 'active' : '' }}" href="{{ route('input.data') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="sidebar-menu-text">Input Data</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('daftar.bantuan') ? 'active' : '' }}" href="{{ route('daftar.bantuan') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <span class="sidebar-menu-text">Daftar Bantuan</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('daftar.laporan') ? 'active' : '' }}" href="{{ route('daftar.laporan') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="sidebar-menu-text">Daftar Laporan</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">MONITORING</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('monitoring') ? 'active' : '' }}" href="{{ route('monitoring') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <span class="sidebar-menu-text">Monitoring Bantuan</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('hasil.panen') ? 'active' : '' }}" href="{{ route('hasil.panen') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-tractor"></i>
                            </div>
                            <span class="sidebar-menu-text">Hasil Panen</span>
                        </a>
                    </div>
                </div>
            @elseif(Auth::check() && Auth::user()->role === 'petugas')
                <!-- Petugas Menu -->
                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">DASHBOARD</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <span class="sidebar-menu-text">Dashboard</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">VERIFIKASI</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('petugas.petani.*') ? 'active' : '' }}" href="{{ route('petugas.petani.index') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="sidebar-menu-text">Verifikasi Petani</span>
                            @php
                                $unverified_count = \App\Models\User::where('role', 'petani')
                                    ->where('is_verified', false)
                                    ->where('alamat_kecamatan', Auth::user()->alamat_kecamatan)
                                    ->count();
                            @endphp
                            @if($unverified_count > 0)
                                <span class="sidebar-badge badge-danger">{{ $unverified_count }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}" href="{{ route('petugas.laporan.index') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="sidebar-menu-text">Verifikasi Laporan</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">BANTUAN</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('petugas.bantuan.*') ? 'active' : '' }}" href="{{ route('petugas.bantuan.index') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <span class="sidebar-menu-text">Kelola Bantuan</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('petugas.monitoring') ? 'active' : '' }}" href="{{ route('petugas.monitoring') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="sidebar-menu-text">Monitoring Wilayah</span>
                        </a>
                    </div>
                </div>
            @elseif(Auth::check() && Auth::user()->role === 'petani')
                <!-- Petani Menu -->
                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">DASHBOARD</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <span class="sidebar-menu-text">Dashboard</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-menu-section">
                    <div class="sidebar-section-title">AKTIVITAS</div>
                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('input.data') ? 'active' : '' }}" href="{{ route('input.data') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="sidebar-menu-text">Input Data</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('daftar.bantuan') ? 'active' : '' }}" href="{{ route('daftar.bantuan') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <span class="sidebar-menu-text">Daftar Bantuan</span>
                        </a>
                    </div>

                    <div class="sidebar-menu-item">
                        <a class="sidebar-menu-link {{ request()->routeIs('daftar.laporan') ? 'active' : '' }}" href="{{ route('daftar.laporan') }}">
                            <div class="sidebar-menu-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="sidebar-menu-text">Daftar Laporan</span>
                        </a>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer-modern">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Notification Panel -->
    @auth
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h6><i class="fas fa-bell me-2"></i>Notifikasi</h6>
        </div>
            @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
            <div class="notification-item">
                <div class="d-flex align-items-start">
                    @php
                        $color = $notification->data['color'] ?? 'info';
                        $colorClass = $color == 'success' ? 'text-success' : ($color == 'warning' ? 'text-warning' : ($color == 'danger' ? 'text-danger' : 'text-info'));
                    @endphp
                    <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }} {{ $colorClass }} me-3 mt-1"></i>
                    <div class="flex-grow-1">
                        <strong>{{ $notification->data['title'] ?? 'Notifikasi' }}</strong>
                        <p class="mb-0 small">{{ $notification->data['message'] ?? 'Tidak ada pesan' }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        <div class="mt-2">
                            <button class="btn btn-xs btn-outline-success" onclick="markAsReadFromPanel('{{ $notification->id }}')">
                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="notification-item text-center">
                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                <p class="mb-0">Tidak ada notifikasi baru</p>
            </div>
            @endforelse
            @if(Auth::user()->unreadNotifications->count() > 5)
            <div class="notification-item text-center">
                <a href="{{ route('notifications.index') }}" class="text-decoration-none">
                    <small class="text-primary">Lihat semua notifikasi ({{ Auth::user()->unreadNotifications->count() }})</small>
                </a>
            </div>
            @endif
    </div>
    @endauth

    <!-- Main Content -->
    <main class="main-content-modern" id="mainContent">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modern Features JS -->
    <script src="{{ asset('js/modern-features.js') }}"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================
            // SIDEBAR FUNCTIONALITY (Mobile Only)
            // ============================================
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            let touchStartX = 0;
            let touchEndX = 0;

            // Toggle sidebar function (Mobile Only)
            function toggleSidebar() {
                // Only works on mobile
                if (window.innerWidth <= 768) {
                    const isShowing = sidebar.classList.toggle('show');
                    
                    if (isShowing) {
                        sidebarBackdrop.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    } else {
                        sidebarBackdrop.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                }
                // Desktop: Do nothing (sidebar always visible)
            }

            // Close sidebar function (Mobile Only)
            function closeSidebar() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarBackdrop.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            // Sidebar toggle button click
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Backdrop click to close sidebar (Mobile Only)
            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', closeSidebar);

            // ============================================
            // TOUCH SWIPE GESTURES FOR MOBILE
            // ============================================
            
            // Swipe from left edge to open sidebar
            document.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
                
                // If touch starts near left edge (within 30px) and sidebar is closed
                if (touchStartX < 30 && !sidebar.classList.contains('show') && window.innerWidth <= 768) {
                    sidebar.style.transition = 'none';
                }
            }, { passive: true });

            document.addEventListener('touchmove', function(e) {
                if (touchStartX < 30 && window.innerWidth <= 768) {
                    const touchCurrentX = e.changedTouches[0].screenX;
                    const diff = touchCurrentX - touchStartX;
                    
                    if (diff > 0 && diff < 280) {
                        sidebar.style.transform = `translateX(-${280 - diff}px)`;
                    }
                }
            }, { passive: true });

            document.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                
                if (touchStartX < 30 && window.innerWidth <= 768) {
                    sidebar.style.transition = '';
                    const swipeDistance = touchEndX - touchStartX;
                    
                    // If swiped more than 100px, open sidebar
                    if (swipeDistance > 100) {
                        sidebar.classList.add('show');
                        sidebarBackdrop.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    } else {
                        sidebar.style.transform = '';
                    }
                }
            }, { passive: true });

            // Swipe right to close sidebar when it's open
            sidebar.addEventListener('touchstart', function(e) {
                if (sidebar.classList.contains('show')) {
                    touchStartX = e.changedTouches[0].screenX;
                }
            }, { passive: true });

            sidebar.addEventListener('touchend', function(e) {
                if (sidebar.classList.contains('show')) {
                    touchEndX = e.changedTouches[0].screenX;
                    const swipeDistance = touchEndX - touchStartX;
                    
                    // If swiped right more than 100px, close sidebar
                    if (swipeDistance < -100) {
                        closeSidebar();
                    }
                }
            }, { passive: true });

            // ============================================
            // RESPONSIVE BEHAVIOR
            // ============================================
            function handleResize() {
                if (window.innerWidth > 768) {
                    // Desktop: ensure sidebar visible, no backdrop
                    sidebar.classList.remove('show');
                    sidebarBackdrop.classList.remove('show');
                    document.body.style.overflow = '';
                } else {
                    // Mobile: ensure sidebar hidden by default
                    if (!sidebar.classList.contains('show')) {
                        sidebarBackdrop.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial check

            // Close sidebar when clicking on menu items (on mobile)
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-menu-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(closeSidebar, 200); // Small delay for better UX
                    }
                });
            });

            // ============================================
            // NOTIFICATION PANEL FUNCTIONALITY
            // ============================================
            const notificationToggle = document.getElementById('notificationToggle');
            const notificationPanel = document.getElementById('notificationPanel');

            if (notificationToggle && notificationPanel) {
                notificationToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationPanel.classList.toggle('show');
                });

                // Close notification panel when clicking outside
                document.addEventListener('click', function(event) {
                    if (!notificationToggle.contains(event.target) && !notificationPanel.contains(event.target)) {
                        notificationPanel.classList.remove('show');
                    }
                });
            }

            // ============================================
            // GLOBAL SEARCH FUNCTIONALITY
            // ============================================
            const globalSearch = document.getElementById('globalSearch');
            const searchClear = document.getElementById('searchClear');

            if (globalSearch) {
                // Show/hide clear button
                globalSearch.addEventListener('input', function() {
                    if (this.value.length > 0 && searchClear) {
                        searchClear.style.display = 'block';
                    } else if (searchClear) {
                        searchClear.style.display = 'none';
                    }
                    
                    const searchTerm = this.value.toLowerCase();
                    // Simple search implementation - highlight matching text
                    const contentElements = document.querySelectorAll('#mainContent *');

                    contentElements.forEach(element => {
                        const text = element.textContent || element.innerText;
                        if (text.toLowerCase().includes(searchTerm) && searchTerm.length > 2) {
                            element.style.backgroundColor = 'rgba(79, 70, 229, 0.1)';
                        } else {
                            element.style.backgroundColor = '';
                        }
                    });
                });

                // Clear search button
                if (searchClear) {
                    searchClear.addEventListener('click', function() {
                        globalSearch.value = '';
                        this.style.display = 'none';
                        // Clear highlights
                        const contentElements = document.querySelectorAll('#mainContent *');
                        contentElements.forEach(element => {
                            element.style.backgroundColor = '';
                        });
                    });
                }

                // Clear search highlights when search is cleared
                globalSearch.addEventListener('blur', function() {
                    if (this.value === '') {
                        const contentElements = document.querySelectorAll('#mainContent *');
                        contentElements.forEach(element => {
                            element.style.backgroundColor = '';
                        });
                    }
                });
            }

            // ============================================
            // NOTIFICATION MARK AS READ
            // ============================================
            window.markAsReadFromPanel = function(notificationId) {
                fetch('/notifications/' + notificationId + '/read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            };

            // ============================================
            // SMOOTH SCROLL FOR SIDEBAR ACTIVE ITEM
            // ============================================
            const activeLink = sidebar.querySelector('.sidebar-menu-link.active');
            if (activeLink) {
                setTimeout(() => {
                    activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }

            // ============================================
            // KEYBOARD NAVIGATION
            // ============================================
            document.addEventListener('keydown', function(e) {
                // ESC key to close sidebar on mobile
                if (e.key === 'Escape' && sidebar.classList.contains('show') && window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
