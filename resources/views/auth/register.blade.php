<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Dinas Pertanian Kabupaten Toba</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
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
                        <i class="fas fa-exclamation-circle me-2"></i>
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
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Password & Confirmation -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
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
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon (Opsional)" value="{{ old('telepon') }}">
                        </div>
                    </div>

                    <!-- Role (Hidden - Default to Petani) -->
                    <input type="hidden" name="role" value="petani">

                    <!-- Desa & Kecamatan -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" class="form-control" id="alamat_desa" name="alamat_desa" placeholder="Alamat Desa" value="{{ old('alamat_desa') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-map input-icon"></i>
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
                            <i class="fas fa-info-circle me-3" style="font-size: 1.5rem; margin-top: 2px;"></i>
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
                        <i class="fas fa-user-plus me-2"></i>
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
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
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
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftar...';
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
