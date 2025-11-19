@extends('layouts.app')

@section('title', 'Kelola Berita - Sistem Pertanian Toba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
<style>
    .page-header-berita {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 40px rgba(139, 92, 246, 0.3);
        position: relative;
        overflow: hidden;
    }
    .page-header-berita::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .berita-card {
        border-radius: 16px;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .berita-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .berita-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    .berita-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .berita-card:hover .berita-card-image img {
        transform: scale(1.1);
    }
    .berita-status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(10px);
    }
    .berita-status-published {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }
    .berita-status-draft {
        background: rgba(107, 114, 128, 0.9);
        color: white;
    }
    .berita-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .berita-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .berita-excerpt {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }
    .berita-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #f3f4f6;
        margin-bottom: 1rem;
    }
    .berita-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.8rem;
    }
    .berita-actions {
        display: flex;
        gap: 0.5rem;
    }
    .berita-action-btn {
        flex: 1;
        padding: 0.625rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .berita-action-btn:hover {
        transform: translateY(-2px);
    }
    .btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    .btn-toggle {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .btn-toggle-draft {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-berita">
        <div class="row align-items-center position-relative">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="welcome-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div>
                        <h1 class="mb-2" style="font-size: 2rem; font-weight: 800;">
                            Manajemen Berita
                        </h1>
                        <p class="mb-0" style="font-size: 1rem; opacity: 0.95;">
                            <i class="fas fa-rss me-2"></i>
                            Kelola berita dan informasi pertanian
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 position-relative">
                <a href="{{ route('admin.berita.create') }}" class="btn-modern-primary">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Berita Baru
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
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <span class="trend-badge primary">
                            <i class="fas fa-list"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Total Berita</h6>
                        <h2 class="stat-value">{{ $beritas->total() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-newspaper me-1"></i>
                            Semua artikel
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
                        <h2 class="stat-value">{{ \App\Models\Berita::where('status', 'published')->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-globe me-1"></i>
                            Berita publik
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
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="trend-badge warning">
                            <i class="fas fa-edit"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Draft</h6>
                        <h2 class="stat-value">{{ \App\Models\Berita::where('status', 'draft')->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-clock me-1"></i>
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
                        <h2 class="stat-value">{{ \App\Models\Berita::whereMonth('created_at', now()->month)->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-plus me-1"></i>
                            Berita baru
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
                               placeholder="Cari judul atau konten berita...">
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

    <!-- Berita Grid -->
    @if($beritas->count() > 0)
        <div class="row g-4 mb-4" id="beritaGrid">
            @foreach($beritas as $berita)
            <div class="col-lg-4 col-md-6 berita-item" data-status="{{ $berita->status }}">
                <div class="berita-card">
                    <div class="berita-card-image">
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-image fa-4x text-white opacity-50"></i>
                            </div>
                        @endif
                        <span class="berita-status-badge berita-status-{{ $berita->status }}">
                            <i class="fas fa-{{ $berita->status === 'published' ? 'check-circle' : 'clock' }} me-1"></i>
                            {{ $berita->status === 'published' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    <div class="berita-card-body">
                        <h3 class="berita-title">{{ $berita->judul }}</h3>
                        <p class="berita-excerpt">{{ Str::limit(strip_tags($berita->konten), 150) }}</p>
                        <div class="berita-meta">
                            <div class="berita-date">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') : 'Belum dipublikasi' }}</span>
                            </div>
                        </div>
                        <div class="berita-actions">
                            <a href="{{ route('admin.berita.show', $berita->id) }}" class="berita-action-btn btn-view">
                                <i class="fas fa-eye"></i>
                                Lihat
                            </a>
                            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="berita-action-btn btn-edit">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                        </div>
                        <div class="berita-actions mt-2">
                            <form action="{{ route('admin.berita.toggle-status', $berita->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="berita-action-btn w-100 {{ $berita->status === 'published' ? 'btn-toggle-draft' : 'btn-toggle' }}">
                                    <i class="fas fa-{{ $berita->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                    {{ $berita->status === 'published' ? 'Unpublish' : 'Publish' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.berita.destroy', $berita->id) }}" 
                                  method="POST" 
                                  class="flex-fill"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita {{ $berita->judul }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="berita-action-btn w-100 btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </button>
                            </form>
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
                Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }} berita
            </div>
            <div class="pagination-links">
                {{ $beritas->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-modern">
            <div class="empty-state-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3 class="empty-state-title">Belum Ada Berita</h3>
            <p class="empty-state-desc">
                Mulai dengan menambahkan berita pertanian pertama Anda
            </p>
            <a href="{{ route('admin.berita.create') }}" class="btn-modern-primary mt-3">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Berita Pertama
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Live Search & Filter
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const beritaItems = document.querySelectorAll('.berita-item');
    
    function filterBerita() {
        const searchValue = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        
        beritaItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            const status = item.getAttribute('data-status');
            
            const matchesSearch = text.includes(searchValue);
            const matchesStatus = statusValue === '' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    function sortBerita() {
        const sortValue = sortFilter.value;
        const grid = document.getElementById('beritaGrid');
        const items = Array.from(beritaItems);
        
        items.sort((a, b) => {
            const titleA = a.querySelector('.berita-title').textContent;
            const titleB = b.querySelector('.berita-title').textContent;
            const dateA = a.querySelector('.berita-date span').textContent;
            const dateB = b.querySelector('.berita-date span').textContent;
            
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
        
        items.forEach(item => grid.appendChild(item));
        filterBerita(); // Reapply filters
    }
    
    // Event Listeners
    searchInput.addEventListener('keyup', filterBerita);
    statusFilter.addEventListener('change', filterBerita);
    sortFilter.addEventListener('change', sortBerita);
    
    // Card Animation on Load
    document.addEventListener('DOMContentLoaded', function() {
        beritaItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush

@endsection
