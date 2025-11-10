@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Pertanian Toba')

@push('styles')
<style>
    /* Additional inline styles for better rendering */
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-radius: 20px !important;
        padding: 2.5rem !important;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3) !important;
        margin-bottom: 2rem !important;
    }
    
    .welcome-icon {
        width: 70px !important;
        height: 70px !important;
        background: rgba(255,255,255,0.2) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 18px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: white !important;
        font-size: 28px !important;
    }
    
    .welcome-title {
        font-size: 2rem !important;
        font-weight: 800 !important;
        color: white !important;
        margin-bottom: 0.5rem !important;
    }
    
    .welcome-subtitle {
        font-size: 1rem !important;
        color: rgba(255,255,255,0.95) !important;
        font-weight: 500 !important;
    }
    
    .date-time-widget {
        background: rgba(255,255,255,0.15) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 15px !important;
        padding: 1.25rem !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
    }
    
    .current-date, .current-time {
        color: white !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
    }
    
    .quick-action-btn {
        display: flex !important;
        align-items: center !important;
        gap: 1rem !important;
        padding: 1.5rem !important;
        background: white !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07) !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        border: 2px solid transparent !important;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    
    .quick-action-btn.primary:hover {
        border-color: #667eea !important;
    }
    
    .quick-action-icon {
        width: 50px !important;
        height: 50px !important;
        border-radius: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.5rem !important;
        color: white !important;
    }
    
    .quick-action-btn.primary .quick-action-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .quick-action-btn.success .quick-action-icon {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
    }
    
    .quick-action-btn.info .quick-action-icon {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%) !important;
    }
    
    .quick-action-btn.warning .quick-action-icon {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%) !important;
    }
    
    .quick-action-title {
        display: block !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        color: #2d3748 !important;
        margin-bottom: 0.25rem !important;
    }
    
    .quick-action-desc {
        display: block !important;
        font-size: 0.85rem !important;
        color: #718096 !important;
    }
    
    .quick-action-arrow {
        color: #cbd5e0 !important;
        font-size: 1.25rem !important;
        margin-left: auto !important;
    }
    
    .stat-card-modern {
        background: white !important;
        border-radius: 20px !important;
        padding: 0 !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07) !important;
        transition: all 0.3s ease !important;
        overflow: hidden !important;
        position: relative !important;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }
    
    .stat-card-content {
        padding: 1.75rem !important;
        position: relative !important;
        z-index: 1 !important;
    }
    
    .stat-icon-wrapper {
        position: relative !important;
    }
    
    .stat-icon {
        width: 60px !important;
        height: 60px !important;
        border-radius: 15px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 26px !important;
        color: white !important;
        box-shadow: 0 10px 15px rgba(0,0,0,0.1) !important;
    }
    
    .stat-icon.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .stat-icon.success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
    }
    
    .stat-icon.info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%) !important;
    }
    
    .stat-icon.warning {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%) !important;
    }
    
    .stat-label {
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        color: #718096 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 0.75rem !important;
    }
    
    .stat-value {
        font-size: 2.5rem !important;
        font-weight: 800 !important;
        color: #2d3748 !important;
        line-height: 1 !important;
        margin-bottom: 0.5rem !important;
    }
    
    .trend-badge {
        padding: 0.5rem 0.85rem !important;
        border-radius: 10px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
    }
    
    .trend-badge.success {
        background: #f0fdf4 !important;
        color: #166534 !important;
        border: 1px solid #bbf7d0 !important;
    }
    
    .trend-badge.danger {
        background: #fef2f2 !important;
        color: #991b1b !important;
        border: 1px solid #fecaca !important;
    }
    
    .modern-card {
        background: white !important;
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        overflow: hidden !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07) !important;
    }
    
    .modern-card-header {
        padding: 1.5rem !important;
        background: linear-gradient(to right, #f7fafc, #edf2f7) !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    
    .modern-card-title {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        color: #2d3748 !important;
        margin: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Banner with Animation -->
    <div class="welcome-banner mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="welcome-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div>
                        <h1 class="welcome-title mb-2">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="welcome-subtitle mb-0">
                            <i class="fas fa-location-dot me-2"></i>
                            Dashboard Sistem Manajemen Pertanian Kabupaten Toba
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="date-time-widget">
                    <div class="current-date">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span id="currentDate">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </div>
                    <div class="current-time mt-2">
                        <i class="fas fa-clock me-2"></i>
                        <span id="currentTime">{{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="quick-actions-bar mb-5">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('input.bantuan') }}" class="quick-action-btn primary">
                    <div class="quick-action-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="quick-action-content">
                        <span class="quick-action-title">Tambah Bantuan</span>
                        <small class="quick-action-desc">Input data bantuan baru</small>
                    </div>
                    <i class="fas fa-arrow-right quick-action-arrow"></i>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('input.laporan') }}" class="quick-action-btn success">
                    <div class="quick-action-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="quick-action-content">
                        <span class="quick-action-title">Buat Laporan</span>
                        <small class="quick-action-desc">Tambah laporan baru</small>
                    </div>
                    <i class="fas fa-arrow-right quick-action-arrow"></i>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.petani.index') }}" class="quick-action-btn info">
                    <div class="quick-action-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="quick-action-content">
                        <span class="quick-action-title">Kelola Petani</span>
                        <small class="quick-action-desc">Manajemen data petani</small>
                    </div>
                    <i class="fas fa-arrow-right quick-action-arrow"></i>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('monitoring') }}" class="quick-action-btn warning">
                    <div class="quick-action-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="quick-action-content">
                        <span class="quick-action-title">Monitoring</span>
                        <small class="quick-action-desc">Pantau progres bantuan</small>
                    </div>
                    <i class="fas fa-arrow-right quick-action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row with Enhanced Design -->
    <div class="row g-4 mb-5">
        <!-- Bantuan Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-modern stat-primary" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card-bg"></div>
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon primary">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div class="stat-icon-pulse"></div>
                        </div>
                        <div class="stat-badge">
                            <span class="trend-badge success">
                                <i class="fas fa-arrow-up"></i> +12%
                            </span>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Bantuan Hari Ini</h6>
                        <h2 class="stat-value">{{ $bantuan_hari_ini }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-info-circle me-1"></i>
                            Dibandingkan kemarin
                        </p>
                    </div>
                    <div class="stat-footer">
                        <a href="{{ route('daftar.bantuan') }}" class="stat-link">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Petani -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-modern stat-success" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card-bg"></div>
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon success">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-icon-pulse"></div>
                        </div>
                        <div class="stat-badge">
                            <span class="trend-badge success">
                                <i class="fas fa-user-plus"></i> +{{ rand(5, 15) }}
                            </span>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Total Petani</h6>
                        <h2 class="stat-value">{{ $total_petani }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-info-circle me-1"></i>
                            Petani terdaftar aktif
                        </p>
                    </div>
                    <div class="stat-footer">
                        <a href="{{ route('admin.petani.index') }}" class="stat-link">
                            Kelola Petani <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Baru -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-modern stat-info" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card-bg"></div>
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon info">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="stat-icon-pulse"></div>
                        </div>
                        <div class="stat-badge">
                            @if($laporan_baru > 0)
                                <span class="trend-badge danger">
                                    <i class="fas fa-exclamation"></i> Urgen
                                </span>
                            @else
                                <span class="trend-badge success">
                                    <i class="fas fa-check"></i> Clear
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Laporan Baru</h6>
                        <h2 class="stat-value">{{ $laporan_baru }}</h2>
                        <p class="stat-desc">
                            <i class="fas fa-info-circle me-1"></i>
                            Menunggu peninjauan
                        </p>
                    </div>
                    <div class="stat-footer">
                        <a href="{{ route('daftar.laporan') }}" class="stat-link">
                            Tinjau Laporan <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Hasil Panen -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-modern stat-warning" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card-bg"></div>
                <div class="stat-card-content">
                    <div class="stat-header">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon warning">
                                <i class="fas fa-tractor"></i>
                            </div>
                            <div class="stat-icon-pulse"></div>
                        </div>
                        <div class="stat-badge">
                            <span class="trend-badge success">
                                <i class="fas fa-seedling"></i> +{{ rand(10, 25) }}%
                            </span>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">Total Hasil Panen</h6>
                        <h2 class="stat-value">
                            {{ number_format($total_hasil_panen) }}
                            <small class="stat-unit">kg</small>
                        </h2>
                        <p class="stat-desc">
                            <i class="fas fa-info-circle me-1"></i>
                            Produktivitas bulan ini
                        </p>
                    </div>
                    <div class="stat-footer">
                        <a href="{{ route('hasil.panen') }}" class="stat-link">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Notifications Row with Enhanced Design -->
    <div class="row g-4 mb-5">
        <!-- Chart Section -->
        <div class="col-lg-8">
            <div class="modern-card shadow-sm">
                <div class="modern-card-header border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h5 class="modern-card-title mb-2">
                                <i class="fas fa-chart-line text-primary me-2"></i>
                                Ringkasan Bantuan Mingguan
                            </h5>
                            <p class="text-sm mb-0 text-muted">
                                <i class="fa fa-arrow-up text-success me-1"></i>
                                <span class="font-weight-bold text-success">{{ $bantuan_hari_ini > 0 ? '+' . $bantuan_hari_ini * 10 . '%' : '0%' }}</span> 
                                dibandingkan minggu lalu
                            </p>
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-modern-outline active">
                                <i class="fas fa-calendar-week me-1"></i> Minggu
                            </button>
                            <button class="btn btn-sm btn-modern-outline">
                                <i class="fas fa-calendar-alt me-1"></i> Bulan
                            </button>
                            <button class="btn btn-sm btn-modern-outline">
                                <i class="fas fa-calendar me-1"></i> Tahun
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modern-card-body" style="min-height: 400px;">
                    @if($bantuans->count() == 0)
                        <div class="empty-state-modern">
                            <div class="empty-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="mt-3">Belum Ada Data Bantuan</h5>
                            <p class="text-muted mb-0">Grafik akan muncul setelah ada data bantuan yang ditambahkan.</p>
                            <a href="{{ route('input.bantuan') }}" class="btn btn-modern-primary btn-sm mt-3">
                                <i class="fas fa-plus me-1"></i> Tambah Bantuan
                            </a>
                        </div>
                    @else
                        <div class="chart-wrapper">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="col-lg-4">
            <div class="modern-card shadow-sm h-100">
                <div class="modern-card-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="modern-card-title mb-0">
                            <i class="fas fa-bell text-warning me-2"></i>
                            Notifikasi & Peringatan
                        </h5>
                        @if($notifications->count() > 0)
                            <span class="badge-modern badge-modern-danger">{{ $notifications->count() }}</span>
                        @endif
                    </div>
                </div>
                <div class="modern-card-body scrollbar-custom" style="max-height: 500px; overflow-y: auto;">
                    <!-- System Status -->
                    <div class="alert-modern alert-modern-success mb-3">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <div class="fw-bold">Sistem Berjalan Normal</div>
                            <small>Semua layanan beroperasi dengan baik</small>
                        </div>
                    </div>

                    <!-- User Notifications -->
                    @forelse($notifications as $notification)
                        <div class="alert-modern alert-modern-{{ $notification->data['color'] ?? 'info' }} mb-3 {{ $notification->read_at ? 'opacity-50' : '' }}">
                            <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }}"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $notification->data['title'] }}</div>
                                <small class="d-block mb-2">{{ $notification->data['message'] }}</small>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                    @if(!$notification->read_at)
                                        <button class="btn btn-sm btn-modern-success" onclick="markAsReadFromDashboard('{{ $notification->id }}')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    <!-- Dynamic Alerts -->
                    @if($laporan_baru > 0)
                        <div class="alert-modern alert-modern-warning mb-3">
                            <i class="fas fa-file-alt"></i>
                            <div>
                                <div class="fw-bold">{{ $laporan_baru }} Laporan Baru</div>
                                <small>Ada laporan yang perlu diperiksa segera</small>
                            </div>
                        </div>
                    @endif

                    @if($bantuan_hari_ini > 0)
                        <div class="alert-modern alert-modern-danger mb-3">
                            <i class="fas fa-hand-holding-heart"></i>
                            <div>
                                <div class="fw-bold">Bantuan Hari Ini</div>
                                <small>{{ $bantuan_hari_ini }} bantuan perlu diproses hari ini</small>
                            </div>
                        </div>
                    @endif

                    @if($notifications->count() == 0 && $laporan_baru == 0 && $bantuan_hari_ini == 0)
                        <div class="empty-state-modern py-4">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <p class="text-muted mb-0">Tidak ada notifikasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row with Enhanced Design -->
    <div class="row g-4">
        <!-- Recent Bantuan Table -->
        <div class="col-lg-8">
            <div class="modern-card shadow-sm">
                <div class="modern-card-header border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h5 class="modern-card-title mb-2">
                                <i class="fas fa-list text-success me-2"></i>
                                Daftar Bantuan Terbaru
                            </h5>
                            <p class="text-sm mb-0 text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                5 bantuan terakhir yang ditambahkan
                            </p>
                        </div>
                        <a href="{{ route('daftar.bantuan') }}" class="btn btn-modern-primary btn-sm">
                            <i class="fas fa-eye me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="modern-card-body p-0">
                    <div class="modern-table-container">
                        <table class="modern-table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-tag me-1"></i> Jenis Bantuan</th>
                                    <th><i class="fas fa-user me-1"></i> Penerima</th>
                                    <th class="text-center"><i class="fas fa-boxes me-1"></i> Jumlah</th>
                                    <th class="text-center"><i class="fas fa-tasks me-1"></i> Status</th>
                                    <th><i class="fas fa-calendar me-1"></i> Tanggal</th>
                                    <th class="text-center"><i class="fas fa-cog me-1"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bantuans as $bantuan)
                                    <tr class="table-row-hover">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-modern avatar-modern-sm avatar-success">
                                                    <i class="fas fa-seedling"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $bantuan->jenis_bantuan }}</div>
                                                    @if($bantuan->catatan)
                                                        <small class="text-muted">{{ Str::limit($bantuan->catatan, 30) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $bantuan->user->profile_picture ? asset('storage/' . $bantuan->user->profile_picture) : asset('img/default-avatar.png') }}"
                                                     alt="Avatar" class="avatar-modern avatar-modern-sm rounded-circle"
                                                     style="width: 35px; height: 35px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $bantuan->user->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ $bantuan->user->alamat_desa ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-modern badge-modern-success px-3 py-2">
                                                <i class="fas fa-box me-1"></i>
                                                {{ number_format($bantuan->jumlah) }} unit
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($bantuan->status == 'Dikirim')
                                                <span class="badge-modern badge-modern-success">
                                                    <i class="fas fa-check-circle me-1"></i>Dikirim
                                                </span>
                                            @elseif($bantuan->status == 'Diproses')
                                                <span class="badge-modern badge-modern-warning">
                                                    <i class="fas fa-clock me-1"></i>Diproses
                                                </span>
                                            @else
                                                <span class="badge-modern badge-modern-info">
                                                    <i class="fas fa-question-circle me-1"></i>{{ $bantuan->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($bantuan->tanggal)->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="action-buttons justify-content-center">
                                                <button class="btn-icon-modern btn-modern-info" title="Detail" onclick="showBantuanDetail({{ $bantuan->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn-icon-modern btn-modern-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn-icon-modern btn-modern-danger" title="Hapus" 
                                                        onclick="deleteBantuan({{ $bantuan->id }}, '{{ $bantuan->jenis_bantuan }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border-0">
                                            <div class="empty-state-modern py-5">
                                                <div class="empty-icon">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <h5 class="mt-3">Belum Ada Data Bantuan</h5>
                                                <p class="text-muted mb-3">Bantuan terbaru akan muncul di sini setelah ditambahkan.</p>
                                                <a href="{{ route('input.bantuan') }}" class="btn btn-modern-primary btn-sm">
                                                    <i class="fas fa-plus me-1"></i> Tambah Bantuan Baru
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="col-lg-4">
            <div class="modern-card shadow-sm h-100">
                <div class="modern-card-header border-bottom">
                    <h5 class="modern-card-title mb-0">
                        <i class="fas fa-file-alt text-info me-2"></i>
                        Laporan Terbaru
                    </h5>
                </div>
                <div class="modern-card-body scrollbar-custom" style="max-height: 500px; overflow-y: auto;">
                    @forelse ($laporans as $laporan)
                        <div class="report-item mb-3 p-3 rounded shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-left: 4px solid var(--info);">
                            <div class="d-flex align-items-start gap-3">
                                <div class="avatar-modern avatar-modern-md" style="background: rgba(255,255,255,0.2); color: white;">
                                    <i class="fas fa-file-lines"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-2 text-white">{{ Str::limit($laporan->deskripsi_kemajuan, 35) }}</div>
                                    <div class="d-flex flex-column gap-1">
                                        <small class="text-white opacity-75">
                                            <i class="fas fa-weight-hanging me-1"></i>
                                            Hasil: {{ number_format($laporan->hasil_panen) }} kg
                                        </small>
                                        <small class="text-white opacity-75">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('edit.laporan', $laporan->id) }}" class="btn btn-light btn-sm">
                                            <i class="fas fa-edit me-1"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-modern py-4">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <p class="text-muted mb-3">Tidak ada laporan terbaru</p>
                            <a href="{{ route('input.laporan') }}" class="btn btn-modern-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Buat Laporan
                            </a>
                        </div>
                    @endforelse
                </div>
                @if($laporans->count() > 0)
                    <div class="modern-card-footer border-top">
                        <a href="{{ route('daftar.laporan') }}" class="btn btn-modern-outline btn-sm w-100">
                            <i class="fas fa-arrow-right me-1"></i> Lihat Semua Laporan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chart.js for Bantuan Mingguan
    @if($bantuans->count() > 0)
    var ctx1 = document.getElementById("chart-line");
    
    if (ctx1) {
        var gradientStroke1 = ctx1.getContext("2d").createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(79, 70, 229, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(79, 70, 229, 0.05)');
        gradientStroke1.addColorStop(0, 'rgba(79, 70, 229, 0)');

        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
                datasets: [{
                    label: "Jumlah Bantuan",
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: "#4F46E5",
                    pointBorderColor: "white",
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    borderColor: "#4F46E5",
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: [12, 15, 8, 22, 18, 25, {{ $bantuan_hari_ini }}],
                    maxBarThickness: 6
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'white',
                        titleColor: '#1F2937',
                        bodyColor: '#6B7280',
                        borderColor: '#4F46E5',
                        borderWidth: 2,
                        cornerRadius: 8,
                        displayColors: false,
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            title: function(context) {
                                return 'Hari: ' + context[0].label;
                            },
                            label: function(context) {
                                return 'Bantuan: ' + context.parsed.y + ' unit';
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#E5E7EB'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#6B7280',
                            font: {
                                size: 12,
                                family: "Inter",
                                weight: '500'
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: true,
                            color: '#6B7280',
                            padding: 10,
                            font: {
                                size: 12,
                                family: "Inter",
                                weight: '500'
                            },
                        }
                    },
                },
            },
        });
    }
    @endif

    // Mark notification as read
    window.markAsReadFromDashboard = function(notificationId) {
        fetch('/notifications/' + notificationId + '/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    };

    // Show bantuan detail modal (using modern modal design)
    window.showBantuanDetail = function(bantuanId) {
        fetch('/bantuan/' + bantuanId)
            .then(response => response.json())
            .then(data => {
                const modalHtml = `
                    <div class="modal fade modal-modern" id="bantuanDetailModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="fas fa-info-circle me-2"></i>Detail Bantuan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-modern avatar-modern-md avatar-info">
                                                            <i class="fas fa-seedling"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Jenis Bantuan</small>
                                                            <div class="fw-bold">${data.jenis_bantuan}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-modern avatar-modern-md avatar-success">
                                                            <i class="fas fa-hashtag"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Jumlah</small>
                                                            <div class="fw-bold">${data.jumlah} unit</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-modern avatar-modern-md avatar-warning">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Tanggal</small>
                                                            <div class="fw-bold">${new Date(data.tanggal).toLocaleDateString('id-ID')}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-modern avatar-modern-md ${data.status === 'Dikirim' ? 'avatar-success' : 'avatar-warning'}">
                                                            <i class="fas fa-tasks"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Status</small>
                                                            <span class="badge-modern badge-modern-${data.status === 'Dikirim' ? 'success' : 'warning'}">
                                                                ${data.status}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        ${data.catatan ? `
                                        <div class="col-12">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="fas fa-sticky-note me-1"></i>Catatan
                                                    </small>
                                                    <p class="mb-0">${data.catatan}</p>
                                                </div>
                                            </div>
                                        </div>
                                        ` : ''}
                                        ${data.user ? `
                                        <div class="col-12">
                                            <div class="modern-card">
                                                <div class="modern-card-body">
                                                    <small class="text-muted d-block mb-3">
                                                        <i class="fas fa-user me-1"></i>Penerima Bantuan
                                                    </small>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="${data.user.profile_picture ? '/storage/' + data.user.profile_picture : '/img/default-avatar.png'}" 
                                                             class="avatar-modern avatar-modern-lg avatar-primary" style="object-fit: cover;">
                                                        <div>
                                                            <div class="fw-bold mb-1">${data.user.name}</div>
                                                            <small class="text-muted d-block">${data.user.email}</small>
                                                            <small class="text-muted">${data.user.alamat_desa || 'N/A'}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-modern-outline" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Tutup
                                    </button>
                                    <a href="/edit-bantuan/${data.id}" class="btn btn-modern-primary">
                                        <i class="fas fa-edit me-1"></i>Edit Bantuan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const existingModal = document.getElementById('bantuanDetailModal');
                if (existingModal) existingModal.remove();
                
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                new bootstrap.Modal(document.getElementById('bantuanDetailModal')).show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat detail bantuan.');
            });
    };

    // Delete bantuan
    window.deleteBantuan = function(bantuanId, jenisBantuan) {
        if (confirm(`Apakah Anda yakin ingin menghapus bantuan "${jenisBantuan}"?`)) {
            fetch('/delete-bantuan/' + bantuanId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Bantuan berhasil dihapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus bantuan.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus bantuan.');
            });
        }
    };

    // Check tables route (for debugging)
    function checkTables() {
        fetch('/check-tables')
            .then(response => response.json())
            .then(data => {
                console.log('Tables:', data);
                alert('Cek console untuk daftar tabel.');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memeriksa tabel.');
            });
    }
</script>
@endsection
