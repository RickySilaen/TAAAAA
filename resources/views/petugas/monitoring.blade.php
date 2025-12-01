@extends('layouts.app')

@section('title', '📊 Monitoring Bantuan - Petugas')

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
    
    .chart-icon.bar {
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
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #059669;
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
    
    /* Quick Action Buttons */
    .quick-action-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    
    .quick-action-btn.update {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    .quick-action-btn.update:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: #b45309;
    }
    
    .quick-action-btn.kirim {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
    }
    
    .quick-action-btn.kirim:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #15803d;
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
    
    /* Info Card */
    .info-card-modern {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 16px;
        border-left: 4px solid #059669;
    }
    
    .info-card-modern .info-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .info-card-modern .info-content h6 {
        margin: 0 0 4px 0;
        font-weight: 700;
        color: #047857;
    }
    
    .info-card-modern .info-content p {
        margin: 0;
        color: #065f46;
        font-size: 0.9rem;
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
        
        .info-card-modern {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="page-header-monitoring">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2><i class="fas fa-tasks me-2"></i>Monitoring Distribusi Bantuan</h2>
                <p>Pantau dan kelola distribusi bantuan pertanian</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span class="badge bg-white px-3 py-2" style="color: #047857 !important;">
                    <i class="fas fa-user-tie me-1"></i>
                    Panel Petugas
                </span>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="info-card-modern">
        <div class="info-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="info-content">
            <h6>Selamat datang di Panel Monitoring Petugas</h6>
            <p>Anda dapat memantau status distribusi bantuan dan melakukan update status pengiriman dari halaman ini.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card-modern">
            <div class="stat-icon total">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $bantuans->total() ?? $bantuans->count() ?? 0 }}</h3>
                <p>Total Bantuan</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon dikirim">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $bantuans->where('status', 'Dikirim')->count() ?? 0 }}</h3>
                <p>Sudah Dikirim</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon diproses">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $bantuans->where('status', 'Diproses')->count() ?? 0 }}</h3>
                <p>Sedang Diproses</p>
            </div>
        </div>
        <div class="stat-card-modern">
            <div class="stat-icon desa">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ \Carbon\Carbon::now()->format('d M') }}</h3>
                <p>Hari Ini</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card-modern">
        <div class="filter-header-modern">
            <div class="filter-icon">
                <i class="fas fa-filter"></i>
            </div>
            <h5>Filter Data Bantuan</h5>
        </div>
        <div class="filter-body-modern">
            <form method="GET" action="">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="filter-label-modern">Jenis Bantuan</label>
                        <select name="jenis_bantuan" class="filter-control">
                            <option value="">🎁 Semua Jenis</option>
                            <option value="Bibit" {{ request('jenis_bantuan') == 'Bibit' ? 'selected' : '' }}>🌱 Bibit</option>
                            <option value="Pupuk" {{ request('jenis_bantuan') == 'Pupuk' ? 'selected' : '' }}>🧪 Pupuk</option>
                            <option value="Pestisida" {{ request('jenis_bantuan') == 'Pestisida' ? 'selected' : '' }}>💊 Pestisida</option>
                            <option value="Alat" {{ request('jenis_bantuan') == 'Alat' ? 'selected' : '' }}>🔧 Alat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label-modern">Status</label>
                        <select name="status" class="filter-control">
                            <option value="">📊 Semua Status</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>✅ Dikirim</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label-modern">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="filter-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label-modern">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="filter-control" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <a href="" class="btn-reset me-2">
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

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-card-modern">
                <div class="chart-header-modern">
                    <h5>
                        <span class="chart-icon pie"><i class="fas fa-chart-pie"></i></span>
                        Distribusi per Jenis
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
                        Status Pengiriman
                    </h5>
                </div>
                <div class="chart-body-modern">
                    <canvas id="statusChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-card-modern">
        <div class="table-header-modern">
            <h5><i class="fas fa-clipboard-list me-2"></i>Daftar Bantuan untuk Diproses</h5>
            <span class="badge bg-white px-3 py-2" style="color: #047857 !important;">
                {{ $bantuans->count() ?? 0 }} Data
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-modern-monitoring">
                <thead>
                    <tr>
                        <th><i class="fas fa-box me-1"></i>Jenis Bantuan</th>
                        <th><i class="fas fa-cubes me-1"></i>Jumlah</th>
                        <th><i class="fas fa-user me-1"></i>Petani</th>
                        <th><i class="fas fa-map-pin me-1"></i>Alamat</th>
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
                                    <i class="fas fa-map-marker-alt me-1" style="color: #059669;"></i>
                                    {{ $bantuan->user->alamat ?? $bantuan->user->alamat_desa ?? 'N/A' }}
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
                                <div class="d-flex gap-2 justify-content-center">
                                    @if($bantuan->status == 'Diproses')
                                        <form action="{{ route('petugas.update.status', $bantuan->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Dikirim">
                                            <button type="submit" class="quick-action-btn kirim" onclick="return confirm('Tandai sebagai Dikirim?')">
                                                <i class="fas fa-truck"></i>
                                                Kirim
                                            </button>
                                        </form>
                                    @else
                                        <span class="quick-action-btn" style="background: #dcfce7; color: #15803d;">
                                            <i class="fas fa-check-circle"></i>
                                            Terkirim
                                        </span>
                                    @endif
                                </div>
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
                                    <p>Belum ada data bantuan yang perlu diproses</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($bantuans, 'hasPages') && $bantuans->hasPages())
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
    // Chart Colors
    const chartColors = {
        green: '#10b981',
        yellow: '#f59e0b',
        blue: '#3b82f6',
        cyan: '#0891b2',
        red: '#ef4444',
        teal: '#14b8a6'
    };

    // Count by type
    const bantuans = @json($bantuans->toArray()['data'] ?? $bantuans->toArray());
    
    const typeCounts = {};
    const statusCounts = { 'Diproses': 0, 'Dikirim': 0 };
    
    bantuans.forEach(item => {
        const type = item.jenis_bantuan || 'Lainnya';
        typeCounts[type] = (typeCounts[type] || 0) + 1;
        
        const status = item.status || 'Diproses';
        statusCounts[status] = (statusCounts[status] || 0) + 1;
    });

    // Type Chart (Pie)
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(typeCounts),
            datasets: [{
                data: Object.values(typeCounts),
                backgroundColor: [chartColors.green, chartColors.yellow, chartColors.blue, chartColors.cyan, chartColors.teal],
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
            labels: Object.keys(statusCounts),
            datasets: [{
                data: Object.values(statusCounts),
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
});
</script>
@endsection
