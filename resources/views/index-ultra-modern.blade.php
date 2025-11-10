@extends('layouts.guest')

@section('title', 'Beranda - Dinas Pertanian Kabupaten Toba')

@push('styles')
<style>
    /* ===== HERO SECTION ===== */
    .hero-ultra-modern {
        min-height: 100vh;
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        background-size: 400% 400%;
        animation: gradient-shift 15s ease infinite;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 8rem 0 4rem;
    }

    .hero-ultra-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.5;
    }

    .hero-ultra-modern::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(255,193,7,0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        color: #fff;
        font-weight: 600;
        margin-bottom: 2rem;
        border: 1px solid rgba(255,255,255,0.2);
        animation: pulse-glow 2s infinite;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .hero-title .highlight {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 2.5rem;
        max-width: 600px;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #000;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 8px 30px rgba(255,193,7,0.4);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-hero-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-hero-primary:hover::before {
        left: 100%;
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(255,193,7,0.5);
        color: #000;
    }

    .btn-hero-secondary {
        padding: 1rem 2.5rem;
        background: transparent;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-hero-secondary:hover {
        background: #fff;
        color: var(--primary-green);
        transform: translateY(-3px);
    }

    .hero-image {
        position: relative;
        z-index: 2;
    }

    .hero-image img {
        width: 100%;
        border-radius: 30px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: float 3s ease-in-out infinite;
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
        height: 100px;
    }

    .hero-wave .shape-fill {
        fill: #f5f7fa;
    }

    /* ===== FEATURES SECTION ===== */
    .features-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 4rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .feature-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(46,125,50,0.1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        border-color: var(--primary-green);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fff;
        box-shadow: 0 8px 25px rgba(46,125,50,0.3);
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: rotateY(360deg);
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2e7d32;
    }

    .feature-description {
        color: #6c757d;
        line-height: 1.8;
    }

    /* ===== STATISTICS SECTION ===== */
    .stats-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .stat-card {
        text-align: center;
        padding: 2rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        color: #ffc107;
        margin-bottom: 0.5rem;
        text-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .stat-label {
        font-size: 1.1rem;
        color: #fff;
        font-weight: 600;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: rgba(255,255,255,0.3);
        margin-bottom: 1rem;
    }

    /* ===== PROGRAMS SECTION ===== */
    .programs-section {
        padding: 6rem 0;
        background: #fff;
    }

    .program-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }

    .program-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .program-image {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .program-card:hover .program-image img {
        transform: scale(1.1);
    }

    .program-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #000;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .program-content {
        padding: 2rem;
    }

    .program-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 1rem;
    }

    .program-description {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .program-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .program-meta-item {
        display: flex;
        align-items: center;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .program-meta-item i {
        color: var(--primary-green);
        margin-right: 0.5rem;
    }

    /* ===== CTA SECTION ===== */
    .cta-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="30" fill="rgba(255,255,255,0.02)"/></svg>');
        opacity: 0.3;
    }

    .cta-content {
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .cta-title {
        font-size: 3rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 1.5rem;
    }

    .cta-subtitle {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 3rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .cta-title {
            font-size: 2rem;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .btn-hero-primary,
        .btn-hero-secondary {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<!-- ===== HERO SECTION ===== -->
<section class="hero-ultra-modern">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-seedling me-2"></i>
                        Sistem Informasi Pertanian Digital
                    </div>
                    <h1 class="hero-title">
                        Selamat Datang di<br>
                        <span class="highlight">Dinas Pertanian<br>Kabupaten Toba</span>
                    </h1>
                    <p class="hero-subtitle">
                        Platform digital modern untuk pengelolaan data pertanian, distribusi bantuan, dan pelaporan hasil panen secara transparan dan efisien.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('bantuan.publik') }}" class="btn btn-hero-primary">
                            <i class="fas fa-hands-helping me-2"></i>Lihat Program Bantuan
                        </a>
                        <a href="{{ route('tentang') }}" class="btn btn-hero-secondary">
                            <i class="fas fa-info-circle me-2"></i>Tentang Kami
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600&h=600&fit=crop" alt="Pertanian Modern" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>
</section>

<!-- ===== FEATURES SECTION ===== -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Fitur Utama Sistem</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Berbagai layanan digital yang memudahkan petani dalam mengakses informasi dan bantuan pertanian
        </p>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="feature-title">Laporan Panen</h3>
                    <p class="feature-description">
                        Laporkan hasil panen Anda secara digital dan transparan untuk data akurat
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="feature-title">Bantuan Pertanian</h3>
                    <p class="feature-description">
                        Akses berbagai program bantuan yang tersedia dengan proses yang mudah dan cepat
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Manajemen Petani</h3>
                    <p class="feature-description">
                        Kelola data petani terintegrasi dalam satu sistem yang terpusat
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Monitoring Real-time</h3>
                    <p class="feature-description">
                        Pantau perkembangan hasil panen dan produktivitas secara real-time
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATISTICS SECTION ===== -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $totalPetani }}">0</div>
                    <div class="stat-label">Petani Terdaftar</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $totalBantuan }}">0</div>
                    <div class="stat-label">Program Bantuan</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $totalLaporan }}">0</div>
                    <div class="stat-label">Laporan Panen</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                    <div class="stat-number" data-count="{{ number_format($totalHasilPanen, 0, ',', '.') }}">0</div>
                    <div class="stat-label">Total Hasil Panen (kg)</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROGRAMS SECTION ===== -->
@if($bantuans && $bantuans->count() > 0)
<section class="programs-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Program Bantuan Terbaru</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Berbagai program bantuan pertanian yang dapat Anda akses untuk meningkatkan produktivitas
        </p>

        <div class="row g-4">
            @foreach($bantuans->take(3) as $index => $bantuan)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                <div class="program-card">
                    <div class="program-image">
                        <img src="https://source.unsplash.com/600x400/?agriculture,farming,{{ $index }}" alt="{{ $bantuan->jenis_bantuan }}">
                        <div class="program-badge">{{ ucfirst($bantuan->status) }}</div>
                    </div>
                    <div class="program-content">
                        <h3 class="program-title">{{ $bantuan->jenis_bantuan }}</h3>
                        <p class="program-description">
                            {{ Str::limit($bantuan->alasan ?? 'Program bantuan pertanian untuk mendukung kesejahteraan petani', 100) }}
                        </p>
                        <div class="program-meta">
                            <div class="program-meta-item">
                                <i class="fas fa-box"></i>
                                <span>{{ $bantuan->jumlah }} unit</span>
                            </div>
                            <div class="program-meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $bantuan->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('bantuan.publik') }}" class="btn btn-hero-primary">
                <i class="fas fa-arrow-right me-2"></i>Lihat Semua Program
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===== CTA SECTION ===== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title" data-aos="fade-up">
                Bergabunglah Dengan Kami
            </h2>
            <p class="cta-subtitle" data-aos="fade-up" data-aos-delay="100">
                Daftarkan diri Anda sekarang dan nikmati berbagai kemudahan dalam mengelola data pertanian Anda secara digital
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register') }}" class="btn btn-hero-primary">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('kontak') }}" class="btn btn-hero-secondary">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Counter Animation
    function animateCounter() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString('id-ID');
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString('id-ID');
                }
            };

            updateCounter();
        });
    }

    // Trigger counter animation when stats section is in view
    const statsSection = document.querySelector('.stats-section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    if (statsSection) {
        observer.observe(statsSection);
    }
</script>
@endpush
