@extends('layouts.guest')

@section('title', $berita->judul . ' - Dinas Pertanian Kabupaten Toba')

@push('styles')
<style>
    /* Hero Header */
    .berita-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        padding: 4rem 0 3rem;
        margin-bottom: -3rem;
        position: relative;
        overflow: hidden;
    }

    .berita-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.5;
    }

    /* Breadcrumb Modern */
    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-modern .breadcrumb-item {
        color: rgba(255,255,255,0.8);
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: white;
        text-decoration: none;
        transition: all 0.3s;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: #ffc107;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: rgba(255,255,255,0.9);
    }

    .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }

    /* Article Container */
    .article-container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-top: 3rem;
    }

    /* Featured Image */
    .featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    /* Article Header */
    .article-header {
        padding: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .article-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        color: #666;
        font-size: 0.95rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .meta-item i {
        color: #2e7d32;
    }

    /* Article Content */
    .article-content {
        padding: 2rem;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content h2,
    .article-content h3,
    .article-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1a1a1a;
        font-weight: 700;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
    }

    /* Share Section */
    .share-section {
        padding: 2rem;
        background: #f8fdf9;
        border-top: 1px solid #e8f5e9;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        border: 2px solid transparent;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .share-btn.facebook {
        background: #1877f2;
        color: white;
    }

    .share-btn.twitter {
        background: #1da1f2;
        color: white;
    }

    .share-btn.whatsapp {
        background: #25d366;
        color: white;
    }

    /* Sidebar */
    .sidebar-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .sidebar-card-header {
        background: linear-gradient(135deg, #2e7d32, #43a047);
        color: white;
        padding: 1.25rem;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .sidebar-card-body {
        padding: 1.5rem;
    }

    /* Related News Item */
    .related-news-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
    }

    .related-news-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .related-news-item:hover {
        transform: translateX(5px);
    }

    .related-news-thumb {
        width: 100px;
        height: 75px;
        border-radius: 12px;
        object-fit: cover;
    }

    .related-news-placeholder {
        width: 100px;
        height: 75px;
        border-radius: 12px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .related-news-content {
        flex: 1;
    }

    .related-news-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .related-news-title a {
        color: #1a1a1a;
        text-decoration: none;
        transition: color 0.3s;
    }

    .related-news-title a:hover {
        color: #2e7d32;
    }

    .related-news-date {
        font-size: 0.85rem;
        color: #999;
    }

    /* Quick Links */
    .quick-link-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        border: 2px solid;
    }

    .quick-link-btn:hover {
        transform: translateX(5px);
    }

    /* Newsletter Form */
    .newsletter-form .form-control {
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        padding: 12px 16px;
        transition: all 0.3s;
    }

    .newsletter-form .form-control:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46,125,50,0.15);
    }

    .newsletter-form .btn-submit {
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        background: linear-gradient(135deg, #2e7d32, #43a047);
        border: none;
        transition: all 0.3s;
    }

    .newsletter-form .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(46,125,50,0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .article-title {
            font-size: 1.8rem;
        }

        .featured-image {
            height: 250px;
        }

        .article-content {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="berita-hero">
    <div class="container position-relative">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-modern">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita') }}">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->judul, 50) }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Article Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Article -->
        <div class="col-lg-8">
            <div class="article-container">
                <!-- Featured Image -->
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                         class="featured-image" 
                         alt="{{ $berita->judul }}">
                @else
                    <div class="featured-image" style="background: linear-gradient(135deg, #2e7d32, #43a047); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-newspaper" style="font-size: 5rem; color: rgba(255,255,255,0.3);"></i>
                    </div>
                @endif

                <!-- Article Header -->
                <div class="article-header">
                    <h1 class="article-title">{{ $berita->judul }}</h1>
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y, H:i') }} WIB</span>
                        </div>
                        @if($berita->kategori)
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <span class="badge bg-success">{{ $berita->kategori }}</span>
                        </div>
                        @endif
                        @if(isset($berita->views))
                        <div class="meta-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ $berita->views }} views</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Article Content -->
                <div class="article-content">
                    {!! $berita->konten !!}
                </div>

                <!-- Share Section -->
                <div class="share-section">
                    <h6 class="mb-3"><i class="fas fa-share-alt me-2"></i>Bagikan Artikel:</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                           target="_blank" 
                           class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($berita->judul) }}"
                           target="_blank" 
                           class="share-btn twitter">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}"
                           target="_blank" 
                           class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Berita Lainnya -->
            <div class="sidebar-card" data-aos="fade-up">
                <div class="sidebar-card-header">
                    <i class="fas fa-newspaper me-2"></i>Berita Lainnya
                </div>
                <div class="sidebar-card-body">
                    @if($beritaLainnya->count() > 0)
                        @foreach($beritaLainnya as $item)
                            <div class="related-news-item">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         class="related-news-thumb" 
                                         alt="{{ $item->judul }}">
                                @else
                                    <div class="related-news-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                                <div class="related-news-content">
                                    <h6 class="related-news-title">
                                        <a href="{{ route('berita.detail', $item->slug) }}">
                                            {{ Str::limit($item->judul, 60) }}
                                        </a>
                                    </h6>
                                    <div class="related-news-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center mb-0">Belum ada berita lainnya.</p>
                    @endif
                </div>
            </div>

            <!-- Newsletter Subscription -->
            <div class="sidebar-card" data-aos="fade-up" data-aos-delay="100">
                <div class="sidebar-card-header">
                    <i class="fas fa-envelope me-2"></i>Langganan Newsletter
                </div>
                <div class="sidebar-card-body">
                    <p class="text-muted mb-3">Dapatkan update informasi terbaru tentang dunia pertanian langsung ke email Anda.</p>
                    <form class="newsletter-form" id="newsletterForm">
                        @csrf
                        <div class="mb-3">
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Masukkan email Anda" 
                                   required>
                        </div>
                        <div class="mb-3">
                            <input type="text" 
                                   class="form-control" 
                                   id="nama" 
                                   name="nama" 
                                   placeholder="Nama (opsional)">
                        </div>
                        <button type="submit" class="btn btn-success btn-submit w-100">
                            <i class="fas fa-paper-plane me-2"></i>Berlangganan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-card" data-aos="fade-up" data-aos-delay="200">
                <div class="sidebar-card-header">
                    <i class="fas fa-link me-2"></i>Link Cepat
                </div>
                <div class="sidebar-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('transparansi.bantuan') }}" class="quick-link-btn btn-outline-success">
                            <i class="fas fa-chart-line"></i>
                            <span>Transparansi Bantuan</span>
                        </a>
                        <a href="{{ route('bantuan.publik') }}" class="quick-link-btn btn-outline-warning">
                            <i class="fas fa-hand-holding-heart"></i>
                            <span>Data Bantuan</span>
                        </a>
                        <a href="{{ route('galeri') }}" class="quick-link-btn btn-outline-info">
                            <i class="fas fa-images"></i>
                            <span>Galeri Foto</span>
                        </a>
                        <a href="{{ route('kontak') }}" class="quick-link-btn btn-outline-primary">
                            <i class="fas fa-envelope"></i>
                            <span>Kontak Kami</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            this.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat berlangganan. Silakan coba lagi.');
    });
});
</script>
@endpush
@endsection
