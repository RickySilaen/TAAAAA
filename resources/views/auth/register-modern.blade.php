<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Dinas Pertanian Kabupaten Toba</title>
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
            background: url('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200') center/cover;
            opacity: 0.1;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
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

        .auth-stats {
            margin-top: 3rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .stat-item {
            padding: 1.5rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-5px);
        }

        .stat-item .number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffc107;
            margin-bottom: 0.5rem;
        }

        .stat-item .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Right Side - Form */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #fff;
            max-height: 100vh;
            overflow-y: auto;
        }

        .auth-form-container {
            width: 100%;
            max-width: 550px;
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
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        /* Modern Form Styles */
        .form-floating {
            margin-bottom: 1.25rem;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
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

        .form-floating > .form-control:focus ~ .input-icon,
        .form-floating > .form-select:focus ~ .input-icon {
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

        /* Terms Checkbox */
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

        .form-check-label a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-register {
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

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
        }

        .login-link a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
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

        /* Row Grid for 2 columns */
        .row-2-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
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

            .row-2-col {
                grid-template-columns: 1fr;
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
                    Bergabunglah dengan<br>
                    <span class="highlight">Sistem Pertanian Digital</span>
                </h1>
                <p>Daftarkan diri Anda dan nikmati berbagai kemudahan dalam mengelola data pertanian secara digital dan transparan</p>

                <div class="auth-stats">
                    <div class="stat-item">
                        <div class="number">500+</div>
                        <div class="label">Petani Terdaftar</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">150+</div>
                        <div class="label">Program Bantuan</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">1000+</div>
                        <div class="label">Laporan Panen</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>

                <h2 class="auth-form-title">Daftar Akun Baru</h2>
                <p class="auth-form-subtitle">Isi formulir di bawah ini untuk membuat akun Anda</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Oops!</strong> Ada kesalahan dalam formulir Anda.
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                        <label for="name">Nama Lengkap</label>
                    </div>

                    <div class="form-floating position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        <label for="email">Alamat Email</label>
                    </div>

                    <div class="row-2-col">
                        <div class="form-floating position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                            <label for="password">Kata Sandi</label>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>

                        <div class="form-floating position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                            <label for="password_confirmation">Konfirmasi Sandi</label>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-floating position-relative">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" placeholder="Nomor Telepon" value="{{ old('telepon') }}">
                        <label for="telepon">Nomor Telepon (Opsional)</label>
                    </div>

                    <div class="form-floating position-relative">
                        <i class="fas fa-user-tag input-icon"></i>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="petani" {{ old('role') == 'petani' ? 'selected' : '' }}>Petani</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        </select>
                        <label for="role">Role Pengguna</label>
                    </div>

                    <div class="row-2-col">
                        <div class="form-floating position-relative">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                            <input type="text" class="form-control @error('alamat_desa') is-invalid @enderror" id="alamat_desa" name="alamat_desa" placeholder="Alamat Desa" value="{{ old('alamat_desa') }}" required>
                            <label for="alamat_desa">Alamat Desa</label>
                        </div>

                        <div class="form-floating position-relative">
                            <i class="fas fa-map input-icon"></i>
                            <input type="text" class="form-control @error('alamat_kecamatan') is-invalid @enderror" id="alamat_kecamatan" name="alamat_kecamatan" placeholder="Alamat Kecamatan" value="{{ old('alamat_kecamatan') }}" required>
                            <label for="alamat_kecamatan">Alamat Kecamatan</label>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus me-2"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            if (value.length >= 8) strength++;
            if (/[a-z]/.test(value)) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^a-zA-Z0-9]/.test(value)) strength++;
            
            // You can add visual feedback here
        });
    </script>
</body>
</html>
