@extends('layouts.app')

@section('title', 'Kelola Petani')

@section('content')
<style>
    /* ==== GLOBAL SVG FIX - Hide any large stray SVGs ==== */
    .ptn-container > svg:not(.stat-icon svg),
    .main-content > svg:not(.stat-icon svg),
    body > svg:not([class]):not(.stat-icon svg) {
        display: none !important;
    }
    
    /* Ensure SVGs inside icons have correct size */
    .ptn-container svg[width] {
        max-width: 32px !important;
        max-height: 32px !important;
    }
    
    /* Ensure FontAwesome icons are visible and properly styled */
    .ptn-container i.fas,
    .ptn-container i.far,
    .ptn-container i.fab {
        font-size: inherit !important;
        width: auto !important;
        height: auto !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    }
    
    /* Container */
    .ptn-container { padding: 24px; }
    
    /* Header Card - Green Theme for Petani */
    .ptn-header-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
    }
    .ptn-header-card h1 {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .ptn-header-card p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 14px;
    }
    .ptn-header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    .ptn-header-icon i {
        font-size: 24px;
        color: #fff;
    }
    .ptn-btn-add {
        background: #fff;
        color: #10b981;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
    }
    .ptn-btn-add:hover {
        background: #f0fdf4;
        color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Stats Grid */
    .ptn-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 1200px) {
        .ptn-stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .ptn-stats-row { grid-template-columns: 1fr; }
    }
    .ptn-stat-box {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .ptn-stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    .ptn-stat-box .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .ptn-stat-box .stat-icon i {
        font-size: 20px !important;
        color: #fff !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    .ptn-stat-box .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .ptn-stat-box .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; }
    .ptn-stat-box .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
    .ptn-stat-box .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; }
    .ptn-stat-box .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .ptn-stat-box .stat-value {
        font-size: 32px;
        font-weight: 700;
        line-height: 1.2;
    }
    .ptn-stat-box .stat-value.green { color: #10b981; }
    .ptn-stat-box .stat-value.blue { color: #3b82f6; }
    .ptn-stat-box .stat-value.orange { color: #f59e0b; }
    .ptn-stat-box .stat-value.purple { color: #8b5cf6; }
    .ptn-stat-box .stat-desc {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Table Card */
    .ptn-table-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .ptn-table-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .ptn-table-header h5 {
        color: #fff;
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }
    .ptn-table-header h5 i { margin-right: 8px; }
    
    /* Filter Container */
    .ptn-filter-container {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .ptn-search-box {
        position: relative;
        min-width: 250px;
    }
    .ptn-search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: none;
        border-radius: 8px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 14px;
    }
    .ptn-search-box input::placeholder { color: rgba(255,255,255,0.7); }
    .ptn-search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.7);
    }
    .ptn-filter-select {
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        min-width: 150px;
    }
    .ptn-filter-select option {
        background: #fff;
        color: #333;
    }
    
    /* Table */
    .ptn-table {
        width: 100%;
        border-collapse: collapse;
    }
    .ptn-table thead th {
        background: #f8fafc;
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }
    .ptn-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    .ptn-table tbody tr:hover { background: #f8fafc; }
    .ptn-table tbody td {
        padding: 16px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }
    .ptn-avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 15px;
        flex-shrink: 0;
        object-fit: cover;
    }
    .ptn-user-info .name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .ptn-user-info .id {
        font-size: 12px;
        color: #94a3b8;
    }
    
    /* Status Badges */
    .ptn-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .ptn-badge.verified {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    .ptn-badge.pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }
    .ptn-badge i {
        font-size: 10px;
    }
    
    /* Action Buttons */
    .ptn-actions {
        display: flex;
        gap: 6px;
    }
    .ptn-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .ptn-action-btn i {
        font-size: 14px !important;
    }
    .ptn-action-btn.view { background: #dbeafe; color: #2563eb; }
    .ptn-action-btn.view:hover { background: #2563eb; color: #fff; }
    .ptn-action-btn.edit { background: #fef3c7; color: #d97706; }
    .ptn-action-btn.edit:hover { background: #d97706; color: #fff; }
    .ptn-action-btn.delete { background: #fee2e2; color: #dc2626; }
    .ptn-action-btn.delete:hover { background: #dc2626; color: #fff; }
    
    /* Pagination - Modern Style */
    .ptn-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding: 20px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 1px solid #e2e8f0;
        border-radius: 0 0 16px 16px;
    }
    .ptn-pagination-info {
        font-size: 14px;
        color: #64748b;
    }
    .ptn-pagination-info strong {
        color: #10b981;
        font-weight: 600;
    }
    .ptn-pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .ptn-page-numbers {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ptn-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.25s ease;
        cursor: pointer;
        border: none;
    }
    .ptn-page-btn i {
        font-size: 12px !important;
    }
    .ptn-page-btn.nav {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    .ptn-page-btn.nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    .ptn-page-btn.nav.disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
    .ptn-page-btn.number {
        min-width: 42px;
        height: 42px;
        padding: 0;
        background: #fff;
        color: #475569;
        border: 2px solid #e2e8f0;
    }
    .ptn-page-btn.number:hover {
        background: #f1f5f9;
        border-color: #10b981;
        color: #10b981;
    }
    .ptn-page-btn.number.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
    }
    @media (max-width: 768px) {
        .ptn-pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .ptn-pagination-nav {
            flex-wrap: wrap;
            justify-content: center;
        }
        .ptn-page-btn.nav {
            padding: 8px 12px;
            font-size: 13px;
        }
        .ptn-filter-container {
            width: 100%;
        }
        .ptn-search-box {
            min-width: 100%;
        }
    }
    
    /* Alert */
    .ptn-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .ptn-alert.success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .ptn-alert.danger { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .ptn-alert.warning { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .ptn-alert i { font-size: 20px; }

    /* Empty State */
    .ptn-empty {
        text-align: center;
        padding: 60px 20px;
    }
    .ptn-empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .ptn-empty-icon i { font-size: 40px; color: #10b981; }
    .ptn-empty h5 { color: #475569; margin-bottom: 8px; font-size: 18px; }
    .ptn-empty p { color: #94a3b8; margin: 0 0 20px 0; }
    .ptn-empty .ptn-btn-add {
        display: inline-flex;
    }
    
    /* Contact Info */
    .ptn-contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }
    .ptn-contact-item:last-child {
        margin-bottom: 0;
    }
    .ptn-contact-item i {
        width: 16px;
        color: #94a3b8;
        font-size: 12px;
    }
    .ptn-contact-item span {
        font-size: 13px;
    }
    
    /* Address Info */
    .ptn-address {
        font-size: 13px;
    }
    .ptn-address .kecamatan {
        font-weight: 600;
        color: #1e293b;
    }
    .ptn-address .desa {
        color: #64748b;
        font-size: 12px;
    }
    
    /* Date Info */
    .ptn-date {
        font-size: 13px;
    }
    .ptn-date .main {
        font-weight: 600;
        color: #1e293b;
    }
    .ptn-date .relative {
        color: #94a3b8;
        font-size: 11px;
    }
</style>

<div class="ptn-container">
    <!-- Header Card -->
    <div class="ptn-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 16px;">
            <div class="d-flex align-items-center">
                <div class="ptn-header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1>Manajemen Petani</h1>
                    <p>Kelola dan monitoring akun petani dalam sistem pertanian</p>
                </div>
            </div>
            <a href="{{ route('admin.petani.create') }}" class="ptn-btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Petani</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="ptn-alert success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="ptn-alert danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif
    
    @if(session('warning'))
    <div class="ptn-alert warning">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ session('warning') }}</span>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="ptn-stats-row">
        <div class="ptn-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Petani</div>
                    <div class="stat-value green">{{ $petani->total() }}</div>
                    <div class="stat-desc"><i class="fas fa-check-circle" style="color: #10b981;"></i> Terdaftar dalam sistem</div>
                </div>
                <div class="stat-icon green">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Terverifikasi</div>
                    <div class="stat-value blue">{{ $petani->where('is_verified', true)->count() }}</div>
                    <div class="stat-desc"><i class="fas fa-shield-alt" style="color: #3b82f6;"></i> Petani verified</div>
                </div>
                <div class="stat-icon blue">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Belum Verifikasi</div>
                    <div class="stat-value orange">{{ $petani->where('is_verified', false)->count() }}</div>
                    <div class="stat-desc"><i class="fas fa-hourglass-half" style="color: #f59e0b;"></i> Menunggu verifikasi</div>
                </div>
                <div class="stat-icon orange">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Bulan Ini</div>
                    <div class="stat-value purple">{{ \App\Models\User::where('role', 'petani')->whereMonth('created_at', now()->month)->count() }}</div>
                    <div class="stat-desc"><i class="fas fa-user-plus" style="color: #8b5cf6;"></i> Petani baru</div>
                </div>
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="ptn-table-card">
        <div class="ptn-table-header">
            <h5><i class="fas fa-table"></i>Data Petani</h5>
            <div class="ptn-filter-container">
                <select class="ptn-filter-select" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="verified">Terverifikasi</option>
                    <option value="pending">Belum Verifikasi</option>
                </select>
                <div class="ptn-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari nama, email, alamat..." onkeyup="filterTable()">
                </div>
            </div>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="ptn-table" id="petaniTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Petani</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 120px;">Bergabung</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petani as $index => $p)
                    <tr data-status="{{ $p->is_verified ? 'verified' : 'pending' }}">
                        <td style="text-align: center; font-weight: 600; color: #64748b;">
                            {{ $petani->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                @if($p->profile_picture)
                                    <img src="{{ asset('storage/' . $p->profile_picture) }}" 
                                         alt="{{ $p->name }}"
                                         class="ptn-avatar"
                                         style="object-fit: cover;">
                                @else
                                    <div class="ptn-avatar">
                                        {{ strtoupper(substr($p->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="ptn-user-info">
                                    <div class="name">{{ $p->name }}</div>
                                    <div class="id">ID: #{{ $p->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="ptn-contact-item">
                                <i class="fas fa-envelope"></i>
                                <span style="color: #10b981;">{{ $p->email }}</span>
                            </div>
                            @if($p->telepon)
                            <div class="ptn-contact-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $p->telepon }}</span>
                            </div>
                            @else
                            <div class="ptn-contact-item">
                                <i class="fas fa-phone"></i>
                                <span style="color: #cbd5e1;">-</span>
                            </div>
                            @endif
                        </td>
                        <td>
                            @if($p->alamat_kecamatan || $p->alamat_desa)
                            <div class="ptn-address">
                                <div class="kecamatan">
                                    <i class="fas fa-map-marker-alt" style="color: #10b981; margin-right: 4px;"></i>
                                    {{ $p->alamat_kecamatan ?? '-' }}
                                </div>
                                <div class="desa">{{ $p->alamat_desa ?? '-' }}</div>
                            </div>
                            @else
                            <span style="color: #cbd5e1; font-size: 13px;">Alamat tidak tersedia</span>
                            @endif
                        </td>
                        <td>
                            @if($p->is_verified)
                                <span class="ptn-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                            @else
                                <span class="ptn-badge pending">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="ptn-date">
                                <div class="main">{{ $p->created_at->format('d M Y') }}</div>
                                <div class="relative">{{ $p->created_at->diffForHumans() }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="ptn-actions" style="justify-content: center;">
                                <a href="{{ route('admin.petani.show', $p->id) }}" class="ptn-action-btn view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.petani.edit', $p->id) }}" class="ptn-action-btn edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="ptn-action-btn delete" title="Hapus" onclick="confirmDelete({{ $p->id }}, '{{ $p->name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $p->id }}" action="{{ route('admin.petani.destroy', $p->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ptn-empty">
                                <div class="ptn-empty-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5>Belum Ada Petani Terdaftar</h5>
                                <p>Mulai tambahkan petani ke dalam sistem untuk memulai manajemen data pertanian</p>
                                <a href="{{ route('admin.petani.create') }}" class="ptn-btn-add">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Petani Pertama</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($petani->hasPages())
        <div class="ptn-pagination-wrapper">
            <div class="ptn-pagination-info">
                Menampilkan <strong>{{ $petani->firstItem() }}</strong> - <strong>{{ $petani->lastItem() }}</strong> dari <strong>{{ $petani->total() }}</strong> petani
            </div>
            <div class="ptn-pagination-nav">
                {{-- Previous --}}
                @if($petani->onFirstPage())
                <span class="ptn-page-btn nav disabled">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </span>
                @else
                <a href="{{ $petani->previousPageUrl() }}" class="ptn-page-btn nav">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                @endif
                
                {{-- Page Numbers --}}
                <div class="ptn-page-numbers">
                    @foreach($petani->getUrlRange(1, $petani->lastPage()) as $page => $url)
                        @if($page == $petani->currentPage())
                        <span class="ptn-page-btn number active">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="ptn-page-btn number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                {{-- Next --}}
                @if($petani->hasMorePages())
                <a href="{{ $petani->nextPageUrl() }}" class="ptn-page-btn nav">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
                @else
                <span class="ptn-page-btn nav disabled">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none;">
                <h5 class="modal-title" style="font-weight: 600;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <p style="color: #475569; margin-bottom: 16px;">Apakah Anda yakin ingin menghapus petani:</p>
                <div style="background: #fef3c7; padding: 16px; border-radius: 12px; border: 1px solid #fde68a; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-user" style="color: #d97706; font-size: 20px;"></i>
                        <span id="deletePetaniName" style="font-weight: 600; color: #92400e;"></span>
                    </div>
                </div>
                <div style="background: #fee2e2; padding: 16px; border-radius: 12px; border: 1px solid #fecaca;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #dc2626; font-size: 18px; margin-top: 2px;"></i>
                        <div>
                            <div style="font-weight: 600; color: #dc2626; margin-bottom: 4px;">Peringatan!</div>
                            <small style="color: #b91c1c;">Petani dengan data laporan/bantuan tidak dapat dihapus. Aksi ini tidak dapat dibatalkan!</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="padding: 10px 20px; border-radius: 10px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn" id="confirmDeleteBtn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 500; border: none;">
                    <i class="fas fa-trash me-1"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteId = null;

function confirmDelete(id, name) {
    deleteId = id;
    document.getElementById('deletePetaniName').textContent = name;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        document.getElementById('delete-form-' + deleteId).submit();
    }
});

function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#petaniTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const rowStatus = row.dataset.status;
        
        let showRow = true;
        
        // Search filter
        if (searchInput && !text.includes(searchInput)) {
            showRow = false;
        }
        
        // Status filter
        if (statusFilter && rowStatus !== statusFilter) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}
</script>
@endsection
