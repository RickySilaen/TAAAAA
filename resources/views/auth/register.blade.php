<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Dinas Pertanian Kabupaten Toba</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome - Local Version -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-local.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-green: #4caf50;
            --dark-green: #2e7d32;
            --accent-green: #66bb6a;
            --light-green: #e8f5e9;
            --accent-yellow: #ffc107;
            --gradient-green: linear-gradient(135deg, #2e7d32 0%, #4caf50 50%, #66bb6a 100%);
            --gradient-overlay: linear-gradient(135deg, rgba(46, 125, 50, 0.95) 0%, rgba(76, 175, 80, 0.90) 100%);
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Inter', sans-serif;
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-secondary);
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Main Container */
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            position: relative;
        }

        /* Left Panel - Hero Section */
        .hero-panel {
            flex: 1;
            background: var(--gradient-green);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow: hidden;
        }

        /* Background Pattern */
        .hero-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 193, 7, 0.1) 0%, transparent 50%),
                url('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            animation: backgroundSlide 20s ease-in-out infinite;
        }

        @keyframes backgroundSlide {
            0%, 100% { transform: scale(1) translateX(0); }
            50% { transform: scale(1.1) translateX(-10px); }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -50px;
            left: -50px;
            animation: float1 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -30px;
            right: -30px;
            animation: float2 10s ease-in-out infinite;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 40%;
            right: 10%;
            background: rgba(255, 193, 7, 0.15);
            animation: float3 12s ease-in-out infinite;
        }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, -30px) rotate(180deg); }
        }

        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-40px, 40px) rotate(-180deg); }
        }

        @keyframes float3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.2); }
        }

        /* Hero Content */
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: #fff;
            max-width: 600px;
        }

        .logo-wrapper {
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo-wrapper img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .hero-title {
            font-family: var(--font-primary);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, #ffc107 0%, #ffeb3b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .stat-card {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffc107;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Right Panel - Form Section */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #fff;
            max-height: 100vh;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 550px;
            animation: fadeInRight 0.8s ease-out;
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6c757d;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .back-button:hover {
            color: var(--primary-green);
            transform: translateX(-5px);
        }

        /* Form Header */
        .form-header {
            margin-bottom: 2rem;
        }

        .form-title {
            font-family: var(--font-primary);
            font-size: 2rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
        }

        .progress-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .progress-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 18px;
            left: 50%;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, var(--primary-green), #dee2e6);
            z-index: 0;
        }

        .progress-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gradient-green);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .progress-text {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-green);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 2;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            height: 55px;
            padding: 0 1rem 0 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: var(--font-secondary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-control.is-valid {
            border-color: #28a745;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2rem;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-select {
            width: 100%;
            height: 55px;
            padding: 0 1rem 0 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            background-color: #fff;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary-green);
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-fill.weak {
            width: 33%;
            background: linear-gradient(to right, #dc3545, #e35d6a);
        }

        .strength-fill.medium {
            width: 66%;
            background: linear-gradient(to right, #ffc107, #ffcd39);
        }

        .strength-fill.strong {
            width: 100%;
            background: linear-gradient(to right, #28a745, #48bb61);
        }

        .strength-text {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .strength-text.weak { color: #dc3545; }
        .strength-text.medium { color: #ffc107; }
        .strength-text.strong { color: #28a745; }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: var(--primary-green);
        }

        .checkbox-label {
            font-size: 0.9rem;
            color: #4a5568;
            cursor: pointer;
        }

        .checkbox-label a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
        }

        .checkbox-label a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 55px;
            background: var(--gradient-green);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .login-link a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Alert */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: none;
            animation: slideDown 0.5s ease-out;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-panel {
                display: none;
            }

            .form-panel {
                flex: 1;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .form-panel {
                padding: 1.5rem 1rem;
            }

            .form-title {
                font-size: 1.75rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        /* Scrollbar */
        .form-panel::-webkit-scrollbar {
            width: 8px;
        }

        .form-panel::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .form-panel::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 4px;
        }

        .form-panel::-webkit-scrollbar-thumb:hover {
            background: var(--dark-green);
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <!-- Left Panel - Hero Section -->
        <div class="hero-panel">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>

            <div class="hero-content">
                <div class="logo-wrapper">
                    <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo Dinas Pertanian Toba">
                </div>
                
                <h1 class="hero-title">
                    Bergabunglah dengan<br>
                    <span class="highlight">Sistem Pertanian Digital</span>
                </h1>
                
                <p class="hero-subtitle">
                    Daftarkan diri Anda dan nikmati berbagai kemudahan dalam mengelola data pertanian secara digital, transparan, dan efisien
                </p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Petani Terdaftar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Program Bantuan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Laporan Panen</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form Section -->
        <div class="form-panel">
            <div class="form-container">
                <a href="{{ route('home') }}" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg> Kembali ke Beranda
                </a>

                <div class="form-header">
                    <h2 class="form-title">Daftar Akun Baru</h2>
                    <p class="form-subtitle">Isi formulir di bawah ini untuk membuat akun Anda</p>
                </div>

                <!-- Progress Indicator -->
                <div class="progress-indicator">
                    <div class="progress-item">
                        <div class="progress-circle">1</div>
                        <div class="progress-text">Data Diri</div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-circle">2</div>
                        <div class="progress-text">Keamanan</div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-circle">3</div>
                        <div class="progress-text">Lokasi</div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="me-2" style="vertical-align: -3px;">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                        <strong>Oops!</strong> Ada kesalahan dalam formulir Anda.
                        <ul class="mb-0 mt-2" style="padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                            </svg>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Password & Confirmation -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" id="toggleIcon1">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" id="toggleIcon2">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                            <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon (Opsional)" value="{{ old('telepon') }}">
                        </div>
                    </div>

                    <!-- Role (Hidden - Default to Petani) -->
                    <input type="hidden" name="role" value="petani">

                    <!-- Desa & Kecamatan -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <input type="text" class="form-control" id="alamat_desa" name="alamat_desa" placeholder="Alamat Desa" value="{{ old('alamat_desa') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="input-icon">
                                    <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"/>
                                </svg>
                                <input type="text" class="form-control" id="alamat_kecamatan" name="alamat_kecamatan" placeholder="Alamat Kecamatan" value="{{ old('alamat_kecamatan') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="checkbox-wrapper">
                        <input type="checkbox" class="checkbox-input" id="terms" name="terms" required>
                        <label class="checkbox-label" for="terms">
                            Saya setuju dengan <a href="#">Kebijakan Pertanian</a> dan <a href="#">Syarat Layanan</a>
                        </label>
                    </div>

                    <!-- Info Verifikasi -->
                    <div class="alert alert-info mb-3" style="border-left: 4px solid #17a2b8;">
                        <div class="d-flex align-items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 16 16" class="me-3" style="flex-shrink: 0; margin-top: 2px;">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </svg>
                            <div>
                                <strong>Informasi Penting:</strong>
                                <p class="mb-0 mt-1" style="font-size: 0.9rem;">
                                    Setelah mendaftar, akun Anda akan diverifikasi oleh petugas daerah terlebih dahulu. 
                                    Anda akan menerima notifikasi setelah akun diverifikasi dan dapat login ke sistem.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="me-2" style="vertical-align: -2px;">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                // Eye slash icon (password visible)
                icon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
            } else {
                input.type = 'password';
                // Eye icon (password hidden)
                icon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
            }
        }

        // Password Strength Meter
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;

            if (value.length >= 8) strength++;
            if (value.length >= 12) strength++;
            if (/[a-z]/.test(value)) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^a-zA-Z0-9]/.test(value)) strength++;

            strengthFill.className = 'strength-fill';
            strengthText.className = 'strength-text';

            if (strength <= 2) {
                strengthFill.classList.add('weak');
                strengthText.classList.add('weak');
                strengthText.textContent = '❌ Password Lemah';
            } else if (strength <= 4) {
                strengthFill.classList.add('medium');
                strengthText.classList.add('medium');
                strengthText.textContent = '⚠️ Password Sedang';
            } else {
                strengthFill.classList.add('strong');
                strengthText.classList.add('strong');
                strengthText.textContent = '✅ Password Kuat';
            }

            if (value.length === 0) {
                strengthText.textContent = '';
            }
        });

        // Real-time Validation
        const formInputs = document.querySelectorAll('.form-control, .form-select');
        formInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '' && this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-valid') || this.classList.contains('is-invalid')) {
                    if (this.checkValidity()) {
                        this.classList.add('is-valid');
                        this.classList.remove('is-invalid');
                    } else {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    }
                }
            });
        });

        // Password Confirmation Match
        const passwordConfirm = document.getElementById('password_confirmation');
        passwordConfirm.addEventListener('input', function() {
            if (this.value === passwordInput.value && this.value !== '') {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else if (this.value !== '' && this.value !== passwordInput.value) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });

        // Form Submit Handler
        const registerForm = document.getElementById('registerForm');
        registerForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="spinner me-2" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite; vertical-align: -2px;"><style>@keyframes spin{to{transform:rotate(360deg)}}</style><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.416" stroke-dashoffset="10"/></svg>Mendaftar...';
        });

        // Auto-hide Alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
