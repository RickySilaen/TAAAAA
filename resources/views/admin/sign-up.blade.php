<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>
    Daftar - Sistem Bantuan Pertanian Dinas Pertanian Toba
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
  <style>
    :root {
      --primary-green: #2E7D32;
      --secondary-green: #4CAF50;
      --light-green: #E8F5E8;
      --accent-blue: #1976D2;
      --dark-blue: #0D47A1;
      --text-dark: #212121;
      --text-light: #757575;
      --border-color: #E0E0E0;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f8f9fa;
    }

    .government-header {
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
      color: white;
      padding: 1rem 0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .government-header .navbar-brand {
      font-weight: 700;
      font-size: 1.25rem;
    }

    .government-header .navbar-brand img {
      width: 40px;
      height: 40px;
      border-radius: 8px;
    }

    .hero-section {
      background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #4CAF50 100%);
      min-height: 60vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
      background-size: cover;
      background-position: center;
      opacity: 0.1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: white;
    }

    .hero-content h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .hero-content p {
      font-size: 1.1rem;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .register-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-top: -50px;
      position: relative;
      z-index: 3;
    }

    .register-header {
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
      color: white;
      padding: 2rem 1.5rem;
      text-align: center;
    }

    .register-header h5 {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .register-header p {
      opacity: 0.9;
      margin: 0;
      font-size: 0.9rem;
    }

    .form-control {
      border: 2px solid var(--border-color);
      border-radius: 8px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--secondary-green);
      box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
    }

    .input-group-text {
      background-color: var(--light-green);
      border: 2px solid var(--border-color);
      color: var(--primary-green);
    }

    .btn-register {
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
      border: none;
      border-radius: 8px;
      padding: 0.75rem 2rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
    }

    .btn-register:hover {
      background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    .social-register {
      border-top: 1px solid var(--border-color);
      padding-top: 1.5rem;
      margin-top: 1.5rem;
    }

    .social-register .btn {
      border: 2px solid var(--border-color);
      border-radius: 8px;
      padding: 0.5rem;
      margin: 0 0.25rem;
      transition: all 0.3s ease;
    }

    .social-register .btn:hover {
      border-color: var(--secondary-green);
      transform: translateY(-2px);
    }

    .government-footer {
      background-color: var(--text-dark);
      color: white;
      padding: 2rem 0 1rem;
      margin-top: 4rem;
    }

    .government-footer h6 {
      color: var(--secondary-green);
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .government-footer a {
      color: #BDBDBD;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .government-footer a:hover {
      color: var(--secondary-green);
    }

    .footer-logo {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    .footer-logo img {
      width: 30px;
      height: 30px;
      margin-right: 0.5rem;
      border-radius: 4px;
    }

    .agriculture-icon {
      color: var(--secondary-green);
      font-size: 2rem;
      margin: 0 0.5rem;
    }

    .floating-icons {
      position: absolute;
      top: 20%;
      right: 10%;
      opacity: 0.1;
      z-index: 1;
    }

    .floating-icons i {
      font-size: 3rem;
      margin: 1rem;
      animation: float 6s ease-in-out infinite;
    }

    .floating-icons i:nth-child(2) { animation-delay: 2s; }
    .floating-icons i:nth-child(3) { animation-delay: 4s; }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(5deg); }
    }

    .form-check-input:checked {
      background-color: var(--secondary-green);
      border-color: var(--secondary-green);
    }

    .text-link {
      color: var(--accent-blue);
      text-decoration: none;
      font-weight: 500;
    }

    .text-link:hover {
      color: var(--dark-blue);
      text-decoration: underline;
    }

    .petani-fields, .petugas-fields {
      display: none;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2rem;
      }

      .register-card {
        margin-top: -30px;
      }

      .floating-icons {
        display: none;
      }
    }
  </style>
</head>

<body class="">
  <!-- Government Header -->
  <nav class="navbar navbar-expand-lg government-header">
    <div class="container">
      <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo Dinas Pertanian Toba">
        <span>Dinas Pertanian Kabupaten Toba</span>
      </a>

    </div>
  </nav>
  <!-- End Government Header -->

  <main class="main-content mt-0">
    <section class="hero-section">
      <div class="floating-icons">
        <i class="fas fa-tractor"></i>
        <i class="fas fa-seedling"></i>
        <i class="fas fa-wheat-awn"></i>
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 hero-content">
            <h1>Bergabunglah dengan Sistem Bantuan Pertanian</h1>
            <p class="mb-4">Dinas Pertanian Kabupaten Toba - Platform Digital untuk Pengelolaan Bantuan Pertanian Modern</p>
            <div class="d-flex justify-content-center">
              <i class="fas fa-seedling agriculture-icon"></i>
              <i class="fas fa-wheat-awn agriculture-icon"></i>
              <i class="fas fa-leaf agriculture-icon"></i>
              <i class="fas fa-tractor agriculture-icon"></i>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card register-card">
            <div class="register-header">
              <h5>Daftar Akun Baru</h5>
              <p>Sistem Bantuan Pertanian Dinas Pertanian Toba</p>
            </div>
            <div class="card-body p-4">
              <form method="POST" action="{{ route('register') }}" role="form">
                @csrf
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" aria-label="Nama Lengkap" required autofocus>
                  </div>
                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" required>
                  </div>
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi" aria-label="Kata Sandi" required>
                  </div>
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" aria-label="Konfirmasi Kata Sandi" required>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                      <option value="">Pilih Peran</option>
                      <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                      <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                  </div>
                  @error('role')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3 petugas-fields">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <input id="alamat_desa_petugas" type="text" class="form-control @error('alamat_desa') is-invalid @enderror" name="alamat_desa" value="{{ old('alamat_desa') }}" placeholder="Alamat Desa" aria-label="Alamat Desa">
                  </div>
                  @error('alamat_desa')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3 petani-fields">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <input id="alamat_desa_petani" type="text" class="form-control @error('alamat_desa') is-invalid @enderror" name="alamat_desa" value="{{ old('alamat_desa') }}" placeholder="Alamat Desa" aria-label="Alamat Desa">
                  </div>
                  @error('alamat_desa')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-3 petani-fields">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-ruler-combined"></i></span>
                    <input id="luas_lahan" type="number" step="0.01" class="form-control @error('luas_lahan') is-invalid @enderror" name="luas_lahan" value="{{ old('luas_lahan') }}" placeholder="Luas Lahan (ha)" aria-label="Luas Lahan">
                  </div>
                  @error('luas_lahan')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="form-check form-check-info text-start mb-3">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    Saya setuju dengan <a href="javascript:;" class="text-link font-weight-bolder">Kebijakan Pertanian</a>
                  </label>
                </div>
                <div class="text-center mb-3">
                  <a href="javascript:;" class="text-link">Butuh Bantuan Pendaftaran?</a>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-register w-100 my-4 mb-2">Daftar</button>
                </div>
                <p class="text-sm mt-3 mb-0 text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-link font-weight-bolder">Masuk</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Government Footer -->
  <footer class="government-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <div class="footer-logo">
            <img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo Dinas Pertanian Toba">
            <h6>Dinas Pertanian Kabupaten Toba</h6>
          </div>
          <p class="mb-3">Sistem Bantuan Pertanian Digital untuk Kemajuan Pertanian Modern</p>
          <div class="row">
            <div class="col-md-4 mb-3">
              <h6>Layanan</h6>
              <ul class="list-unstyled">
                <li><a href="#">Bantuan Pertanian</a></li>
                <li><a href="#">Monitoring Laporan</a></li>
                <li><a href="#">Data Petani</a></li>
              </ul>
            </div>
            <div class="col-md-4 mb-3">
              <h6>Kontak</h6>
              <ul class="list-unstyled">
                <li><i class="fas fa-map-marker-alt me-2"></i>Kabupaten Toba</li>
                <li><i class="fas fa-phone me-2"></i>(0625) XXX-XXXX</li>
                <li><i class="fas fa-envelope me-2"></i>info@pertanian.toba.go.id</li>
              </ul>
            </div>
            <div class="col-md-4 mb-3">
              <h6>Media Sosial</h6>
              <div class="d-flex justify-content-center">
                <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-4" style="border-color: #555;">
      <div class="row">
        <div class="col-12 text-center">
          <p class="mb-0">
            &copy; <script>document.write(new Date().getFullYear())</script> Dinas Pertanian Kabupaten Toba.
            Sistem Bantuan Pertanian - Hak Cipta Dilindungi.
          </p>
        </div>
      </div>
    </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>
  <script>
    document.getElementById('role').addEventListener('change', function() {
      var petaniFields = document.querySelectorAll('.petani-fields');
      var petugasFields = document.querySelectorAll('.petugas-fields');

      // Hide all fields first
      petaniFields.forEach(function(field) {
        field.style.display = 'none';
      });
      petugasFields.forEach(function(field) {
        field.style.display = 'none';
      });

      // Show fields based on selected role
      if (this.value === 'petani') {
        petaniFields.forEach(function(field) {
          field.style.display = 'block';
        });
      } else if (this.value === 'petugas') {
        petugasFields.forEach(function(field) {
          field.style.display = 'block';
        });
      }
    });
  </script>
</body>

</html>
