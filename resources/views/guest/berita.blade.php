@extends('layouts.guest')

@section('title', 'Berita & Informasi Pertanian - Dinas Pertanian Kabupaten Toba')

@push('styles')
<style>
    /* Premium Hero Section */
    .laporan-hero-premium {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        padding: 8rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .hero-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        z-index: 1;
    }

    .particle {
        position: absolute;
        font-size: 3rem;
        opacity: 0.1;
        animation: float-particle 15s infinite;
    }

    .particle-1 { top: 10%; left: 10%; animation-delay: 0s; }
    .particle-2 { top: 60%; left: 80%; animation-delay: 2s; }
    .particle-3 { top: 30%; left: 60%; animation-delay: 4s; }
    .particle-4 { top: 70%; left: 20%; animation-delay: 6s; }
    .particle-5 { top: 40%; left: 90%; animation-delay: 8s; }

    @keyframes float-particle {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }

    .hero-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        margin-bottom: 2rem;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: #ffc107;
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    .hero-title-premium {
        font-size: 4rem;
        font-weight: 900;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.1;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .text-gradient {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle-premium {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.95);
        max-width: 700px;
        margin: 0 auto 2rem;
        line-height: 1.6;
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
        height: 80px;
    }

    /* Berita Cards Grid */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        padding: 3rem 0;
    }

    .berita-card-premium {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .berita-card-premium:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .berita-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .berita-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .berita-card-premium:hover .berita-image-wrapper img {
        transform: scale(1.15);
    }

    .berita-category-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #000;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .berita-date-badge {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        color: #2e7d32;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }

    .berita-content-premium {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .berita-title-premium {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 1rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-title-premium a {
        color: #1a1a1a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .berita-title-premium a:hover {
        color: #2e7d32;
    }

    .berita-excerpt-premium {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .berita-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .berita-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #999;
    }

    .btn-read-premium {
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-read-premium:hover {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        color: white;
    }

    /* Empty State */
    .empty-state-premium {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin: 3rem 0;
    }

    .empty-icon {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #666;
        margin-bottom: 1rem;
    }

    .empty-text {
        font-size: 1.1rem;
        color: #999;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Animations */
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slide-up {
        animation: slideUp 1s ease-out;
    }

    .animate-slide-up-delay {
        animation: slideUp 1s ease-out 0.2s both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Pagination */
    .pagination {
        margin-top: 3rem;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 12px;
        padding: 10px 18px;
        margin: 0 5px;
        border: 2px solid #2e7d32;
        color: #2e7d32;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: #2e7d32;
        color: white;
        transform: translateY(-3px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #2e7d32, #43a047);
        border-color: #2e7d32;
        box-shadow: 0 4px 15px rgba(46,125,50,0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title-premium {
            font-size: 2.5rem;
        }
        
        .berita-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Premium Hero Section -->
<section class="laporan-hero-premium">
    <div class="hero-particles">
        <div class="particle particle-1">📰</div>
        <div class="particle particle-2">📢</div>
        <div class="particle particle-3">📝</div>
        <div class="particle particle-4">📄</div>
        <div class="particle particle-5">📋</div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-badge-premium animate-fade-in">
                    <span class="badge-dot"></span>
                    <span>Update Terkini</span>
                </div>
                <h1 class="hero-title-premium animate-slide-up">
                    Berita &<br>
                    <span class="text-gradient">Informasi Pertanian</span>
                </h1>
                <p class="hero-subtitle-premium animate-slide-up-delay">
                    Update terbaru seputar program, kegiatan, dan perkembangan pertanian di Kabupaten Toba untuk mendukung kesejahteraan petani.
                </p>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#f8fdf9"></path>
        </svg>
    </div>
</section>

<!-- Berita Section -->
<div class="container" style="background: #f8fdf9;">
    @if($beritas->count() > 0)
        <div class="berita-grid">
            @foreach($beritas as $index => $berita)
            <div class="berita-card-premium" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 50) }}">
                <div class="berita-image-wrapper">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=400&fit=crop" alt="{{ $berita->judul }}">
                    @endif
                    <div class="berita-category-badge">
                        <span>🏷️</span>
                        <span>{{ $berita->kategori ?? 'Berita' }}</span>
                    </div>
                    <div class="berita-date-badge">
                        <span>📅</span>
                        <span>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="berita-content-premium">
                    <h3 class="berita-title-premium">
                        <a href="{{ route('berita.detail', $berita->slug) }}">
                            {{ $berita->judul }}
                        </a>
                    </h3>
                    <p class="berita-excerpt-premium">
                        {{ Str::limit(strip_tags($berita->konten), 150) }}
                    </p>
                    <div class="berita-footer">
                        <div class="berita-meta">
                            <span>👁️</span>
                            <span>{{ $berita->views ?? 0 }} views</span>
                        </div>
                        <a href="{{ route('berita.detail', $berita->slug) }}" class="btn-read-premium">
                            Baca
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center pb-5" data-aos="fade-up">
            {{ $beritas->links() }}
        </div>
    @else
        <div class="empty-state-premium" data-aos="fade-up">
            <div class="empty-icon">📰</div>
            <h3 class="empty-title">Belum ada berita tersedia</h3>
            <p class="empty-text">Silakan kembali lagi nanti untuk update informasi terbaru.</p>
        </div>
    @endif
</div>

@endsection
