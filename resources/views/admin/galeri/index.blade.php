@extends('layouts.app')

@section('title', 'Kelola Galeri - Sistem Pertanian Toba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
<style>
    .page-header-galeri {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
        position: relative;
        overflow: hidden;
    }
    .page-header-galeri::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .galeri-item {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }
    .galeri-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .galeri-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    }
    .galeri-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .galeri-item:hover .galeri-image {
        transform: scale(1.15);
    }
    .galeri-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%);
        opacity: 0;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
    }
    .galeri-item:hover .galeri-overlay {
        opacity: 1;
    }
    .galeri-quick-actions {
        display: flex;
        gap: 0.75rem;
    }
    .galeri-action-btn {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        color: white;
        text-decoration: none;
        transform: translateY(20px);
        opacity: 0;
    }
    .galeri-item:hover .galeri-action-btn {
        transform: translateY(0);
        opacity: 1;
    }
    .galeri-item:hover .galeri-action-btn:nth-child(1) { transition-delay: 0.1s; }
    .galeri-item:hover .galeri-action-btn:nth-child(2) { transition-delay: 0.15s; }
    .galeri-item:hover .galeri-action-btn:nth-child(3) { transition-delay: 0.2s; }
    
    .btn-zoom {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    .btn-zoom:hover {
        transform: translateY(0) scale(1.1);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.4);
    }
    .btn-edit-galeri {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .btn-edit-galeri:hover {
        transform: translateY(0) scale(1.1);
        box-shadow: 0 8px 16px rgba(245, 158, 11, 0.4);
    }
    .btn-delete-galeri {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    .btn-delete-galeri:hover {
        transform: translateY(0) scale(1.1);
        box-shadow: 0 8px 16px rgba(239, 68, 68, 0.4);
    }
    
    .galeri-info {
        padding: 1.25rem;
    }
    .galeri-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .galeri-desc {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }
    .galeri-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 2px solid #f3f4f6;
    }
    .galeri-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
    .galeri-status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-published {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .status-draft {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }
    
    /* Lightbox Modal */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }
    .lightbox-content {
        position: relative;
        margin: auto;
        padding: 2rem;
        width: 90%;
        max-width: 1200px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    .lightbox-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        font-size: 2.5rem;
        color: white;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.1);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-galeri">
        <div class="row align-items-center position-relative">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="welcome-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h1 class="mb-2" style="font-size: 2rem; font-weight: 800;">
                            Manajemen Galeri
                        </h1>
                        <p class="mb-0" style="font-size: 1rem; opacity: 0.95;">
                            <i class="fas fa-camera me-2"></i>
                            Kelola galeri foto kegiatan pertanian
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 position-relative">
                <a href="{{ route('admin.galeri.create') }}" class="btn-modern-primary">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Foto Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-modern alert-modern-success mb-4 animate-fade-in">
            <i class="fas fa-check-circle"></i>
            <div>
                <div class="fw-bold">Berhasil!</div>
                <small>{{ session('success') }}</small>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-modern alert-modern-danger mb-4 animate-fade-in">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <div class="fw-bold">Error!</div>
                <small>{{ session('error') }}</small>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-images"></i>
                        </div>
                        <span class="trend-badge primary">
                            <i class="fas fa-photo-video"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Total Foto</h6>
                        <h2 class="stat-value">{{ $galeris->total() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-images me-1"></i>
                            Semua foto
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="trend-badge success">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Published</h6>
                        <h2 class="stat-value">{{ \App\Models\Galeri::where('status', 'published')->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-globe me-1"></i>
                            Foto publik
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="trend-badge warning">
                            <i class="fas fa-hourglass-half"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Draft</h6>
                        <h2 class="stat-value">{{ \App\Models\Galeri::where('status', 'draft')->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-edit me-1"></i>
                            Belum publish
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <span class="trend-badge info">
                            <i class="fas fa-calendar"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Bulan Ini</h6>
                        <h2 class="stat-value">{{ \App\Models\Galeri::whereMonth('created_at', now()->month)->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-plus me-1"></i>
                            Foto baru
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="modern-card mb-4">
        <div class="modern-card-body">
            <div class="row g-3 align-items-end">
                <div class="col-lg-6">
                    <label class="form-label fw-bold text-sm text-gray-700 mb-2">
                        <i class="fas fa-search me-1"></i> Pencarian
                    </label>
                    <div class="search-box-modern">
                        <i class="fas fa-search"></i>
                        <input type="text" 
                               class="form-control" 
                               id="searchInput" 
                               placeholder="Cari judul atau deskripsi foto...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-bold text-sm text-gray-700 mb-2">
                        <i class="fas fa-filter me-1"></i> Status
                    </label>
                    <select class="form-select form-select-modern" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-bold text-sm text-gray-700 mb-2">
                        <i class="fas fa-sort me-1"></i> Urutkan
                    </label>
                    <select class="form-select form-select-modern" id="sortFilter">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title">Judul (A-Z)</option>
                        <option value="title-desc">Judul (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Grid -->
    @if($galeris->count() > 0)
        <div class="row g-4 mb-4" id="galeriGrid">
            @foreach($galeris as $galeri)
            <div class="col-lg-3 col-md-4 col-sm-6 galeri-col" data-status="{{ $galeri->status }}">
                <div class="galeri-item">
                    <div class="galeri-image-wrapper">
                        <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                             alt="{{ $galeri->judul }}" 
                             class="galeri-image">
                        <div class="galeri-overlay">
                            <div class="galeri-quick-actions">
                                <button class="galeri-action-btn btn-zoom" 
                                        onclick="openLightbox('{{ asset('storage/' . $galeri->gambar) }}')">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <a href="{{ route('admin.galeri.edit', $galeri->id) }}" 
                                   class="galeri-action-btn btn-edit-galeri">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto {{ $galeri->judul }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="galeri-action-btn btn-delete-galeri">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="galeri-info">
                        <h3 class="galeri-title">{{ $galeri->judul }}</h3>
                        <p class="galeri-desc">{{ $galeri->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        <div class="galeri-meta">
                            <div class="galeri-date">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}</span>
                            </div>
                            <span class="galeri-status-badge status-{{ $galeri->status }}">
                                {{ $galeri->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-modern">
            <div class="pagination-info">
                <i class="fas fa-info-circle me-2"></i>
                Menampilkan {{ $galeris->firstItem() }} - {{ $galeris->lastItem() }} dari {{ $galeris->total() }} foto
            </div>
            <div class="pagination-links">
                {{ $galeris->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-modern">
            <div class="empty-state-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="empty-state-title">Belum Ada Foto di Galeri</h3>
            <p class="empty-state-desc">
                Mulai dengan menambahkan foto kegiatan pertanian pertama Anda
            </p>
            <a href="{{ route('admin.galeri.create') }}" class="btn-modern-primary mt-3">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Foto Pertama
            </a>
        </div>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <div class="lightbox-content">
        <img id="lightboxImage" class="lightbox-image" src="">
    </div>
</div>

@push('scripts')
<script>
    // Live Search & Filter
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const galeriCols = document.querySelectorAll('.galeri-col');
    
    function filterGaleri() {
        const searchValue = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        
        galeriCols.forEach(col => {
            const text = col.textContent.toLowerCase();
            const status = col.getAttribute('data-status');
            
            const matchesSearch = text.includes(searchValue);
            const matchesStatus = statusValue === '' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                col.style.display = '';
            } else {
                col.style.display = 'none';
            }
        });
    }
    
    function sortGaleri() {
        const sortValue = sortFilter.value;
        const grid = document.getElementById('galeriGrid');
        const cols = Array.from(galeriCols);
        
        cols.sort((a, b) => {
            const titleA = a.querySelector('.galeri-title').textContent;
            const titleB = b.querySelector('.galeri-title').textContent;
            const dateA = a.querySelector('.galeri-date span').textContent;
            const dateB = b.querySelector('.galeri-date span').textContent;
            
            if (sortValue === 'newest') {
                return dateB.localeCompare(dateA);
            } else if (sortValue === 'oldest') {
                return dateA.localeCompare(dateB);
            } else if (sortValue === 'title') {
                return titleA.localeCompare(titleB);
            } else if (sortValue === 'title-desc') {
                return titleB.localeCompare(titleA);
            }
        });
        
        cols.forEach(col => grid.appendChild(col));
        filterGaleri(); // Reapply filters
    }
    
    // Event Listeners
    searchInput.addEventListener('keyup', filterGaleri);
    statusFilter.addEventListener('change', filterGaleri);
    sortFilter.addEventListener('change', sortGaleri);
    
    // Lightbox Functions
    function openLightbox(imageSrc) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImage');
        img.src = imageSrc;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Close lightbox on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
    
    // Prevent closing when clicking on image
    document.getElementById('lightboxImage').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Card Animation on Load
    document.addEventListener('DOMContentLoaded', function() {
        galeriCols.forEach((col, index) => {
            col.style.opacity = '0';
            col.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                col.style.transition = 'all 0.5s ease';
                col.style.opacity = '1';
                col.style.transform = 'translateY(0)';
            }, index * 80);
        });
    });
</script>
@endpush

@endsection
