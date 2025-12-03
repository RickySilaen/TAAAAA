@extends('layouts.guest')

@section('title', 'Transparansi Bantuan Pertanian - Dinas Pertanian Kabupaten Toba')

@push('styles')
<style>
    /* Premium Hero Section */
    .laporan-hero-premium {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        padding: 8rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .hero-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        z-index: 1;
    }

    .particle {
        position: absolute;
        font-size: 3rem;
        opacity: 0.1;
        animation: float-particle 15s infinite;
    }

    .particle-1 { top: 10%; left: 10%; animation-delay: 0s; }
    .particle-2 { top: 60%; left: 80%; animation-delay: 2s; }
    .particle-3 { top: 30%; left: 60%; animation-delay: 4s; }
    .particle-4 { top: 70%; left: 20%; animation-delay: 6s; }
    .particle-5 { top: 40%; left: 90%; animation-delay: 8s; }

    @keyframes float-particle {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }

    .hero-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        margin-bottom: 2rem;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: #ffc107;
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    .hero-title-premium {
        font-size: 4rem;
        font-weight: 900;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.1;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .text-gradient {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle-premium {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.95);
        max-width: 700px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .hero-wave svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 80px;
    }

    /* Premium Stats Cards */
    .premium-stat-card {
        position: relative;
        background: white;
        border-radius: 24px;
        padding: 2rem;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .premium-stat-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .stat-card-bg {
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        opacity: 0.1;
    }

    .gradient-emerald { background: linear-gradient(135deg, #2e7d32, #43a047); }
    .gradient-amber { background: linear-gradient(135deg, #f57c00, #ffb300); }
    .gradient-blue { background: linear-gradient(135deg, #1976d2, #42a5f5); }

    .stat-card-content {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .stat-icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2e7d32, #43a047);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(46,125,50,0.3);
        flex-shrink: 0;
    }

    .stat-icon-wrapper.amber {
        background: linear-gradient(135deg, #f57c00, #ffb300);
        box-shadow: 0 8px 25px rgba(245,124,0,0.3);
    }

    .stat-icon-wrapper.blue {
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        box-shadow: 0 8px 25px rgba(25,118,210,0.3);
    }

    .stat-icon-inner {
        font-size: 2.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    .stat-details {
        flex: 1;
    }

    .stat-label-premium {
        display: block;
        font-size: 0.9rem;
        color: #666;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value-premium {
        font-size: 2.5rem;
        font-weight: 900;
        color: #1a1a1a;
        margin: 0 0 0.5rem;
        line-height: 1;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #666;
        font-weight: 500;
    }

    .badge-dot-sm {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-dot-sm.green { background: #2e7d32; }
    .badge-dot-sm.amber { background: #f57c00; }
    .badge-dot-sm.blue { background: #1976d2; }

    /* Premium Filter Card */
    .premium-filter {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(46,125,50,0.1);
    }

    .filter-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 0.5rem;
    }

    .filter-input-group {
        position: relative;
    }

    .filter-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
    }

    .filter-input {
        width: 100%;
        padding: 14px 20px 14px 48px;
        border: 2px solid rgba(46,125,50,0.1);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-input:focus {
        outline: none;
        border-color: #2e7d32;
        box-shadow: 0 0 0 4px rgba(46,125,50,0.1);
    }

    .filter-select {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid rgba(46,125,50,0.1);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2e7d32;
        box-shadow: 0 0 0 4px rgba(46,125,50,0.1);
    }

    /* Report Cards Grid */
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .report-card-premium {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .report-card-premium:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .report-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .report-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .report-card-premium:hover .report-image-wrapper img {
        transform: scale(1.15);
    }

    .report-verified-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(46,125,50,0.95);
        backdrop-filter: blur(10px);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }

    .report-content-premium {
        padding: 1.75rem;
    }

    .report-title-premium {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 1rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .report-meta-grid {
        display: grid;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .report-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        color: #666;
    }

    .meta-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .report-description-premium {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .report-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .report-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .report-badge-item {
        padding: 6px 14px;
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: white;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .btn-detail-premium {
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-detail-premium:hover {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        color: white;
    }

    /* Empty State */
    .empty-state-premium {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .empty-icon {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #666;
        margin-bottom: 1rem;
    }

    .empty-text {
        font-size: 1.1rem;
        color: #999;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Animations */
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slide-up {
        animation: slideUp 1s ease-out;
    }

    .animate-slide-up-delay {
        animation: slideUp 1s ease-out 0.2s both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title-premium {
            font-size: 2.5rem;
        }
        
        .reports-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Premium Hero Section -->
<section class="laporan-hero-premium">
    <div class="hero-particles">
        <div class="particle particle-1">🤝</div>
        <div class="particle particle-2">📦</div>
        <div class="particle particle-3">✅</div>
        <div class="particle particle-4">📊</div>
        <div class="particle particle-5">🌾</div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-badge-premium animate-fade-in">
                    <span class="badge-dot"></span>
                    <span>Portal Transparansi</span>
                </div>
                <h1 class="hero-title-premium animate-slide-up">
                    Transparansi<br>
                    <span class="text-gradient">Bantuan Pertanian</span>
                </h1>
                <p class="hero-subtitle-premium animate-slide-up-delay">
                    Pantau penyaluran dan pemanfaatan bantuan pertanian secara real-time dan transparan untuk mendukung kesejahteraan petani Kabupaten Toba.
                </p>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#f8fdf9"></path>
        </svg>
    </div>
</section>

<div class="container py-5" style="background: #f8fdf9;">
    <!-- Premium Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="premium-stat-card">
                <div class="stat-card-bg gradient-emerald"></div>
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-inner">📋</div>
                    </div>
                    <div class="stat-details">
                        <span class="stat-label-premium">Total Laporan</span>
                        <h2 class="stat-value-premium">{{ $reports->total() }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm green"></span>
                            Laporan transparan
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="premium-stat-card">
                <div class="stat-card-bg gradient-amber"></div>
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper amber">
                        <div class="stat-icon-inner">📦</div>
                    </div>
                    <div class="stat-details">
                        <span class="stat-label-premium">Jenis Bantuan</span>
                        <h2 class="stat-value-premium">{{ $jenisBantuanList->count() }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm amber"></span>
                            Program tersalurkan
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="premium-stat-card">
                <div class="stat-card-bg gradient-blue"></div>
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper blue">
                        <div class="stat-icon-inner">👨‍🌾</div>
                    </div>
                    <div class="stat-details">
                        <span class="stat-label-premium">Petani Terdaftar</span>
                        <h2 class="stat-value-premium">{{ \App\Models\User::where('role', 'petani')->count() }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm blue"></span>
                            Penerima bantuan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Filter -->
    <div class="premium-filter" data-aos="fade-up">
        <form action="{{ route('transparansi.bantuan') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-lg-6 col-md-6">
                <label class="filter-label">🔍 Cari Laporan</label>
                <div class="filter-input-group">
                    <span class="filter-icon">🔍</span>
                    <input type="text" 
                           class="filter-input" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Cari berdasarkan judul, deskripsi, atau nama petani...">
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <label class="filter-label">📦 Filter Jenis Bantuan</label>
                <select class="filter-select" name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisBantuanList as $jenisBantuan)
                        <option value="{{ $jenisBantuan }}" {{ $jenis == $jenisBantuan ? 'selected' : '' }}>
                            {{ $jenisBantuan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-2">
                <button type="submit" class="btn-detail-premium w-100">
                    <span>🔍</span>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Reports Grid -->
    @if($reports->count() > 0)
        <div class="reports-grid">
            @foreach($reports as $index => $laporan)
            <div class="report-card-premium" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 50) }}">
                <div class="report-image-wrapper">
                    <img src="{{ !empty($laporan->foto_bukti_urls) ? $laporan->foto_bukti_urls[0] : asset('images/default-report.jpg') }}" 
                         alt="{{ $laporan->judul }}">
                    <div class="report-verified-badge">
                        <span>✅</span>
                        <span>Terverifikasi</span>
                    </div>
                </div>

                <div class="report-content-premium">
                    <h3 class="report-title-premium">{{ $laporan->judul }}</h3>
                    
                    <div class="report-meta-grid">
                        <div class="report-meta-item">
                            <div class="meta-icon">👤</div>
                            <span>{{ $laporan->user->name }}</span>
                        </div>
                        <div class="report-meta-item">
                            <div class="meta-icon">📅</div>
                            <span>{{ $laporan->tanggal_pelaporan->format('d F Y') }}</span>
                        </div>
                        <div class="report-meta-item">
                            <div class="meta-icon">📍</div>
                            <span>{{ $laporan->alamat_desa ?? 'N/A' }}, {{ $laporan->alamat_kecamatan ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <p class="report-description-premium">{{ $laporan->deskripsi }}</p>

                    <div class="report-footer">
                        <div class="report-badges">
                            <span class="report-badge-item">{{ $laporan->jenis_bantuan }}</span>
                            @if($laporan->jumlah_bantuan)
                                <span class="report-badge-item" style="background: linear-gradient(135deg, #1976d2, #42a5f5);">
                                    {{ number_format($laporan->jumlah_bantuan, 0, ',', '.') }} {{ $laporan->satuan }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('transparansi.bantuan.show', $laporan->id) }}" class="btn-detail-premium">
                            Detail
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $reports->links() }}
        </div>
    @else
        <div class="empty-state-premium" data-aos="fade-up">
            <div class="empty-icon">📭</div>
            <h3 class="empty-title">Belum ada laporan</h3>
            <p class="empty-text">
                @if($search || $jenis)
                    Tidak ada laporan yang sesuai dengan filter yang dipilih. Silakan coba kata kunci atau filter lainnya.
                @else
                    Laporan bantuan akan ditampilkan di sini setelah diverifikasi dan dipublikasikan.
                @endif
            </p>
        </div>
    @endif
</div>

@endsection
