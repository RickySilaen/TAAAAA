@extends('layouts.app')

@section('title', '🌾 Hasil Panen - Sistem Pertanian')

@section('content')
<style>
    /* Modern Hasil Panen Styles - Green Theme */
    .page-header-panen {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .page-header-panen::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 50%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(30deg);
    }
    
    .page-header-panen h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header-panen p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }
    
    /* Total Badge */
    .total-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 16px 24px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .total-badge .total-icon {
        width: 56px;
        height: 56px;
        background: white;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #059669;
        font-size: 1.5rem;
    }
    
    .total-badge .total-content h3 {
        color: white;
        font-weight: 800;
        font-size: 1.75rem;
        margin: 0;
    }
    
    .total-badge .total-content p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 0.9rem;
    }
    
    /* Stats Grid */
    .stats-grid-panen {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card-panen {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }
    
    .stat-card-panen:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon-panen {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .stat-icon-panen.petani {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    
    .stat-icon-panen.rata {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
    }
    
    .stat-icon-panen.tertinggi {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    .stat-icon-panen.laporan {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
    }
    
    .stat-content-panen h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 2px;
    }
    
    .stat-content-panen p {
        color: #6b7280;
        font-size: 0.85rem;
        margin: 0;
    }
    
    /* Filter Card */
    .filter-card-panen {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .filter-header-panen {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(4, 120, 87, 0.05) 100%);
        padding: 16px 24px;
        border-bottom: 1px solid rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-header-panen h5 {
        margin: 0;
        font-weight: 700;
        color: #047857;
    }
    
    .filter-header-panen .filter-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .filter-body-panen {
        padding: 20px 24px;
    }
    
    .search-box-panen {
        position: relative;
    }
    
    .search-box-panen input {
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px 12px 48px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .search-box-panen input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }
    
    .search-box-panen .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        border: 2px solid #e5e7eb;
        background: white;
        color: #4b5563;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-btn:hover {
        border-color: #059669;
        color: #059669;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-color: transparent;
        color: white;
    }
    
    /* Table Card */
    .table-card-panen {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-header-panen {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-header-panen h5 {
        margin: 0;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-modern-panen {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern-panen thead {
        background: #f9fafb;
    }
    
    .table-modern-panen thead th {
        font-weight: 600;
        color: #6b7280;
        padding: 14px 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table-modern-panen tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern-panen tbody tr:hover {
        background: #f0fdf4;
    }
    
    .table-modern-panen tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    /* Farmer Display */
    .farmer-display-panen {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    
    .farmer-avatar-panen {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid #e5e7eb;
    }
    
    .farmer-avatar-panen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .farmer-avatar-panen.no-img {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #15803d;
        font-size: 1.25rem;
        border: none;
    }
    
    .farmer-info-panen h6 {
        margin: 0 0 4px 0;
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
    }
    
    .farmer-info-panen span {
        color: #6b7280;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Description */
    .desc-display {
        max-width: 280px;
    }
    
    .desc-display p {
        margin: 0 0 6px 0;
        color: #374151;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .desc-display .crop-tag {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Hasil Badge */
    .hasil-badge {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }
    
    .hasil-badge.low {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    /* Date Display */
    .date-display-panen {
        text-align: center;
    }
    
    .date-display-panen .date-main {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
        display: block;
    }
    
    .date-display-panen .date-relative {
        color: #6b7280;
        font-size: 0.8rem;
    }
    
    /* Action Buttons */
    .action-buttons-panen {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    
    .btn-action-panen {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-action-panen.edit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    
    .btn-action-panen.edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: #1d4ed8;
    }
    
    .btn-action-panen.view {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
    }
    
    .btn-action-panen.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        color: #4338ca;
    }
    
    /* Empty State */
    .empty-state-panen {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-panen .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-state-panen .empty-icon i {
        font-size: 2.5rem;
        color: #9ca3af;
    }
    
    .empty-state-panen h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .empty-state-panen p {
        color: #6b7280;
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header-panen {
            padding: 1.5rem;
        }
        
        .total-badge {
            margin-top: 1rem;
        }
        
        .stats-grid-panen {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filter-buttons {
            justify-content: center;
            margin-top: 1rem;
        }
        
        .table-modern-panen thead {
            display: none;
        }
        
        .table-modern-panen tbody tr {
            display: block;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }
        
        .table-modern-panen tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
        }
        
        .table-modern-panen tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="page-header-panen">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h2><i class="fas fa-wheat-awn me-2"></i>Hasil Panen Petani</h2>
                <p>Pantau produktivitas pertanian di Kabupaten Toba</p>
            </div>
            <div class="col-lg-5">
                <div class="total-badge float-lg-end">
                    <div class="total-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="total-content">
                        <h3>{{ number_format($total_hasil_panen, 0, ',', '.') }} kg</h3>
                        <p>Total Hasil Panen</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    @if($laporans->count() > 0)
    <div class="stats-grid-panen">
        <div class="stat-card-panen">
            <div class="stat-icon-panen petani">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content-panen">
                <h3>{{ $laporans->unique('user_id')->count() }}</h3>
                <p>Petani Aktif</p>
            </div>
        </div>
        <div class="stat-card-panen">
            <div class="stat-icon-panen rata">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content-panen">
                <h3>{{ number_format($laporans->avg('hasil_panen'), 1) }} kg</h3>
                <p>Rata-rata Panen</p>
            </div>
        </div>
        <div class="stat-card-panen">
            <div class="stat-icon-panen tertinggi">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-content-panen">
                <h3>{{ number_format($laporans->max('hasil_panen'), 0, ',', '.') }} kg</h3>
                <p>Hasil Tertinggi</p>
            </div>
        </div>
        <div class="stat-card-panen">
            <div class="stat-icon-panen laporan">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content-panen">
                <h3>{{ $laporans->count() }}</h3>
                <p>Total Laporan</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-card-panen">
        <div class="filter-header-panen">
            <div class="filter-icon">
                <i class="fas fa-search"></i>
            </div>
            <h5>Cari & Filter Data</h5>
        </div>
        <div class="filter-body-panen">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="search-box-panen">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama petani atau deskripsi...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="filter-buttons justify-content-md-end">
                        <button type="button" class="filter-btn active" id="filterAll">
                            <i class="fas fa-list"></i>
                            Semua
                        </button>
                        <button type="button" class="filter-btn" id="filterHigh">
                            <i class="fas fa-arrow-up"></i>
                            Hasil Tinggi
                        </button>
                        <button type="button" class="filter-btn" id="filterLow">
                            <i class="fas fa-arrow-down"></i>
                            Hasil Rendah
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-card-panen">
        <div class="table-header-panen">
            <h5><i class="fas fa-table me-2"></i>Data Hasil Panen</h5>
            <span class="badge bg-white text-success px-3 py-2" style="font-weight: 600;">
                {{ $laporans->count() }} Data
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-modern-panen" id="panenTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-user me-1"></i>Petani</th>
                        <th><i class="fas fa-file-alt me-1"></i>Deskripsi Kemajuan</th>
                        <th class="text-center"><i class="fas fa-weight me-1"></i>Hasil Panen</th>
                        <th class="text-center"><i class="fas fa-calendar me-1"></i>Tanggal</th>
                        <th class="text-center"><i class="fas fa-cog me-1"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $laporan)
                        <tr class="panen-row" data-hasil="{{ $laporan->hasil_panen }}">
                            <td data-label="Petani">
                                <div class="farmer-display-panen">
                                    @if($laporan->user && $laporan->user->profile_picture)
                                        <div class="farmer-avatar-panen">
                                            <img src="{{ asset('storage/' . $laporan->user->profile_picture) }}" alt="Avatar">
                                        </div>
                                    @else
                                        <div class="farmer-avatar-panen no-img">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="farmer-info-panen">
                                        <h6>{{ $laporan->user ? $laporan->user->name : 'User tidak ditemukan' }}</h6>
                                        <span>
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $laporan->user ? $laporan->user->alamat_desa : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Deskripsi">
                                <div class="desc-display">
                                    <p>{{ Str::limit($laporan->deskripsi_kemajuan, 80) }}</p>
                                    @if($laporan->jenis_tanaman)
                                        <span class="crop-tag">
                                            <i class="fas fa-leaf"></i>
                                            {{ $laporan->jenis_tanaman }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center" data-label="Hasil Panen">
                                <span class="hasil-badge {{ $laporan->hasil_panen < 100 ? 'low' : '' }}">
                                    <i class="fas fa-weight"></i>
                                    {{ number_format($laporan->hasil_panen, 0, ',', '.') }} kg
                                </span>
                            </td>
                            <td class="text-center" data-label="Tanggal">
                                <div class="date-display-panen">
                                    <span class="date-main">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</span>
                                    <span class="date-relative">{{ \Carbon\Carbon::parse($laporan->tanggal)->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="text-center" data-label="Aksi">
                                <div class="action-buttons-panen">
                                    <a href="{{ route('edit.laporan', $laporan->id) }}" class="btn-action-panen edit" title="Edit Laporan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('api.laporan.show', $laporan->id) }}" class="btn-action-panen view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state-panen">
                                    <div class="empty-icon">
                                        <i class="fas fa-seedling"></i>
                                    </div>
                                    <h5>Belum ada data hasil panen</h5>
                                    <p>Data hasil panen akan muncul setelah petani menginput laporan kemajuan dengan hasil panen.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#panenTable tbody tr.panen-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
        });
    });

    // Filter functionality
    const filterAll = document.getElementById('filterAll');
    const filterHigh = document.getElementById('filterHigh');
    const filterLow = document.getElementById('filterLow');

    function filterRows(criteria) {
        const rows = document.querySelectorAll('.panen-row');

        rows.forEach(row => {
            const hasil = parseInt(row.dataset.hasil);
            let show = false;

            switch(criteria) {
                case 'all':
                    show = true;
                    break;
                case 'high':
                    show = hasil >= 100;
                    break;
                case 'low':
                    show = hasil < 100;
                    break;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    function setActiveFilter(activeButton) {
        [filterAll, filterHigh, filterLow].forEach(btn => {
            btn.classList.remove('active');
        });
        activeButton.classList.add('active');
    }

    filterAll.addEventListener('click', function() {
        filterRows('all');
        setActiveFilter(this);
    });

    filterHigh.addEventListener('click', function() {
        filterRows('high');
        setActiveFilter(this);
    });

    filterLow.addEventListener('click', function() {
        filterRows('low');
        setActiveFilter(this);
    });
});
</script>
@endsection
