<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Dinas Pertanian Kabupaten Toba</title>
    <link rel="icon" href="{{ asset('images/logo-dinas-pertanian-toba.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-green: #2e7d32;
            --secondary-green: #388e3c;
            --dark-green: #1b5e20;
            --accent-yellow: #ffc107;
            --gradient-primary: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
            --gradient-accent: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
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
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* Split Screen Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
        }

        /* Left Side - Image & Branding */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1200') center/cover;
            opacity: 0.1;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,193,7,0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .auth-branding {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .auth-branding .logo-container {
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .auth-branding .logo-container img {
            width: 120px;
            height: 120px;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
            animation: float 3s ease-in-out infinite;
        }

        .auth-branding h1 {
            font-family: var(--font-primary);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .auth-branding .highlight {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-branding p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 500px;
            margin: 0 auto 2rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .auth-features {
            margin-top: 3rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem 1.5rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(10px);
        }

        .feature-item i {
            font-size: 2rem;
            color: #ffc107;
            margin-right: 1rem;
        }

        .feature-item .text h5 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .feature-item .text p {
            font-size: 0.9rem;
            opacity: 0.85;
            margin: 0;
        }

        /* Right Side - Form */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #fff;
        }

        .auth-form-container {
            width: 100%;
            max-width: 500px;
            animation: fadeInRight 0.8s ease-out;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #6c757d;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-green);
            transform: translateX(-5px);
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        .auth-form-title {
            font-family: var(--font-primary);
            font-size: 2rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .auth-form-subtitle {
            color: #6c757d;
            margin-bottom: 2.5rem;
            font-size: 1rem;
        }

        /* Modern Form Styles */
        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control {
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }

        .form-floating > label {
            padding-left: 3rem;
            color: #6c757d;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 4;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus ~ .input-icon {
            color: var(--primary-green);
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
            z-index: 4;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-green);
        }

        /* Remember Me Checkbox */
        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .form-check-label {
            margin-left: 0.5rem;
            color: #4a5568;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            height: 55px;
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #6c757d;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
        }

        /* Social Login Buttons */
        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn-social {
            flex: 1;
            height: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            color: #4a5568;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-social:hover {
            border-color: var(--primary-green);
            background: rgba(46, 125, 50, 0.05);
            transform: translateY(-2px);
        }

        .btn-social img {
            width: 20px;
            height: 20px;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
        }

        .register-link a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: var(--dark-green);
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: none;
            animation: slideDown 0.5s ease-out;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                flex: 1;
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .auth-form-title {
                font-size: 1.75rem;
            }

            .auth-right {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <div class="auth-branding">
                <div class="logo-container">
                    <img src="{{ asset('images/logo-dinas-pertanian-toba.png') }}" alt="Logo Dinas Pertanian Toba">
                </div>
                <h1>
                    Selamat Datang di<br>
                    <span class="highlight">Sistem Pertanian Digital</span>
                </h1>
                <p>Platform modern untuk pengelolaan data pertanian, distribusi bantuan, dan pelaporan hasil panen Kabupaten Toba</p>

                <div class="auth-features">
                    <div class="feature-item">
                        <i class="fas fa-chart-line"></i>
                        <div class="text">
                            <h5>Monitoring Real-time</h5>
                            <p>Pantau data pertanian secara langsung</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-hands-helping"></i>
                        <div class="text">
                            <h5>Program Bantuan</h5>
                            <p>Akses berbagai program bantuan pertanian</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <div class="text">
                            <h5>Keamanan Terjamin</h5>
                            <p>Data Anda terenkripsi dan terlindungi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>

                <h2 class="auth-form-title">Masuk ke Akun Anda</h2>
                <p class="auth-form-subtitle">Silakan masukkan email dan password Anda untuk melanjutkan</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Oops!</strong> {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        <label for="email">Alamat Email</label>
                    </div>

                    <div class="form-floating position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Kata Sandi</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none" style="color: var(--primary-green); font-weight: 500;">
                            Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk Sekarang
                    </button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
