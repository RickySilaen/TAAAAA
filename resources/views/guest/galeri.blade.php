@extends('layouts.guest')

@section('title', 'Galeri Kegiatan Pertanian - Dinas Pertanian Kabupaten Toba')

@push('styles')
<style>
    /* Hero Section */
    .galeri-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        padding: 5rem 0 4rem;
        margin-bottom: -3rem;
        position: relative;
        overflow: hidden;
    }

    .galeri-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 20px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Gallery Container */
    .gallery-container {
        margin-top: 3rem;
    }

    /* Gallery Card */
    .gallery-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        height: 100%;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        border-color: #2e7d32;
    }

    /* Image Container */
    .gallery-image-container {
        position: relative;
        overflow: hidden;
        height: 280px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .gallery-image {
        transform: scale(1.1);
    }

    /* Overlay */
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .view-icon {
        width: 70px;
        height: 70px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #2e7d32;
        transform: scale(0);
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .view-icon {
        transform: scale(1);
    }

    /* Card Body */
    .gallery-card-body {
        padding: 1.5rem;
    }

    .gallery-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        min-height: 50px;
    }

    .gallery-description {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .gallery-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #888;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .meta-item i {
        color: #2e7d32;
        width: 16px;
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-top: 3rem;
    }

    .empty-icon {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
    }

    .empty-text {
        font-size: 1.1rem;
        color: #666;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 10px;
        margin: 0 5px;
        border: 2px solid #e0e0e0;
        color: #2e7d32;
        font-weight: 600;
        transition: all 0.3s;
    }

    .pagination .page-link:hover {
        background: #2e7d32;
        color: white;
        border-color: #2e7d32;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: #2e7d32;
        border-color: #2e7d32;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #2e7d32, #43a047);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 700;
    }

    .modal-body {
        padding: 2rem;
    }

    #modalImage {
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }

    #modalTitle {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 1.5rem 0 0.5rem;
    }

    #modalDescription {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .gallery-image-container {
            height: 220px;
        }

        .gallery-title {
            min-height: auto;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="galeri-hero">
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <h1 class="hero-title">
                <i class="fas fa-images me-3"></i>Galeri Kegiatan Pertanian
            </h1>
            <p class="hero-subtitle">
                Dokumentasi visual kegiatan dan program pertanian di Kabupaten Toba
            </p>
        </div>
    </div>
</section>

<!-- Gallery Content -->
<div class="container gallery-container">
    @if($galeris->count() > 0)
        <div class="row g-4">
            @foreach($galeris as $index => $galeri)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="gallery-card" onclick="openModal('{{ $galeri->gambar ? asset('storage/' . $galeri->gambar) : '' }}', '{{ addslashes($galeri->judul) }}', '{{ addslashes($galeri->deskripsi ?? '') }}', '{{ $galeri->lokasi ?? '' }}', '{{ \Carbon\Carbon::parse($galeri->created_at)->format('d F Y') }}')">
                        <div class="gallery-image-container">
                            @if($galeri->gambar)
                                <img src="{{ asset('storage/' . $galeri->gambar) }}"
                                     class="gallery-image"
                                     alt="{{ $galeri->judul }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-image" style="font-size: 4rem; color: rgba(46,125,50,0.3);"></i>
                                </div>
                            @endif
                            <div class="gallery-overlay">
                                <div class="view-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-card-body">
                            <h6 class="gallery-title">{{ $galeri->judul }}</h6>
                            @if($galeri->deskripsi)
                                <p class="gallery-description">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                            @endif
                            <div class="gallery-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}</span>
                                </div>
                                @if($galeri->lokasi)
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $galeri->lokasi }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $galeris->links() }}
        </div>
    @else
        <div class="empty-state" data-aos="fade-up">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="empty-title">Galeri Masih Kosong</h3>
            <p class="empty-text">Galeri akan segera diisi dengan dokumentasi kegiatan pertanian.</p>
        </div>
    @endif
</div>

<!-- Modal untuk melihat gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image me-2"></i>Detail Foto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid mb-3" style="max-height: 70vh;">
                <h4 id="modalTitle"></h4>
                <p id="modalDescription" class="mb-3"></p>
                <div class="d-flex justify-content-center gap-4 text-muted">
                    <span id="modalDate"><i class="fas fa-calendar-alt me-2"></i><span id="modalDateText"></span></span>
                    <span id="modalLocation" style="display: none;"><i class="fas fa-map-marker-alt me-2"></i><span id="modalLocationText"></span></span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal(imageSrc, title, description, location, date) {
    if (!imageSrc) {
        imageSrc = 'data:image/svg+xml,<svg width="800" height="600" xmlns="http://www.w3.org/2000/svg"><rect width="100%" height="100%" fill="%23e8f5e9"/><text x="50%" y="50%" font-size="48" fill="%232e7d32" text-anchor="middle" dy=".3em">No Image</text></svg>';
    }
    
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('modalDateText').textContent = date;
    
    const locationElement = document.getElementById('modalLocation');
    if (location) {
        document.getElementById('modalLocationText').textContent = location;
        locationElement.style.display = 'inline';
    } else {
        locationElement.style.display = 'none';
    }

    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endpush
@endsection
