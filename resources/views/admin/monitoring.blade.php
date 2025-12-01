@extends('layouts.app')

@section('title', '📊 Monitoring Bantuan - Sistem Pertanian')

@section('content')
<style>
    /* Modern Monitoring Styles - Unified Green Theme */
    .page-header-monitoring {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .page-header-monitoring::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 50%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(30deg);
    }
    
    .page-header-monitoring h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header-monitoring p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }
    
    /* Stats Cards Modern */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card-modern {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card-modern::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100%;
        background: linear-gradient(135deg, transparent 0%, rgba(0,0,0,0.02) 100%);
    }
    
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .stat-icon.total {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .stat-icon.dikirim {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .stat-icon.diproses {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .stat-icon.desa {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }
    
    .stat-content h3 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 4px;
    }
    
    .stat-content p {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 0;
    }
    
    /* Filter Card Modern */
    .filter-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .filter-header-modern {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(4, 120, 87, 0.05) 100%);
        padding: 16px 24px;
        border-bottom: 1px solid rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: #047857;
    }
    
    .filter-header-modern .filter-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .filter-body-modern {
        padding: 24px;
    }
    
    .filter-label-modern {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        margin-bottom: 8px;
        display: block;
    }
    
    .filter-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .filter-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-reset {
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-reset:hover {
        background: #e5e7eb;
        color: #374151;
    }
    
    /* Map Card Modern */
    .map-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .map-header-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    
    .map-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
    }
    
    .map-header-modern i {
        color: white;
    }
    
    #map {
        height: 450px;
        border-radius: 0 0 16px 16px;
        z-index: 1;
    }
    
    /* Leaflet popup customization */
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
    }
    
    .leaflet-popup-tip {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Chart Cards Modern */
    .chart-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .chart-header-modern {
        padding: 20px 24px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .chart-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-header-modern .chart-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    
    .chart-icon.pie {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .chart-icon.doughnut {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .chart-icon.line {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .chart-body-modern {
        padding: 24px;
    }
    
    /* Table Card Modern */
    .table-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-header-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-modern-monitoring {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern-monitoring thead {
        background: #f9fafb;
    }
    
    .table-modern-monitoring thead th {
        font-weight: 600;
        color: #6b7280;
        padding: 14px 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table-modern-monitoring tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern-monitoring tbody tr:hover {
        background: #ecfdf5;
    }
    
    .table-modern-monitoring tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    /* Item Display Modern */
    .bantuan-item-display {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    
    .bantuan-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .bantuan-icon.bibit {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    
    .bantuan-icon.pupuk {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }
    
    .bantuan-icon.pestisida {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }
    
    .bantuan-icon.alat {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #2563eb;
    }
    
    .bantuan-info h6 {
        margin: 0 0 4px 0;
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
    }
    
    .bantuan-info span {
        color: #6b7280;
        font-size: 0.8rem;
    }
    
    /* Status Badge Modern */
    .status-badge-modern {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-badge-modern.dikirim {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
    }
    
    .status-badge-modern.diproses {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    /* Farmer Display */
    .farmer-display-modern {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .farmer-avatar-modern {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4338ca;
        font-size: 0.85rem;
    }
    
    .farmer-info-modern h6 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
    }
    
    .farmer-info-modern span {
        color: #6b7280;
        font-size: 0.75rem;
    }
    
    /* Action Button Modern */
    .btn-action-modern {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-action-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: #1d4ed8;
    }
    
    /* Empty State */
    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-modern .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-state-modern .empty-icon i {
        font-size: 2rem;
        color: #9ca3af;
    }
    
    .empty-state-modern h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .empty-state-modern p {
        color: #6b7280;
    }
    
    /* Pagination Modern */
    .pagination-modern {
        display: flex;
        justify-content: center;
        padding: 20px;
        border-top: 1px solid #f3f4f6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header-monitoring {
            padding: 1.5rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .stat-card-modern {
            padding: 1rem;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }
        
        .stat-content h3 {
            font-size: 1.25rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="page-header-monitoring">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2><i class="fas fa-chart-line me-2"></i>Monitoring Distribusi Bantuan</h2>
                <p>Pantau dan analisis distribusi bantuan pertanian secara real-time</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span class="badge bg-white text-purple px-3 py-2" style="color: #6d28d9 !important;">
                    <i class="fas fa-sync-alt me-1"></i>
                    Update Otomatis: 30 detik
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card-modern">
            <div class="stat-icon total">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $statsByType->sum('total') ?? 0 }}</h3>
                <p>Total Bantuan</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon dikirim">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $statsByStatus->where('status', 'Dikirim')->first()->total ?? 0 }}</h3>
                <p>Sudah Dikirim</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon diproses">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $statsByStatus->where('status', 'Diproses')->first()->total ?? 0 }}</h3>
                <p>Sedang Diproses</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon desa">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $statsByDesa->count() }}</h3>
                <p>Desa Tercakup</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card-modern">
        <div class="filter-header-modern">
            <div class="filter-icon">
                <i class="fas fa-filter"></i>
            </div>
            <h5>Filter & Pencarian Data</h5>
        </div>
        <div class="filter-body-modern">
            <form method="GET" action="{{ route('monitoring') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="filter-label-modern">Jenis Bantuan</label>
                        <select name="jenis_bantuan" class="filter-control">
                            <option value="">🎁 Semua Jenis</option>
                            @foreach($statsByType as $stat)
                                <option value="{{ $stat->jenis_bantuan }}" {{ request('jenis_bantuan') == $stat->jenis_bantuan ? 'selected' : '' }}>{{ $stat->jenis_bantuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label-modern">Status</label>
                        <select name="status" class="filter-control">
                            <option value="">📊 Semua Status</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>✅ Dikirim</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label-modern">Desa</label>
                        <select name="desa" class="filter-control">
                            <option value="">📍 Semua Desa</option>
                            @foreach($statsByDesa as $stat)
                                <option value="{{ $stat->alamat_desa }}" {{ request('desa') == $stat->alamat_desa ? 'selected' : '' }}>{{ $stat->alamat_desa }} ({{ $stat->total }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label-modern">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="filter-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label-modern">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="filter-control" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <a href="{{ route('monitoring') }}" class="btn-reset me-2">
                            <i class="fas fa-undo me-1"></i>Reset
                        </a>
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search me-1"></i>Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Distribution by Desa Section -->
    <div class="map-card-modern">
        <div class="map-header-modern">
            <h5><i class="fas fa-map-marked-alt me-2"></i>Distribusi Bantuan per Desa</h5>
            <span class="badge bg-white text-success px-3 py-2" style="font-size: 0.75rem;">
                {{ $statsByDesa->count() }} Desa
            </span>
        </div>
        <div style="padding: 24px; max-height: 450px; overflow-y: auto;">
            @if($statsByDesa->count() > 0)
                <div class="row g-3">
                    @foreach($statsByDesa as $index => $desa)
                        @php
                            $colors = ['#22c55e', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444', '#14b8a6', '#ec4899', '#6366f1'];
                            $color = $colors[$index % count($colors)];
                            $percentage = $statsByDesa->sum('total') > 0 ? round(($desa->total / $statsByDesa->sum('total')) * 100, 1) : 0;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div style="background: white; border-radius: 12px; padding: 16px; border: 1px solid #e5e7eb; transition: all 0.3s ease; cursor: pointer;" 
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)';" 
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, {{ $color }} 0%, {{ $color }}dd 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fas fa-map-marker-alt" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <h6 style="margin: 0 0 4px 0; font-weight: 600; color: #1f2937; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $desa->alamat_desa ?? 'Desa Tidak Diketahui' }}
                                        </h6>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="font-size: 20px; font-weight: 700; color: {{ $color }};">{{ $desa->total }}</span>
                                            <span style="font-size: 12px; color: #6b7280;">bantuan</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 12px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                        <span style="font-size: 11px; color: #9ca3af;">Persentase</span>
                                        <span style="font-size: 11px; font-weight: 600; color: {{ $color }};">{{ $percentage }}%</span>
                                    </div>
                                    <div style="height: 6px; background: #f3f4f6; border-radius: 3px; overflow: hidden;">
                                        <div style="height: 100%; width: {{ $percentage }}%; background: linear-gradient(90deg, {{ $color }} 0%, {{ $color }}bb 100%); border-radius: 3px; transition: width 0.5s ease;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="width: 80px; height: 80px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-map-marked-alt" style="font-size: 32px; color: #22c55e;"></i>
                    </div>
                    <h5 style="color: #1f2937; margin-bottom: 8px;">Belum Ada Data Distribusi</h5>
                    <p style="color: #6b7280; margin: 0;">Data distribusi bantuan per desa akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-card-modern">
                <div class="chart-header-modern">
                    <h5>
                        <span class="chart-icon pie"><i class="fas fa-chart-pie"></i></span>
                        Distribusi per Jenis Bantuan
                    </h5>
                </div>
                <div class="chart-body-modern">
                    <canvas id="typeChart" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-card-modern">
                <div class="chart-header-modern">
                    <h5>
                        <span class="chart-icon doughnut"><i class="fas fa-circle-notch"></i></span>
                        Status Distribusi
                    </h5>
                </div>
                <div class="chart-body-modern">
                    <canvas id="statusChart" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="chart-card-modern">
                <div class="chart-header-modern">
                    <h5>
                        <span class="chart-icon line"><i class="fas fa-chart-line"></i></span>
                        Tren Distribusi Bulanan
                    </h5>
                </div>
                <div class="chart-body-modern">
                    <canvas id="historicalChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-card-modern">
        <div class="table-header-modern">
            <h5><i class="fas fa-list-alt me-2"></i>Daftar Bantuan Terkini</h5>
            <span class="badge bg-white text-purple px-3 py-2" style="color: #6d28d9 !important;">
                {{ $bantuans->total() ?? $bantuans->count() }} Data
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-modern-monitoring">
                <thead>
                    <tr>
                        <th><i class="fas fa-box me-1"></i>Jenis Bantuan</th>
                        <th><i class="fas fa-cubes me-1"></i>Jumlah</th>
                        <th><i class="fas fa-user me-1"></i>Petani</th>
                        <th><i class="fas fa-map-pin me-1"></i>Desa</th>
                        <th><i class="fas fa-tag me-1"></i>Status</th>
                        <th><i class="fas fa-calendar me-1"></i>Tanggal</th>
                        <th class="text-center"><i class="fas fa-cog me-1"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuans as $bantuan)
                        @php
                            $iconClass = 'alat';
                            $iconName = 'tools';
                            $jenis = strtolower($bantuan->jenis_bantuan ?? '');
                            if(str_contains($jenis, 'bibit')) {
                                $iconClass = 'bibit';
                                $iconName = 'seedling';
                            } elseif(str_contains($jenis, 'pupuk')) {
                                $iconClass = 'pupuk';
                                $iconName = 'leaf';
                            } elseif(str_contains($jenis, 'pestisida')) {
                                $iconClass = 'pestisida';
                                $iconName = 'flask';
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="bantuan-item-display">
                                    <div class="bantuan-icon {{ $iconClass }}">
                                        <i class="fas fa-{{ $iconName }}"></i>
                                    </div>
                                    <div class="bantuan-info">
                                        <h6>{{ $bantuan->jenis_bantuan }}</h6>
                                        <span>ID: #{{ $bantuan->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #1f2937;">{{ number_format($bantuan->jumlah, 0, ',', '.') }}</span>
                                <span style="color: #6b7280; font-size: 0.8rem;">unit</span>
                            </td>
                            <td>
                                <div class="farmer-display-modern">
                                    <div class="farmer-avatar-modern">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="farmer-info-modern">
                                        <h6>{{ $bantuan->user->name ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="background: #f3f4f6; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; color: #4b5563;">
                                    <i class="fas fa-map-marker-alt me-1" style="color: #6d28d9;"></i>
                                    {{ $bantuan->user->alamat_desa ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge-modern {{ strtolower($bantuan->status) }}">
                                    <i class="fas fa-{{ $bantuan->status == 'Dikirim' ? 'check-circle' : 'clock' }}"></i>
                                    {{ $bantuan->status }}
                                </span>
                            </td>
                            <td>
                                <span style="color: #6b7280; font-size: 0.875rem;">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    {{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn-action-modern">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state-modern">
                                    <div class="empty-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5>Tidak ada data bantuan</h5>
                                    <p>Belum ada data bantuan yang sesuai dengan filter yang dipilih</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bantuans->hasPages())
            <div class="pagination-modern">
                {{ $bantuans->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modern Chart Colors
    const chartColors = {
        green: '#10b981',
        yellow: '#f59e0b',
        blue: '#3b82f6',
        purple: '#8b5cf6',
        red: '#ef4444',
        teal: '#14b8a6',
        indigo: '#6366f1',
        pink: '#ec4899'
    };

    // Type Chart (Pie)
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: @json(array_column($statsByType->toArray(), 'jenis_bantuan')),
            datasets: [{
                data: @json(array_column($statsByType->toArray(), 'total')),
                backgroundColor: [chartColors.green, chartColors.yellow, chartColors.blue, chartColors.purple, chartColors.teal],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Status Chart (Doughnut)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_column($statsByStatus->toArray(), 'status')),
            datasets: [{
                data: @json(array_column($statsByStatus->toArray(), 'total')),
                backgroundColor: [chartColors.yellow, chartColors.green],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Historical Chart (Line)
    const historicalCtx = document.getElementById('historicalChart').getContext('2d');
    new Chart(historicalCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($historicalData->toArray(), 'month')),
            datasets: [{
                label: 'Total Bantuan',
                data: @json(array_column($historicalData->toArray(), 'total')),
                borderColor: chartColors.purple,
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: chartColors.purple,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Real-time update for stats
    setInterval(function() {
        fetch('{{ route("latest.bantuan") }}')
            .then(response => response.json())
            .then(data => {
                console.log('Latest bantuan:', data);
            })
            .catch(error => console.error('Error:', error));
    }, 30000);
});
</script>
@endsection
