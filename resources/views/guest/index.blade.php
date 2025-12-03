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

    /* Card Hover Effects */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2) !important;
    }

    /* News Card Styles */
    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        position: relative;
        overflow: hidden;
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

<!-- Features Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="text-center text-white mb-5">
            <h2 class="fw-bold mb-3">Layanan Kami</h2>
            <p class="lead mb-0">Berbagai fitur untuk mendukung transparansi dan produktivitas pertanian</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg" style="border-radius: 15px; transition: transform 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-hands-helping fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">Bantuan Pertanian</h5>
                        <p class="card-text text-muted">Informasi program bantuan untuk petani Kabupaten Toba</p>
                        <a href="{{ route('bantuan.publik') }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg" style="border-radius: 15px; transition: transform 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-file-alt fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Laporan Panen</h5>
                        <p class="card-text text-muted">Data hasil panen dan produktivitas pertanian</p>
                        <a href="{{ route('laporan.publik') }}" class="btn btn-outline-success btn-sm">Lihat Laporan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg" style="border-radius: 15px; transition: transform 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-eye fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold">Transparansi Bantuan</h5>
                        <p class="card-text text-muted">Pantau penyaluran bantuan secara transparan</p>
                        <a href="{{ route('transparansi.bantuan') }}" class="btn btn-outline-info btn-sm">Lihat Transparansi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg" style="border-radius: 15px; transition: transform 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-newspaper fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title fw-bold">Berita & Informasi</h5>
                        <p class="card-text text-muted">Update berita dan informasi terkini pertanian</p>
                        <a href="{{ route('berita') }}" class="btn btn-outline-warning btn-sm">Baca Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--green);">Berita & Informasi Pertanian</h2>
            <p class="text-muted">Informasi terbaru seputar pertanian di Kabupaten Toba</p>
        </div>
        
        @php
            $beritas = \App\Models\Berita::where('status', 'published')
                ->latest()
                ->take(3)
                ->get();
        @endphp

        @if($beritas->count() > 0)
        <div class="row g-4">
            @foreach($beritas as $berita)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                    @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                         class="card-img-top" 
                         alt="{{ $berita->judul }}"
                         style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-gradient" style="height: 200px; background: linear-gradient(135deg, var(--green), var(--dark-green)); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-newspaper fa-4x text-white opacity-50"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-success">{{ $berita->kategori ?? 'Umum' }}</span>
                            <small class="text-muted ms-2">
                                <i class="fas fa-calendar-alt"></i> {{ $berita->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <h5 class="card-title fw-bold">{{ Str::limit($berita->judul, 60) }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                        <a href="{{ route('berita.detail', $berita->slug) }}" class="btn btn-outline-success btn-sm">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('berita') }}" class="btn btn-success btn-lg">
                Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada berita tersedia</p>
        </div>
        @endif
    </div>
</section>

<!-- Statistik Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--green), var(--dark-green));">
    <div class="container">
        <div class="text-center text-white mb-5">
            <h2 class="fw-bold mb-3">Statistik Sistem</h2>
            <p class="lead mb-0">Data real-time sistem informasi pertanian</p>
        </div>
        <div class="row g-4 text-center text-white">
            <div class="col-md-3 col-6">
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h2 class="fw-bold mb-2">{{ \App\Models\User::where('role', 'petani')->count() }}</h2>
                    <p class="mb-0 opacity-75">Petani Terdaftar</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <i class="fas fa-hands-helping fa-3x mb-3"></i>
                    <h2 class="fw-bold mb-2">{{ \App\Models\Bantuan::count() }}</h2>
                    <p class="mb-0 opacity-75">Program Bantuan</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                    <h2 class="fw-bold mb-2">{{ \App\Models\Laporan::count() }}</h2>
                    <p class="mb-0 opacity-75">Laporan Panen</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4" style="background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <i class="fas fa-eye fa-3x mb-3"></i>
                    <h2 class="fw-bold mb-2">{{ \App\Models\LaporanBantuan::where('is_public', true)->count() }}</h2>
                    <p class="mb-0 opacity-75">Laporan Transparan</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
