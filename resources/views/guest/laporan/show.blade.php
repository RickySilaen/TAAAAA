@extends('layouts.guest')

@section('title', 'Detail Laporan - Sistem Pertanian')

@section('content')
<!-- Animated Hero Section -->
<section class="detail-hero">
    <div class="hero-bg-animation">
        <div class="floating-leaf leaf-1">🍃</div>
        <div class="floating-leaf leaf-2">🌿</div>
        <div class="floating-leaf leaf-3">🌾</div>
        <div class="floating-leaf leaf-4">🍂</div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-badge animate-fade-in">
                    <span class="badge-icon">📊</span>
                    <span>Detail Laporan Panen</span>
                </div>
                <h1 class="hero-title animate-slide-up">Laporan Hasil Panen</h1>
                <p class="hero-subtitle animate-slide-up-delay">
                    Informasi lengkap laporan hasil panen yang sudah diverifikasi oleh petugas
                </p>
                
                <!-- Breadcrumb -->
                <nav class="breadcrumb-modern animate-fade-in-delay">
                    <a href="{{ route('home') }}">🏠 Beranda</a>
                    <span class="separator">›</span>
                    <a href="{{ route('laporan.publik') }}">📋 Laporan</a>
                    <span class="separator">›</span>
                    <span class="current">Detail</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Main Info Card -->
            <div class="premium-card main-card animate-card-up">
                <div class="card-glow"></div>
                <div class="card-header-premium">
                    <div class="header-left">
                        <div class="header-icon pulse-animation">
                            🌾
                        </div>
                        <div class="header-text">
                            <h4>Informasi Laporan</h4>
                            <p>Data lengkap hasil panen petani</p>
                        </div>
                    </div>
                    @if($laporan->status === 'verified')
                        <div class="verified-badge shine-effect">
                            <span class="badge-check">✓</span>
                            <span>Terverifikasi</span>
                        </div>
                    @endif
                </div>
                
                <div class="card-body-premium">
                    <!-- Quick Stats Row -->
                    <div class="quick-stats-row">
                        <div class="quick-stat gradient-green">
                            <div class="stat-icon-wrapper">
                                <span class="stat-emoji">🌱</span>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Jenis Tanaman</span>
                                <span class="stat-value">{{ $laporan->jenis_tanaman ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="quick-stat gradient-blue">
                            <div class="stat-icon-wrapper">
                                <span class="stat-emoji">⚖️</span>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Hasil Panen</span>
                                <span class="stat-value">{{ number_format($laporan->hasil_panen, 0) }} <small>kg</small></span>
                            </div>
                        </div>
                        <div class="quick-stat gradient-purple">
                            <div class="stat-icon-wrapper">
                                <span class="stat-emoji">📐</span>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Luas Lahan</span>
                                <span class="stat-value">{{ number_format($laporan->luas_lahan ?? 0) }} <small>m²</small></span>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="detail-grid">
                        <!-- Deskripsi -->
                        <div class="detail-item full-width glass-effect">
                            <div class="detail-header">
                                <span class="detail-icon">📝</span>
                                <span class="detail-title">Deskripsi Kemajuan</span>
                            </div>
                            <div class="detail-body">
                                <p class="description-text">{{ $laporan->deskripsi_kemajuan ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="detail-item glass-effect">
                            <div class="detail-header">
                                <span class="detail-icon">📅</span>
                                <span class="detail-title">Tanggal Laporan</span>
                            </div>
                            <div class="detail-body">
                                <div class="date-display">
                                    <span class="date-day">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d') }}</span>
                                    <div class="date-month-year">
                                        <span class="date-month">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('F') }}</span>
                                        <span class="date-year">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="detail-item glass-effect">
                            <div class="detail-header">
                                <span class="detail-icon">📋</span>
                                <span class="detail-title">Status</span>
                            </div>
                            <div class="detail-body">
                                <div class="status-pills">
                                    @if($laporan->status === 'verified')
                                        <span class="status-pill verified">
                                            <span class="pill-dot"></span>
                                            Terverifikasi
                                        </span>
                                    @elseif($laporan->status === 'rejected')
                                        <span class="status-pill rejected">
                                            <span class="pill-dot"></span>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="status-pill pending">
                                            <span class="pill-dot"></span>
                                            Menunggu
                                        </span>
                                    @endif
                                    
                                    @if($laporan->hasil_panen > 0)
                                        <span class="status-pill harvested">
                                            <span class="pill-dot"></span>
                                            Sudah Panen
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($laporan->catatan)
                        <!-- Catatan -->
                        <div class="detail-item full-width glass-effect note-item">
                            <div class="detail-header">
                                <span class="detail-icon">💬</span>
                                <span class="detail-title">Catatan Tambahan</span>
                            </div>
                            <div class="detail-body">
                                <div class="note-box">
                                    <p>{{ $laporan->catatan }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Productivity Analytics Card -->
            @if($laporan->hasil_panen > 0 && $laporan->luas_lahan > 0)
            <div class="premium-card analytics-card animate-card-up-delay">
                <div class="card-header-premium">
                    <div class="header-left">
                        <div class="header-icon">
                            📈
                        </div>
                        <div class="header-text">
                            <h4>Analisis Produktivitas</h4>
                            <p>Performa hasil panen</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body-premium">
                    <div class="analytics-grid">
                        <div class="analytics-item">
                            <div class="analytics-circle green">
                                <svg viewBox="0 0 36 36" class="circular-chart">
                                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    <path class="circle" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                </svg>
                                <div class="analytics-value">
                                    <span class="value-number">{{ number_format($laporan->hasil_panen) }}</span>
                                    <span class="value-unit">kg</span>
                                </div>
                            </div>
                            <span class="analytics-label">Total Hasil Panen</span>
                        </div>

                        <div class="analytics-item">
                            <div class="analytics-circle blue">
                                <svg viewBox="0 0 36 36" class="circular-chart">
                                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    <path class="circle" stroke-dasharray="85, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                </svg>
                                <div class="analytics-value">
                                    <span class="value-number">{{ number_format($laporan->luas_lahan) }}</span>
                                    <span class="value-unit">m²</span>
                                </div>
                            </div>
                            <span class="analytics-label">Luas Lahan</span>
                        </div>

                        <div class="analytics-item">
                            <div class="analytics-circle purple">
                                <svg viewBox="0 0 36 36" class="circular-chart">
                                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    <path class="circle" stroke-dasharray="90, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                </svg>
                                <div class="analytics-value">
                                    <span class="value-number">{{ number_format($laporan->hasil_panen / $laporan->luas_lahan, 2) }}</span>
                                    <span class="value-unit">kg/m²</span>
                                </div>
                            </div>
                            <span class="analytics-label">Produktivitas</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="productivity-meter">
                        <div class="meter-header">
                            <span>Tingkat Produktivitas</span>
                            <span class="meter-value">{{ min(100, round(($laporan->hasil_panen / $laporan->luas_lahan) * 20)) }}%</span>
                        </div>
                        <div class="meter-bar">
                            <div class="meter-fill" style="width: {{ min(100, round(($laporan->hasil_panen / $laporan->luas_lahan) * 20)) }}%"></div>
                        </div>
                        <div class="meter-labels">
                            <span>Rendah</span>
                            <span>Sedang</span>
                            <span>Tinggi</span>
                            <span>Excellent</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Action Card -->
            <div class="premium-card action-card animate-card-right">
                <div class="card-header-compact">
                    <span class="header-emoji">⚡</span>
                    <span>Aksi Cepat</span>
                </div>
                <div class="card-body-compact">
                    <button type="button" class="action-btn btn-print" onclick="printLaporan()">
                        <span class="btn-icon">🖨️</span>
                        <span class="btn-text">Cetak Laporan</span>
                        <span class="btn-arrow">→</span>
                    </button>
                    <button type="button" class="action-btn btn-share" onclick="shareLaporan()">
                        <span class="btn-icon">📤</span>
                        <span class="btn-text">Bagikan</span>
                        <span class="btn-arrow">→</span>
                    </button>
                    <a href="{{ route('laporan.publik') }}" class="action-btn btn-back-list">
                        <span class="btn-icon">←</span>
                        <span class="btn-text">Kembali ke Daftar</span>
                        <span class="btn-arrow">→</span>
                    </a>
                </div>
            </div>

            <!-- Farmer Profile Card -->
            <div class="premium-card farmer-card animate-card-right-delay">
                <div class="card-header-compact">
                    <span class="header-emoji">👤</span>
                    <span>Informasi Petani</span>
                </div>
                <div class="card-body-compact">
                    @if($laporan->user)
                        <!-- Profile Header -->
                        <div class="farmer-profile-header">
                            <div class="avatar-container">
                                <div class="avatar-ring">
                                    <div class="avatar-inner">
                                        {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <span class="online-indicator"></span>
                            </div>
                            <h5 class="farmer-name">{{ $laporan->user->name }}</h5>
                            <span class="farmer-role">
                                <span class="role-dot"></span>
                                Petani Terdaftar
                            </span>
                        </div>

                        <!-- Info List -->
                        <div class="farmer-info-list">
                            <div class="info-item-modern">
                                <div class="info-icon-box blue">📧</div>
                                <div class="info-details">
                                    <span class="info-label">Email</span>
                                    <span class="info-value">{{ $laporan->user->email }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item-modern">
                                <div class="info-icon-box green">🏘️</div>
                                <div class="info-details">
                                    <span class="info-label">Desa</span>
                                    <span class="info-value">{{ $laporan->user->alamat_desa ?? 'Belum diisi' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item-modern">
                                <div class="info-icon-box purple">🗺️</div>
                                <div class="info-details">
                                    <span class="info-label">Kecamatan</span>
                                    <span class="info-value">{{ $laporan->user->alamat_kecamatan ?? 'Belum diisi' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item-modern">
                                <div class="info-icon-box orange">📐</div>
                                <div class="info-details">
                                    <span class="info-label">Total Lahan</span>
                                    <span class="info-value highlight">{{ $laporan->user->luas_lahan ?? 0 }} m²</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="no-farmer-info">
                            <div class="avatar-placeholder">👤</div>
                            <p>Data petani tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timestamp Card -->
            <div class="premium-card timestamp-card animate-card-right-delay-2">
                <div class="card-header-compact">
                    <span class="header-emoji">🕐</span>
                    <span>Riwayat</span>
                </div>
                <div class="card-body-compact">
                    <div class="timeline-mini">
                        <div class="timeline-item">
                            <div class="timeline-dot green"></div>
                            <div class="timeline-content">
                                <span class="timeline-label">Dibuat</span>
                                <span class="timeline-value">{{ $laporan->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot blue"></div>
                            <div class="timeline-content">
                                <span class="timeline-label">Diperbarui</span>
                                <span class="timeline-value">{{ $laporan->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot purple"></div>
                            <div class="timeline-content">
                                <span class="timeline-label">ID Laporan</span>
                                <span class="timeline-value">#{{ str_pad($laporan->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ========================================
       HERO SECTION
    ======================================== */
    .detail-hero {
        background: linear-gradient(135deg, #0d5016 0%, #1a7a2e 50%, #2e9e47 100%);
        padding: 80px 0 100px;
        position: relative;
        overflow: hidden;
    }

    .hero-bg-animation {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .floating-leaf {
        position: absolute;
        font-size: 2rem;
        opacity: 0.15;
        animation: floatLeaf 15s infinite ease-in-out;
    }

    .leaf-1 { top: 10%; left: 10%; animation-delay: 0s; }
    .leaf-2 { top: 20%; right: 15%; animation-delay: 3s; }
    .leaf-3 { bottom: 30%; left: 20%; animation-delay: 6s; }
    .leaf-4 { bottom: 20%; right: 10%; animation-delay: 9s; }

    @keyframes floatLeaf {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-20px) rotate(10deg); }
        50% { transform: translateY(-10px) rotate(-5deg); }
        75% { transform: translateY(-30px) rotate(5deg); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 10px 24px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        margin-bottom: 20px;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .badge-icon {
        font-size: 1.2rem;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 15px;
        text-shadow: 0 2px 20px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        max-width: 600px;
        margin: 0 auto 25px;
        line-height: 1.7;
    }

    .breadcrumb-modern {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.15);
    }

    .breadcrumb-modern a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .breadcrumb-modern a:hover { color: white; }
    .breadcrumb-modern .separator { color: rgba(255,255,255,0.4); }
    .breadcrumb-modern .current { color: white; font-weight: 600; }

    /* ========================================
       ANIMATIONS
    ======================================== */
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .animate-fade-in-delay { animation: fadeIn 0.8s ease-out 0.3s forwards; opacity: 0; }
    .animate-slide-up { animation: slideUp 0.8s ease-out forwards; }
    .animate-slide-up-delay { animation: slideUp 0.8s ease-out 0.2s forwards; opacity: 0; }
    .animate-card-up { animation: cardUp 0.8s ease-out forwards; }
    .animate-card-up-delay { animation: cardUp 0.8s ease-out 0.3s forwards; opacity: 0; }
    .animate-card-right { animation: cardRight 0.8s ease-out forwards; }
    .animate-card-right-delay { animation: cardRight 0.8s ease-out 0.2s forwards; opacity: 0; }
    .animate-card-right-delay-2 { animation: cardRight 0.8s ease-out 0.4s forwards; opacity: 0; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cardUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cardRight {
        from { opacity: 0; transform: translateX(40px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* ========================================
       PREMIUM CARDS
    ======================================== */
    .premium-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 24px;
        position: relative;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .premium-card .card-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(46,158,71,0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .card-header-premium {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 28px;
        border-bottom: 1px solid #f0f0f0;
        background: linear-gradient(180deg, #fafffe 0%, #ffffff 100%);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .header-text h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 4px;
    }

    .header-text p {
        font-size: 0.875rem;
        color: #666;
        margin: 0;
    }

    .verified-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .shine-effect {
        position: relative;
        overflow: hidden;
    }

    .shine-effect::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        50%, 100% { left: 100%; }
    }

    .badge-check {
        font-size: 1rem;
    }

    .card-body-premium {
        padding: 28px;
    }

    /* ========================================
       QUICK STATS ROW
    ======================================== */
    .quick-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .quick-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .quick-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .quick-stat.gradient-green {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .quick-stat.gradient-blue {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    .quick-stat.gradient-purple {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .stat-emoji {
        font-size: 1.5rem;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-info .stat-label {
        font-size: 0.75rem;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info .stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
    }

    .stat-info .stat-value small {
        font-size: 0.75rem;
        font-weight: 500;
        color: #666;
    }

    /* ========================================
       DETAIL GRID
    ======================================== */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .detail-item {
        padding: 20px;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .glass-effect {
        background: linear-gradient(135deg, #f8faf8 0%, #f0f4f0 100%);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }

    .detail-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .detail-icon {
        font-size: 1.25rem;
    }

    .detail-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .description-text {
        font-size: 1rem;
        color: #333;
        line-height: 1.7;
        margin: 0;
    }

    /* Date Display */
    .date-display {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .date-day {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2e9e47;
        line-height: 1;
    }

    .date-month-year {
        display: flex;
        flex-direction: column;
    }

    .date-month {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }

    .date-year {
        font-size: 0.875rem;
        color: #666;
    }

    /* Status Pills */
    .status-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .pill-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: blink 2s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .status-pill.verified {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .status-pill.verified .pill-dot { background: #28a745; }

    .status-pill.rejected {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .status-pill.rejected .pill-dot { background: #dc3545; }

    .status-pill.pending {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
        color: #856404;
    }

    .status-pill.pending .pill-dot { background: #ffc107; }

    .status-pill.harvested {
        background: linear-gradient(135deg, #cce5ff 0%, #b8daff 100%);
        color: #004085;
    }

    .status-pill.harvested .pill-dot { background: #007bff; }

    /* Note Box */
    .note-item {
        background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%) !important;
        border-left: 4px solid #ffc107 !important;
    }

    .note-box {
        background: white;
        padding: 16px;
        border-radius: 12px;
        border: 1px dashed #ffc107;
    }

    .note-box p {
        margin: 0;
        color: #5d4e37;
        font-style: italic;
    }

    /* ========================================
       ANALYTICS CARD
    ======================================== */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .analytics-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .analytics-circle {
        width: 120px;
        height: 120px;
        position: relative;
        margin-bottom: 12px;
    }

    .circular-chart {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .circle-bg {
        fill: none;
        stroke: #eee;
        stroke-width: 2;
    }

    .circle {
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        animation: progress 1.5s ease-out forwards;
    }

    @keyframes progress {
        0% { stroke-dasharray: 0, 100; }
    }

    .analytics-circle.green .circle { stroke: #28a745; }
    .analytics-circle.blue .circle { stroke: #17a2b8; }
    .analytics-circle.purple .circle { stroke: #6f42c1; }

    .analytics-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .value-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1;
    }

    .value-unit {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }

    .analytics-label {
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
    }

    /* Productivity Meter */
    .productivity-meter {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 16px;
    }

    .meter-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-weight: 600;
        color: #333;
    }

    .meter-value {
        color: #28a745;
    }

    .meter-bar {
        height: 12px;
        background: #e9ecef;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .meter-fill {
        height: 100%;
        background: linear-gradient(90deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
        border-radius: 6px;
        transition: width 1.5s ease-out;
    }

    .meter-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #999;
    }

    /* ========================================
       SIDEBAR CARDS
    ======================================== */
    .card-header-compact {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 20px;
        background: linear-gradient(180deg, #fafffe 0%, #ffffff 100%);
        border-bottom: 1px solid #f0f0f0;
        font-weight: 700;
        color: #333;
    }

    .header-emoji {
        font-size: 1.2rem;
    }

    .card-body-compact {
        padding: 20px;
    }

    /* Action Buttons */
    .action-btn {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 14px 18px;
        margin-bottom: 10px;
        border: none;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .action-btn:last-child {
        margin-bottom: 0;
    }

    .btn-icon {
        font-size: 1.2rem;
        margin-right: 12px;
    }

    .btn-text {
        flex: 1;
        text-align: left;
    }

    .btn-arrow {
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .action-btn:hover .btn-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-print:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-share {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .btn-share:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(17, 153, 142, 0.4);
    }

    .btn-back-list {
        background: #f8f9fa;
        color: #333;
        border: 2px solid #e9ecef;
    }

    .btn-back-list:hover {
        background: #28a745;
        color: white;
        border-color: #28a745;
        transform: translateY(-3px);
    }

    /* Farmer Profile */
    .farmer-profile-header {
        text-align: center;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
        margin-bottom: 12px;
    }

    .avatar-ring {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        padding: 4px;
        animation: rotateRing 8s linear infinite;
    }

    @keyframes rotateRing {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .avatar-inner {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        color: #28a745;
    }

    .online-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 16px;
        height: 16px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
    }

    .farmer-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 4px;
    }

    .farmer-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #666;
    }

    .role-dot {
        width: 8px;
        height: 8px;
        background: #28a745;
        border-radius: 50%;
    }

    /* Info Items */
    .farmer-info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-item-modern {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-item-modern:hover {
        background: #f0f4f0;
        transform: translateX(5px);
    }

    .info-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .info-icon-box.blue { background: #e3f2fd; }
    .info-icon-box.green { background: #e8f5e9; }
    .info-icon-box.purple { background: #f3e5f5; }
    .info-icon-box.orange { background: #fff3e0; }

    .info-details {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.75rem;
        color: #999;
        font-weight: 500;
    }

    .info-value {
        font-size: 0.95rem;
        color: #333;
        font-weight: 600;
    }

    .info-value.highlight {
        color: #28a745;
    }

    /* Timeline */
    .timeline-mini {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .timeline-dot.green { background: #28a745; }
    .timeline-dot.blue { background: #17a2b8; }
    .timeline-dot.purple { background: #6f42c1; }

    .timeline-content {
        display: flex;
        flex-direction: column;
    }

    .timeline-label {
        font-size: 0.75rem;
        color: #999;
        font-weight: 500;
    }

    .timeline-value {
        font-size: 0.9rem;
        color: #333;
        font-weight: 600;
    }

    /* No Farmer */
    .no-farmer-info {
        text-align: center;
        padding: 30px 0;
    }

    .avatar-placeholder {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 12px;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 992px) {
        .quick-stats-row {
            grid-template-columns: 1fr;
        }

        .analytics-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .analytics-circle {
            width: 100px;
            height: 100px;
        }
    }

    @media (max-width: 768px) {
        .detail-hero {
            padding: 50px 0 70px;
        }

        .hero-title {
            font-size: 2rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .card-body-premium {
            padding: 20px;
        }

        .date-day {
            font-size: 2rem;
        }
    }

    /* ========================================
       PRINT STYLES
    ======================================== */
    @media print {
        .detail-hero { 
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: 30px 0;
        }

        .premium-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .action-card, .floating-leaf, .btn-arrow {
            display: none !important;
        }

        .animate-card-up, .animate-card-right, .animate-card-right-delay, .animate-card-right-delay-2 {
            animation: none !important;
            opacity: 1 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function printLaporan() {
    window.print();
}

function shareLaporan() {
    if (navigator.share) {
        navigator.share({
            title: 'Detail Laporan Hasil Panen',
            text: 'Lihat detail laporan hasil panen: {{ $laporan->jenis_tanaman ?? "Tanaman" }} - {{ number_format($laporan->hasil_panen) }} kg',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Link berhasil disalin ke clipboard!');
        });
    }
}

// Add smooth scroll behavior
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.premium-card').forEach(card => {
        observer.observe(card);
    });
});
</script>
@endpush
