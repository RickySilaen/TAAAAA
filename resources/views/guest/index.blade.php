@section('styles')
<style>
    :root {
        --green: #27ae60;
        --dark-green: #1e8449;
        --yellow: #ffb300;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    /* Hero Section */
    .hero-section {
        min-height: 90vh;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                    url('{{ asset('images/hero-toba.jpeg') }}') center/cover no-repeat;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-bottom-left-radius: 40% 12%;
        border-bottom-right-radius: 40% 12%;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(39, 174, 96, 0.1);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 800;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .hero-section h2 {
        font-size: 2.5rem;
        color: var(--yellow);
        text-shadow: 0 2px 8px rgba(0,0,0,0.4);
    }

    .hero-buttons .btn {
        font-weight: 600;
        min-width: 180px;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .hero-buttons .btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3) !important;
    }

    .btn-warning {
        background: var(--yellow) !important;
        color: #000 !important;
        border: none;
    }

    .btn-warning:hover {
        background: #e6a000 !important;
    }

    /* Wave Bottom */
    .wave-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        line-height: 0;
    }

    /* About Section */
    .about-section {
        padding: 80px 0;
        background: white;
    }

    .about-section h2 {
        color: var(--green);
        font-weight: 700;
    }

    .about-section img {
        max-height: 380px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .btn-success {
        background: var(--green);
        border: none;
        padding: 0.75rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: var(--dark-green);
        transform: translateY(-3px);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-section {
            min-height: 80vh;
            text-align: center;
        }
        .hero-section h1 { font-size: 2.5rem; }
        .hero-section h2 { font-size: 2rem; }
    }

    @media (max-width: 768px) {
        .hero-section {
            background-attachment: scroll;
            min-height: 70vh;
            border-radius: 0;
        }
        .hero-section h1 { font-size: 2rem; }
        .hero-section h2 { font-size: 1.8rem; }
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        .hero-buttons .btn {
            width: 100%;
            max-width: 280px;
        }
        .about-section {
            text-align: center;
        }
        .about-section img {
            margin-top: 20px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row justify-content-center text-center text-lg-start">
            <div class="col-lg-10 col-xl-8">
                <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">
                    Selamat Datang di Sistem Informasi Dinas Pertanian
                </h1>
                <h2 class="display-5 fw-bold mb-4 text-warning animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
                    Kabupaten Toba
                </h2>
                <p class="lead mb-5 opacity-90 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                    Mendukung peningkatan sektor pertanian melalui inovasi digital dan pelayanan terpadu kepada masyarakat.
                </p>
                <div class="hero-buttons d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                    <a href="{{ route('bantuan.publik') }}" class="btn btn-light btn-lg shadow-sm">
                        Lihat Bantuan
                    </a>
                    <a href="{{ route('laporan.publik') }}" class="btn btn-outline-light btn-lg shadow-sm">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-warning btn-lg shadow-sm">
                        Login Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="wave-bottom">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 80px;">
            <path d="M0,0V46.3c47.8,19.5,119.5,39,215.3,39C311.1,85.3,383,65.8,454.9,46.3C526.8,26.8,598.7,7.3,670.6,7.3c71.9,0,143.8,19.5,215.7,39V0H0Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- Tentang Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 order-lg-1 order-2">
                <h2 class="fw-bold mb-4">Tentang Dinas Pertanian</h2>
                <p class="text-muted lead mb-4">
                    Dinas Pertanian Kabupaten Toba berkomitmen untuk meningkatkan kesejahteraan petani melalui program
                    pembangunan pertanian berkelanjutan. Dengan semangat gotong royong dan pemanfaatan teknologi,
                    kami hadir untuk mendukung ketahanan pangan dan produktivitas pertanian di wilayah Toba.
                </p>
                <div class="text-end mt-2">
                    <small class="text-muted">Kegiatan Pertanian Toba</small>
                </div>
                <a href="{{ route('tentang') }}" class="btn btn-success shadow-sm mt-3 d-inline-block">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            <div class="col-lg-5 order-lg-2 order-1 text-center">
                <img src="{{ asset('images/kegiatan-pertanian.png') }}"
                     alt="Kegiatan Pertanian Toba"
                     class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
