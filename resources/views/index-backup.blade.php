@extends('layouts.public')

@section('title', 'Beranda - Dinas Pertanian Kabupaten Toba')

@section('content')

<!-- Hero Section -->
<section class="hero-section py-5 text-center text-white position-relative overflow-hidden">
    <div class="hero-background"></div>
    <div class="hero-pattern"></div>
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-lg-start text-center">
                <div class="hero-badge mb-3">
                    <span class="badge bg-white bg-opacity-25 text-white px-4 py-2 rounded-pill">
                        <i class="fas fa-seedling me-2"></i>Sistem Informasi Pertanian Digital
                    </span>
                </div>
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInUp hero-title">
                    Selamat Datang di Sistem Informasi<br>
                    <span class="hero-highlight">Dinas Pertanian Kabupaten Toba</span>
                </h1>
                <p class="lead mb-5 opacity-90 animate__animated animate__fadeInUp animate__delay-1s hero-subtitle">
                    Mendukung peningkatan sektor pertanian melalui inovasi digital dan pelayanan terpadu kepada masyarakat.
                </p>
                <div class="d-flex flex-wrap justify-content-lg-start justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="{{ route('bantuan.publik') }}" class="btn btn-light btn-lg rounded-pill px-5 shadow-lg btn-hover-lift">
                        <i class="fas fa-hand-holding-heart me-2"></i>Lihat Bantuan
                    </a>
                    <a href="{{ route('laporan.publik') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 btn-hover-lift">
                        <i class="fas fa-chart-line me-2"></i>Lihat Laporan
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-warning btn-lg rounded-pill px-5 shadow-lg btn-hover-lift">
                        <i class="fas fa-sign-in-alt me-2"></i>Login Sistem
                    </a>
                </div>
                <div class="mt-5 d-flex flex-wrap justify-content-lg-start justify-content-center gap-4 text-white-50">
                    <div class="hero-stat">
                        <h4 class="fw-bold text-white mb-0">{{ number_format($totalPetani) }}+</h4>
                        <small>Petani Terdaftar</small>
                    </div>
                    <div class="hero-stat">
                        <h4 class="fw-bold text-white mb-0">{{ number_format($totalBantuan) }}+</h4>
                        <small>Program Bantuan</small>
                    </div>
                    <div class="hero-stat">
                        <h4 class="fw-bold text-white mb-0">{{ number_format($totalLaporan) }}+</h4>
                        <small>Laporan Panen</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <div class="hero-image-wrapper">
                    <div class="hero-image-glow"></div>
                    <img src="{{ asset('assets/img/illustrations/agriculture-hero.svg') }}"
                         alt="Pertanian Modern"
                         class="img-fluid floating-image hero-main-image"
                         onerror="this.src='https://distan.tobakab.go.id/wp-content/uploads/2022/08/kegiatan1.jpg'">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- Tentang Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <div class="about-image-wrapper position-relative">
                    <div class="about-image-decoration"></div>
                    <img src="https://distan.tobakab.go.id/wp-content/uploads/2022/08/kegiatan1.jpg"
                         class="img-fluid rounded-4 shadow-lg about-main-image"
                         alt="Kegiatan Pertanian Toba"
                         loading="lazy">
                    <div class="about-badge">
                        <i class="fas fa-award text-warning fa-2x mb-2"></i>
                        <div class="fw-bold">Terpercaya</div>
                        <small>Sejak 2020</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <div class="section-badge mb-3">
                    <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill">
                        <i class="fas fa-leaf me-2"></i>Tentang Kami
                    </span>
                </div>
                <h2 class="display-6 fw-bold text-dark mb-4">
                    Dinas Pertanian <span class="text-success">Kabupaten Toba</span>
                </h2>
                <p class="text-secondary fs-5 mb-4 lh-lg">
                    Dinas Pertanian Kabupaten Toba berkomitmen untuk meningkatkan kesejahteraan petani melalui program pembangunan pertanian berkelanjutan. 
                    Dengan semangat gotong royong dan pemanfaatan teknologi, kami hadir untuk mendukung ketahanan pangan dan produktivitas pertanian di wilayah Toba.
                </p>
                <div class="row g-4 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                <i class="fas fa-check fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Inovasi Digital</h6>
                                <small class="text-muted">Teknologi modern untuk pertanian</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Pemberdayaan Petani</h6>
                                <small class="text-muted">Program pelatihan berkelanjutan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('tentang') }}" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm btn-hover-lift">
                    <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="py-5 my-5 position-relative stats-section">
    <div class="stats-background"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill">
                    <i class="fas fa-chart-bar me-2"></i>Statistik & Data
                </span>
            </div>
            <h3 class="display-6 fw-bold text-dark mb-3">Data dan Statistik Pertanian</h3>
            <p class="text-muted lead">Informasi terkini tentang perkembangan pertanian di Kabupaten Toba</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card-modern">
                    <div class="stat-icon-wrapper bg-gradient-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-number-modern text-primary mb-2">{{ number_format($totalPetani) }}</h5>
                        <p class="stat-label mb-3">Petani Terdaftar</p>
                        <div class="stat-progress">
                            <div class="stat-progress-bar bg-primary" style="width: 85%"></div>
                        </div>
                        <small class="text-muted"><i class="fas fa-arrow-up text-success me-1"></i>12% dari tahun lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card-modern">
                    <div class="stat-icon-wrapper bg-gradient-success">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-number-modern text-success mb-2">{{ number_format($totalBantuan) }}</h5>
                        <p class="stat-label mb-3">Program Bantuan</p>
                        <div class="stat-progress">
                            <div class="stat-progress-bar bg-success" style="width: 70%"></div>
                        </div>
                        <small class="text-muted"><i class="fas fa-arrow-up text-success me-1"></i>8% dari tahun lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card-modern">
                    <div class="stat-icon-wrapper bg-gradient-info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-number-modern text-info mb-2">{{ number_format($totalLaporan) }}</h5>
                        <p class="stat-label mb-3">Laporan Panen</p>
                        <div class="stat-progress">
                            <div class="stat-progress-bar bg-info" style="width: 92%"></div>
                        </div>
                        <small class="text-muted"><i class="fas fa-arrow-up text-success me-1"></i>15% dari tahun lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card-modern">
                    <div class="stat-icon-wrapper bg-gradient-warning">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-number-modern text-warning mb-2">{{ number_format($totalHasilPanen) }}</h5>
                        <p class="stat-label mb-3">Total Hasil Panen (kg)</p>
                        <div class="stat-progress">
                            <div class="stat-progress-bar bg-warning" style="width: 78%"></div>
                        </div>
                        <small class="text-muted"><i class="fas fa-arrow-up text-success me-1"></i>20% dari tahun lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Unggulan -->
<section class="py-5 my-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3">
                <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill">
                    <i class="fas fa-star me-2"></i>Program Unggulan
                </span>
            </div>
            <h3 class="display-6 fw-bold text-dark mb-3">Program Unggulan Kami</h3>
            <p class="text-muted lead">Inisiatif unggulan untuk mendukung petani dan ketahanan pangan</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="program-card-modern">
                    <div class="program-image-wrapper">
                        <img src="https://distan.tobakab.go.id/wp-content/uploads/2022/08/kegiatan3.jpg"
                             class="program-image"
                             alt="Modernisasi Pertanian">
                        <div class="program-overlay">
                            <div class="program-icon">
                                <i class="fas fa-tractor"></i>
                            </div>
                        </div>
                    </div>
                    <div class="program-content">
                        <h5 class="program-title">Modernisasi Pertanian</h5>
                        <p class="program-description">
                            Mendorong penggunaan teknologi dan mekanisasi pertanian untuk meningkatkan efisiensi dan hasil panen.
                        </p>
                        <a href="#" class="program-link">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="program-card-modern">
                    <div class="program-image-wrapper">
                        <img src="https://distan.tobakab.go.id/wp-content/uploads/2022/08/kegiatan2.jpg"
                             class="program-image"
                             alt="Pelatihan Petani">
                        <div class="program-overlay">
                            <div class="program-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                    </div>
                    <div class="program-content">
                        <h5 class="program-title">Pelatihan dan Penyuluhan</h5>
                        <p class="program-description">
                            Menyelenggarakan pelatihan rutin bagi petani untuk meningkatkan keterampilan dan pengetahuan di bidang agrikultur.
                        </p>
                        <a href="#" class="program-link">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="program-card-modern">
                    <div class="program-image-wrapper">
                        <img src="https://distan.tobakab.go.id/wp-content/uploads/2022/08/kegiatan4.jpg"
                             class="program-image"
                             alt="Ketahanan Pangan">
                        <div class="program-overlay">
                            <div class="program-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                    </div>
                    <div class="program-content">
                        <h5 class="program-title">Ketahanan Pangan</h5>
                        <p class="program-description">
                            Menjamin ketersediaan dan pemerataan pangan melalui penguatan sistem distribusi hasil pertanian.
                        </p>
                        <a href="#" class="program-link">
                            Pelajari Lebih Lanjut <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru (Opsional dari database) -->
@if($beritas->count() > 0)
<section class="py-5 my-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3">
                <span class="badge bg-info bg-opacity-10 text-info px-4 py-2 rounded-pill">
                    <i class="fas fa-newspaper me-2"></i>Berita & Informasi
                </span>
            </div>
            <h3 class="display-6 fw-bold text-dark mb-3">Berita Terbaru</h3>
            <p class="text-muted lead">Informasi terkini seputar pertanian dan program bantuan</p>
        </div>
        <div class="row g-4">
            @foreach($beritas->take(3) as $index => $berita)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="berita-card-modern">
                    <div class="berita-image-wrapper">
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                 class="berita-image" 
                                 alt="{{ $berita->judul }}">
                        @else
                            <div class="berita-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                        <div class="berita-date-badge">
                            <div class="berita-day">{{ $berita->tanggal_publikasi?->format('d') ?? $berita->created_at->format('d') }}</div>
                            <div class="berita-month">{{ $berita->tanggal_publikasi?->format('M') ?? $berita->created_at->format('M') }}</div>
                        </div>
                    </div>
                    <div class="berita-content">
                        <div class="berita-category mb-2">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-tag me-1"></i>Pertanian
                            </span>
                        </div>
                        <h5 class="berita-title">{{ Str::limit($berita->judul, 60) }}</h5>
                        <p class="berita-excerpt">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                        <div class="berita-footer">
                            <div class="berita-meta">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $berita->tanggal_publikasi?->format('d M Y') ?? $berita->created_at->format('d M Y') }}
                                </small>
                            </div>
                            <a href="{{ route('berita.detail', $berita->id) }}" class="berita-read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('berita') }}" class="btn btn-outline-success btn-lg rounded-pill px-5 shadow-sm btn-hover-lift">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Kontak -->
<section class="cta-section py-5 position-relative overflow-hidden">
    <div class="cta-background"></div>
    <div class="cta-pattern"></div>
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                <h3 class="display-6 fw-bold text-white mb-3">Ingin Bekerja Sama atau Butuh Informasi?</h3>
                <p class="text-white-50 fs-5 mb-0">Hubungi kami melalui halaman kontak atau datang langsung ke kantor kami di Balige.</p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('kontak') }}" class="btn btn-light btn-lg rounded-pill px-5 shadow-lg btn-hover-lift">
                        <i class="fas fa-envelope me-2"></i>Hubungi Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 btn-hover-lift">
                        <i class="fas fa-user-plus me-2"></i>Daftar sebagai Petani
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="cta-decoration-1"></div>
    <div class="cta-decoration-2"></div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<style>
    /* Modern Color Palette */
    :root {
        --primary-green: #2e7d32;
        --secondary-green: #388e3c;
        --light-green: #4caf50;
        --gradient-start: #1b5e20;
        --gradient-end: #2e7d32;
        --text-dark: #1a202c;
        --text-gray: #4a5568;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
    }

    /* Hero Section Styles */
    .hero-section {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 50%, var(--secondary-green) 100%);
        position: relative;
        min-height: 700px;
        display: flex;
        align-items: center;
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        line-height: 1.2;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .hero-highlight {
        background: linear-gradient(to right, #fff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        line-height: 1.8;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat h4 {
        font-size: 2rem;
        margin-bottom: 0.25rem;
    }

    .hero-image-wrapper {
        position: relative;
    }

    .hero-image-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        height: 120%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
        50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.8; }
    }

    .hero-main-image {
        max-height: 450px;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));
        border-radius: 20px;
    }

    .floating-image {
        animation: floatImage 6s ease-in-out infinite;
    }

    @keyframes floatImage {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .hero-wave svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }

    .hero-badge, .section-badge {
        display: inline-block;
    }

    /* Button Hover Lift Effect */
    .btn-hover-lift {
        transition: all 0.3s ease;
    }

    .btn-hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }

    /* About Section */
    .about-image-wrapper {
        position: relative;
        padding: 20px;
    }

    .about-image-decoration {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        border-radius: 20px;
        transform: rotate(3deg);
        z-index: 0;
    }

    .about-main-image {
        position: relative;
        z-index: 1;
        border-radius: 20px;
    }

    .about-badge {
        position: absolute;
        bottom: 30px;
        left: 30px;
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: var(--shadow-xl);
        text-align: center;
        z-index: 2;
        min-width: 140px;
    }

    .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    .stats-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 20%, rgba(46, 125, 50, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 90% 80%, rgba(46, 125, 50, 0.05) 0%, transparent 50%);
        z-index: 1;
    }

    .stat-card-modern {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--secondary-green));
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-xl);
    }

    .stat-card-modern:hover::before {
        transform: scaleX(1);
    }

    .stat-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: white;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-number-modern {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        color: var(--text-gray);
        font-weight: 500;
    }

    .stat-progress {
        width: 100%;
        height: 6px;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .stat-progress-bar {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
    }

    /* Program Cards */
    .program-card-modern {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .program-card-modern:hover {
        transform: translateY(-15px);
        box-shadow: var(--shadow-xl);
    }

    .program-image-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .program-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .program-card-modern:hover .program-image {
        transform: scale(1.1);
    }

    .program-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.7) 100%);
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .program-card-modern:hover .program-overlay {
        opacity: 1;
    }

    .program-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-green);
    }

    .program-content {
        padding: 2rem;
    }

    .program-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .program-description {
        color: var(--text-gray);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .program-link {
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .program-link:hover {
        color: var(--secondary-green);
        transform: translateX(5px);
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        position: relative;
        color: white;
    }

    .cta-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .cta-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px);
        z-index: 1;
    }

    .cta-decoration-1, .cta-decoration-2 {
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .cta-decoration-1 {
        top: -200px;
        left: -200px;
    }

    .cta-decoration-2 {
        bottom: -200px;
        right: -200px;
    }

    /* Berita Cards */
    .berita-card-modern {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
    }

    .berita-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-xl);
    }

    .berita-image-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .berita-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .berita-card-modern:hover .berita-image {
        transform: scale(1.1);
    }

    .berita-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: rgba(0,0,0,0.2);
    }

    .berita-date-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        border-radius: 12px;
        padding: 0.75rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
        min-width: 60px;
    }

    .berita-day {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-green);
        line-height: 1;
    }

    .berita-month {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-gray);
        text-transform: uppercase;
        margin-top: 0.25rem;
    }

    .berita-content {
        padding: 1.75rem;
    }

    .berita-category {
        margin-bottom: 0.75rem;
    }

    .berita-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        min-height: 3.5rem;
    }

    .berita-excerpt {
        color: var(--text-gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.25rem;
        min-height: 4rem;
    }

    .berita-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .berita-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .berita-read-more {
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .berita-read-more:hover {
        color: var(--secondary-green);
        transform: translateX(3px);
    }

    .berita-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .berita-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-section {
            min-height: 600px;
        }

        .hero-main-image {
            max-height: 350px;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .stat-number-modern {
            font-size: 2rem;
        }

        .stat-icon-wrapper {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .program-image-wrapper {
            height: 200px;
        }

        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1rem;
        }

        .hero-wave svg {
            height: 40px;
        }
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Selection Color */
    ::selection {
        background: var(--primary-green);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Animate counters with easing
    const counters = document.querySelectorAll('.stat-number-modern');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const text = target.textContent;
                const end = parseInt(text.replace(/\D/g, ''));
                
                if (end > 0) {
                    animateValue(target, 0, end, 2000);
                }
                observer.unobserve(target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));

    function animateValue(obj, start, end, duration) {
        const startTime = performance.now();
        
        const update = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function (easeOutExpo)
            const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            const current = Math.floor(start + (end - start) * ease);
            
            obj.textContent = new Intl.NumberFormat('id-ID').format(current);
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                obj.textContent = new Intl.NumberFormat('id-ID').format(end);
            }
        };
        
        requestAnimationFrame(update);
    }

    // Animate progress bars
    const progressBars = document.querySelectorAll('.stat-progress-bar');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.style.width;
                bar.style.width = '0';
                
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
                
                progressObserver.unobserve(bar);
            }
        });
    }, { threshold: 0.5 });

    progressBars.forEach(bar => progressObserver.observe(bar));

    // Parallax effect for hero section
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        
        if (heroSection && scrolled < window.innerHeight) {
            const heroImage = document.querySelector('.hero-main-image');
            if (heroImage) {
                heroImage.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        }
    });

    // Lazy load images with fade-in effect
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.5s ease';
                
                img.onload = () => {
                    img.style.opacity = '1';
                };
                
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));

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

    // Add hover effect to cards
    const cards = document.querySelectorAll('.stat-card-modern, .program-card-modern, .berita-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        });
    });

    // Navbar scroll effect
    const navbar = document.querySelector('.main-header');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            }
        });
    }

    // Add animation to hero stats on scroll
    const heroStats = document.querySelectorAll('.hero-stat');
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, { threshold: 0.5 });

    heroStats.forEach(stat => {
        stat.style.opacity = '0';
        stat.style.transform = 'translateY(20px)';
        stat.style.transition = 'all 0.6s ease';
        statsObserver.observe(stat);
    });

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush