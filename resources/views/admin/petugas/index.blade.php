@extends('layouts.app')

@section('title', 'Kelola Petugas')

@section('content')
<style>
    /* ==== GLOBAL SVG FIX - Hide any large stray SVGs ==== */
    .ptgs-container > svg:not(.stat-icon svg),
    .main-content > svg:not(.stat-icon svg),
    body > svg:not([class]):not(.stat-icon svg) {
        display: none !important;
    }
    
    /* Ensure SVGs inside icons have correct size */
    .ptgs-container svg[width] {
        max-width: 32px !important;
        max-height: 32px !important;
    }
    
    /* Ensure FontAwesome icons are visible and properly styled */
    .ptgs-container i.fas,
    .ptgs-container i.far,
    .ptgs-container i.fab {
        font-size: inherit !important;
        width: auto !important;
        height: auto !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    }
    
    /* Container */
    .ptgs-container { padding: 24px; }
    
    /* Header Card */
    .ptgs-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }
    .ptgs-header-card h1 {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .ptgs-header-card p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 14px;
    }
    .ptgs-header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    .ptgs-header-icon i {
        font-size: 24px;
        color: #fff;
    }
    .ptgs-btn-add {
        background: #fff;
        color: #667eea;
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
    .ptgs-btn-add:hover {
        background: #f0f0ff;
        color: #5a67d8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Stats Grid */
    .ptgs-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 992px) {
        .ptgs-stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .ptgs-stats-row { grid-template-columns: 1fr; }
    }
    .ptgs-stat-box {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .ptgs-stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    .ptgs-stat-box .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .ptgs-stat-box .stat-icon i {
        font-size: 20px !important;
        color: #fff !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    .ptgs-stat-box .stat-icon.blue { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; }
    .ptgs-stat-box .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .ptgs-stat-box .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
    .ptgs-stat-box .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .ptgs-stat-box .stat-value {
        font-size: 32px;
        font-weight: 700;
        line-height: 1.2;
    }
    .ptgs-stat-box .stat-value.blue { color: #667eea; }
    .ptgs-stat-box .stat-value.green { color: #10b981; }
    .ptgs-stat-box .stat-value.orange { color: #f59e0b; }
    .ptgs-stat-box .stat-desc {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Table Card */
    .ptgs-table-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .ptgs-table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .ptgs-table-header h5 {
        color: #fff;
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }
    .ptgs-table-header h5 i { margin-right: 8px; }
    .ptgs-search-box {
        position: relative;
        min-width: 250px;
    }
    .ptgs-search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: none;
        border-radius: 8px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 14px;
    }
    .ptgs-search-box input::placeholder { color: rgba(255,255,255,0.7); }
    .ptgs-search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.7);
    }
    
    /* Table */
    .ptgs-table {
        width: 100%;
        border-collapse: collapse;
    }
    .ptgs-table thead th {
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
    .ptgs-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    .ptgs-table tbody tr:hover { background: #f8fafc; }
    .ptgs-table tbody td {
        padding: 16px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }
    .ptgs-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }
    .ptgs-user-info .name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .ptgs-user-info .id {
        font-size: 12px;
        color: #94a3b8;
    }
    
    /* Action Buttons */
    .ptgs-actions {
        display: flex;
        gap: 6px;
    }
    .ptgs-action-btn {
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
    .ptgs-action-btn i {
        font-size: 14px !important;
    }
    .ptgs-action-btn.view { background: #dbeafe; color: #2563eb; }
    .ptgs-action-btn.view:hover { background: #2563eb; color: #fff; }
    .ptgs-action-btn.edit { background: #fef3c7; color: #d97706; }
    .ptgs-action-btn.edit:hover { background: #d97706; color: #fff; }
    .ptgs-action-btn.delete { background: #fee2e2; color: #dc2626; }
    .ptgs-action-btn.delete:hover { background: #dc2626; color: #fff; }
    
    /* Pagination - Modern Style */
    .ptgs-pagination-wrapper {
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
    .ptgs-pagination-info {
        font-size: 14px;
        color: #64748b;
    }
    .ptgs-pagination-info strong {
        color: #667eea;
        font-weight: 600;
    }
    .ptgs-pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .ptgs-page-numbers {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ptgs-page-btn {
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
    .ptgs-page-btn i {
        font-size: 12px !important;
    }
    .ptgs-page-btn.nav {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .ptgs-page-btn.nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    .ptgs-page-btn.nav.disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
    .ptgs-page-btn.number {
        min-width: 42px;
        height: 42px;
        padding: 0;
        background: #fff;
        color: #475569;
        border: 2px solid #e2e8f0;
    }
    .ptgs-page-btn.number:hover {
        background: #f1f5f9;
        border-color: #667eea;
        color: #667eea;
    }
    .ptgs-page-btn.number.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.35);
    }
    @media (max-width: 768px) {
        .ptgs-pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .ptgs-pagination-nav {
            flex-wrap: wrap;
            justify-content: center;
        }
        .ptgs-page-btn.nav {
            padding: 8px 12px;
            font-size: 13px;
        }
    }
    
    /* Alert */
    .ptgs-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .ptgs-alert.success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .ptgs-alert.danger { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .ptgs-alert i { font-size: 20px; }

    /* Empty State */
    .ptgs-empty {
        text-align: center;
        padding: 60px 20px;
    }
    .ptgs-empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .ptgs-empty-icon i { font-size: 32px; color: #94a3b8; }
    .ptgs-empty h5 { color: #475569; margin-bottom: 8px; }
    .ptgs-empty p { color: #94a3b8; margin: 0; }
</style>

<div class="ptgs-container">
    <!-- Header Card -->
    <div class="ptgs-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 16px;">
            <div class="d-flex align-items-center">
                <div class="ptgs-header-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <h1>Manajemen Petugas</h1>
                    <p>Kelola data akun petugas pertanian kabupaten</p>
                </div>
            </div>
            <a href="{{ route('admin.petugas.create') }}" class="ptgs-btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Petugas</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="ptgs-alert success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="ptgs-alert danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="ptgs-stats-row">
        <div class="ptgs-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Petugas</div>
                    <div class="stat-value blue">{{ $petugas->total() }}</div>
                    <div class="stat-desc"><i class="fas fa-check-circle" style="color: #10b981;"></i> Petugas terdaftar</div>
                </div>
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="ptgs-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Kecamatan</div>
                    <div class="stat-value green">{{ $petugas->pluck('alamat_kecamatan')->unique()->count() }}</div>
                    <div class="stat-desc"><i class="fas fa-map-marker-alt" style="color: #f59e0b;"></i> Wilayah kerja</div>
                </div>
                <div class="stat-icon green">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
            </div>
        </div>
        <div class="ptgs-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Bulan Ini</div>
                    <div class="stat-value orange">{{ $petugas->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                    <div class="stat-desc"><i class="fas fa-clock" style="color: #667eea;"></i> Ditambahkan</div>
                </div>
                <div class="stat-icon orange">
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="ptgs-table-card">
        <div class="ptgs-table-header">
            <h5><i class="fas fa-table"></i>Data Petugas</h5>
            <div class="ptgs-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari petugas..." onkeyup="searchTable()">
            </div>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="ptgs-table" id="petugasTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petugas as $index => $item)
                    <tr>
                        <td style="text-align: center; font-weight: 600; color: #64748b;">{{ $petugas->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                <div class="ptgs-avatar">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div class="ptgs-user-info">
                                    <div class="name">{{ $item->name }}</div>
                                    <div class="id">ID: {{ $item->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $item->email }}" style="color: #667eea; text-decoration: none;">{{ $item->email }}</a>
                        </td>
                        <td>
                            <span style="color: #10b981; font-weight: 500;">{{ $item->telepon ?? '-' }}</span>
                        </td>
                        <td>{{ $item->alamat_desa ?? '-' }}</td>
                        <td>{{ $item->alamat_kecamatan ?? '-' }}</td>
                        <td>
                            <div class="ptgs-actions" style="justify-content: center;">
                                <a href="{{ route('admin.petugas.show', $item->id) }}" class="ptgs-action-btn view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.petugas.edit', $item->id) }}" class="ptgs-action-btn edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ptgs-action-btn delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ptgs-empty">
                                <div class="ptgs-empty-icon">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h5>Belum Ada Data Petugas</h5>
                                <p>Silakan tambah petugas baru dengan menekan tombol "Tambah Petugas"</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($petugas->hasPages())
        <div class="ptgs-pagination-wrapper">
            <div class="ptgs-pagination-info">
                Menampilkan <strong>{{ $petugas->firstItem() }}</strong> - <strong>{{ $petugas->lastItem() }}</strong> dari <strong>{{ $petugas->total() }}</strong> data
            </div>
            <div class="ptgs-pagination-nav">
                {{-- Previous --}}
                @if($petugas->onFirstPage())
                <span class="ptgs-page-btn nav disabled">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </span>
                @else
                <a href="{{ $petugas->previousPageUrl() }}" class="ptgs-page-btn nav">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                @endif
                
                {{-- Page Numbers --}}
                <div class="ptgs-page-numbers">
                    @foreach($petugas->getUrlRange(1, $petugas->lastPage()) as $page => $url)
                        @if($page == $petugas->currentPage())
                        <span class="ptgs-page-btn number active">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="ptgs-page-btn number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                {{-- Next --}}
                @if($petugas->hasMorePages())
                <a href="{{ $petugas->nextPageUrl() }}" class="ptgs-page-btn nav">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
                @else
                <span class="ptgs-page-btn nav disabled">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#petugasTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
@endsection
