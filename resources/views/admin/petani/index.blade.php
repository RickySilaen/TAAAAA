@extends('layouts.app')

@section('title', 'Kelola Petani - Sistem Pertanian Toba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
<style>
    /* Page-specific modern styles */
    .page-header-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .page-header-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .search-box-modern {
        position: relative;
    }
    
    .search-box-modern input {
        padding-left: 3rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .search-box-modern input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .search-box-modern i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
    }
    
    .table-modern-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }
    
    .table-modern thead {
        background: linear-gradient(to right, #f9fafb, #f3f4f6);
    }
    
    .table-modern thead th {
        color: #374151;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1.25rem 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table-modern tbody td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.01);
    }
    
    .avatar-modern-table {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 1.125rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
    }
    
    .badge-verified {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .action-btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: white;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .action-btn-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .action-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .action-btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-tab {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        background: white;
        border: 2px solid #e5e7eb;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-tab:hover {
        border-color: #10b981;
        color: #10b981;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-color: transparent;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: #9ca3af;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="row align-items-center position-relative">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="welcome-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h1 class="mb-2" style="font-size: 2rem; font-weight: 800;">
                            Manajemen Petani
                        </h1>
                        <p class="mb-0" style="font-size: 1rem; opacity: 0.95;">
                            <i class="fas fa-info-circle me-2"></i>
                            Kelola dan monitoring akun petani dalam sistem
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 position-relative">
                <a href="{{ route('admin.petani.create') }}" class="btn-modern-success">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Petani Baru
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
    
    @if(session('warning'))
        <div class="alert-modern alert-modern-warning mb-4 animate-fade-in">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <div class="fw-bold">Peringatan!</div>
                <small>{{ session('warning') }}</small>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="trend-badge success">
                            <i class="fas fa-arrow-up"></i> 100%
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Total Petani</h6>
                        <h2 class="stat-value">{{ $petani->total() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-user-check me-1"></i>
                            Terdaftar dalam sistem
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
                            <i class="fas fa-user-check"></i>
                        </div>
                        <span class="trend-badge success">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Terverifikasi</h6>
                        <h2 class="stat-value">{{ $petani->where('is_verified', true)->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-shield-alt me-1"></i>
                            Petani verified
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
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <span class="trend-badge warning">
                            <i class="fas fa-clock"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Belum Verifikasi</h6>
                        <h2 class="stat-value">{{ $petani->where('is_verified', false)->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Menunggu verifikasi
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern">
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="trend-badge info">
                            <i class="fas fa-calendar"></i>
                        </span>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Bulan Ini</h6>
                        <h2 class="stat-value">{{ \App\Models\User::where('role', 'petani')->whereMonth('created_at', now()->month)->count() }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-user-plus me-1"></i>
                            Petani baru bergabung
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
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
                               placeholder="Cari nama, email, atau alamat petani...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-bold text-sm text-gray-700 mb-2">
                        <i class="fas fa-filter me-1"></i> Status
                    </label>
                    <select class="form-select form-select-modern" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="verified">Terverifikasi</option>
                        <option value="pending">Belum Verifikasi</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-bold text-sm text-gray-700 mb-2">
                        <i class="fas fa-sort me-1"></i> Urutkan
                    </label>
                    <select class="form-select form-select-modern" id="sortFilter">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="name">Nama (A-Z)</option>
                        <option value="name-desc">Nama (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-modern-wrapper">
        @if($petani->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern mb-0" id="petaniTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Petani</th>
                            <th width="20%">Kontak</th>
                            <th width="20%">Alamat</th>
                            <th width="12%">Status</th>
                            <th width="10%">Bergabung</th>
                            <th width="8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($petani as $index => $p)
                            <tr>
                                <td>
                                    <div class="fw-bold text-gray-700">
                                        {{ $petani->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($p->profile_picture)
                                            <img src="{{ asset('storage/' . $p->profile_picture) }}" 
                                                 alt="{{ $p->name }}"
                                                 class="avatar-modern-table"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="avatar-modern-table">
                                                {{ strtoupper(substr($p->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-gray-900">{{ $p->name }}</div>
                                            <small class="text-gray-500">ID: #{{ $p->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <i class="fas fa-envelope text-gray-400 me-2"></i>
                                        <span class="text-gray-700">{{ $p->email }}</span>
                                    </div>
                                    @if($p->telepon)
                                        <div>
                                            <i class="fas fa-phone text-gray-400 me-2"></i>
                                            <span class="text-gray-700">{{ $p->telepon }}</span>
                                        </div>
                                    @else
                                        <small class="text-gray-400">Telepon tidak tersedia</small>
                                    @endif
                                </td>
                                <td>
                                    @if($p->alamat_kecamatan || $p->alamat_desa)
                                        <div class="mb-1">
                                            <i class="fas fa-map-marker-alt text-success me-2"></i>
                                            <strong class="text-gray-900">{{ $p->alamat_kecamatan ?? '-' }}</strong>
                                        </div>
                                        <small class="text-gray-500">{{ $p->alamat_desa ?? '-' }}</small>
                                    @else
                                        <small class="text-gray-400">Alamat tidak tersedia</small>
                                    @endif
                                </td>
                                <td>
                                    @if($p->is_verified)
                                        <span class="badge-verified">
                                            <i class="fas fa-check-circle"></i>
                                            Verified
                                        </span>
                                    @else
                                        <span class="badge-pending">
                                            <i class="fas fa-clock"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-gray-700 fw-600">
                                        {{ $p->created_at->format('d M Y') }}
                                    </div>
                                    <small class="text-gray-500">
                                        {{ $p->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td>
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.petani.show', $p->id) }}" 
                                           class="action-btn action-btn-info"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.petani.edit', $p->id) }}" 
                                           class="action-btn action-btn-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="action-btn action-btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $p->id }}"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 16px; border: none;">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 16px 16px 0 0;">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                Konfirmasi Hapus
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="text-gray-700 mb-3">Apakah Anda yakin ingin menghapus petani:</p>
                                            <div class="alert-modern alert-modern-warning mb-3">
                                                <i class="fas fa-user"></i>
                                                <div>
                                                    <div class="fw-bold">{{ $p->name }}</div>
                                                    <small>{{ $p->email }}</small>
                                                </div>
                                            </div>
                                            <div class="alert-modern alert-modern-danger">
                                                <i class="fas fa-info-circle"></i>
                                                <div>
                                                    <div class="fw-bold">Peringatan!</div>
                                                    <small>Petani dengan data laporan/bantuan tidak dapat dihapus. Aksi ini tidak dapat dibatalkan!</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #f3f4f6;">
                                            <button type="button" class="btn-modern-outline" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Batal
                                            </button>
                                            <form action="{{ route('admin.petani.destroy', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600;">
                                                    <i class="fas fa-trash me-1"></i> Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4" style="background: #f9fafb; border-top: 1px solid #e5e7eb;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-gray-600">
                        Menampilkan <strong>{{ $petani->firstItem() }}</strong> - <strong>{{ $petani->lastItem() }}</strong> 
                        dari <strong>{{ $petani->total() }}</strong> petani
                    </div>
                    <div>
                        {{ $petani->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="text-gray-900 fw-bold mb-2">Belum Ada Petani Terdaftar</h4>
                <p class="text-gray-500 mb-4">
                    Mulai tambahkan petani ke dalam sistem untuk memulai manajemen data pertanian
                </p>
                <a href="{{ route('admin.petani.create') }}" class="btn-modern-success">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Petani Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        filterTable(searchValue, statusFilter);
    });

    // Status filter
    document.getElementById('statusFilter').addEventListener('change', function() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = this.value;
        filterTable(searchValue, statusFilter);
    });

    function filterTable(searchValue, statusFilter) {
        const table = document.getElementById('petaniTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            let showRow = true;

            // Search filter
            if (searchValue && !text.includes(searchValue)) {
                showRow = false;
            }

            // Status filter
            if (statusFilter) {
                const hasVerified = text.includes('verified');
                const hasPending = text.includes('pending');
                
                if (statusFilter === 'verified' && !hasVerified) {
                    showRow = false;
                }
                if (statusFilter === 'pending' && !hasPending) {
                    showRow = false;
                }
            }

            row.style.display = showRow ? '' : 'none';
        }
    }

    // Sort functionality
    document.getElementById('sortFilter').addEventListener('change', function() {
        const table = document.getElementById('petaniTable');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        const sortValue = this.value;

        rows.sort((a, b) => {
            if (sortValue === 'name') {
                const nameA = a.cells[1].textContent.trim().toLowerCase();
                const nameB = b.cells[1].textContent.trim().toLowerCase();
                return nameA.localeCompare(nameB);
            } else if (sortValue === 'name-desc') {
                const nameA = a.cells[1].textContent.trim().toLowerCase();
                const nameB = b.cells[1].textContent.trim().toLowerCase();
                return nameB.localeCompare(nameA);
            }
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));
    });
</script>
@endpush
