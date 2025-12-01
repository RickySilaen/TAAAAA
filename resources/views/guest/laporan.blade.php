@extends('layouts.guest')

@section('title', 'Laporan Hasil Panen - Dinas Pertanian Kabupaten Toba')

@section('content')
<!-- Premium Hero Section -->
<section class="laporan-hero-premium">
    <div class="hero-particles">
        <div class="particle particle-1">🌾</div>
        <div class="particle particle-2">🌿</div>
        <div class="particle particle-3">🍃</div>
        <div class="particle particle-4">🌱</div>
        <div class="particle particle-5">🍂</div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-badge-premium animate-fade-in">
                    <span class="badge-dot"></span>
                    <span>Data Hasil Panen</span>
                </div>
                <h1 class="hero-title-premium animate-slide-up">
                    Laporan Hasil<br>
                    <span class="text-gradient">Panen</span>
                </h1>
                <p class="hero-subtitle-premium animate-slide-up-delay">
                    Pantau dan kelola laporan hasil panen secara transparan dan akurat untuk mendukung ketahanan pangan Kabupaten Toba.
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

<div class="container py-5">
    <!-- Premium Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="premium-stat-card">
                <div class="stat-card-bg gradient-emerald"></div>
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-inner">📊</div>
                    </div>
                    <div class="stat-details">
                        <span class="stat-label-premium">Total Laporan</span>
                        <h2 class="stat-value-premium">{{ $totalLaporan ?? 0 }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm green"></span>
                            Laporan terverifikasi
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
                        <div class="stat-icon-inner">🌾</div>
                    </div>
                    <div class="stat-details">
                        <span class="stat-label-premium">Total Produksi</span>
                        <h2 class="stat-value-premium">{{ number_format($totalProduksi ?? 0) }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm amber"></span>
                            Kilogram hasil panen
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
                        <span class="stat-label-premium">Jumlah Petani</span>
                        <h2 class="stat-value-premium">{{ $totalPetani ?? 0 }}</h2>
                        <span class="stat-badge">
                            <span class="badge-dot-sm blue"></span>
                            Petani aktif pelapor
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Data Card -->
    <div class="premium-data-card" data-aos="fade-up">
        <div class="data-card-header">
            <div class="header-left">
                <div class="header-icon-box">
                    <span>📋</span>
                </div>
                <div class="header-text">
                    <h4>Data Laporan Panen</h4>
                    <p>Daftar lengkap laporan hasil panen petani terverifikasi</p>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('download.laporan.pdf') }}" class="export-pdf-btn">
                    <span>📥</span>
                    <span>Export PDF</span>
                </a>
                <div class="data-count-badge">
                    <span class="count-icon">📊</span>
                    <span class="count-text">{{ $laporans->count() ?? 0 }} Data</span>
                </div>
            </div>
        </div>

        <div class="data-card-body">
            <!-- Premium Filter -->
            <div class="premium-filter">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="filter-label">🔍 Cari Laporan</label>
                        <div class="filter-input-group">
                            <span class="filter-icon">🔍</span>
                            <input type="text" id="searchLaporan" class="filter-input" placeholder="Nama petani atau jenis tanaman...">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="filter-label">🌿 Filter Jenis Tanaman</label>
                        <select id="komoditasFilter" class="filter-select">
                            <option value="">Semua Jenis Tanaman</option>
                            @php
                                $tanamanList = $laporans->pluck('jenis_tanaman')->unique()->filter();
                            @endphp
                            @foreach($tanamanList as $tanaman)
                                <option value="{{ strtolower($tanaman) }}">🌱 {{ $tanaman }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-2">
                        <button type="button" onclick="resetFilter()" class="filter-reset-btn">
                            🔄 Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Premium Table -->
            <div class="premium-table-wrapper">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="22%">PETANI</th>
                            <th width="18%">JENIS TANAMAN</th>
                            <th width="15%">HASIL PANEN</th>
                            <th width="15%">TANGGAL</th>
                            <th width="12%">STATUS</th>
                            <th width="13%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="laporanTableBody">
                        @forelse($laporans as $laporan)
                        <tr class="laporan-row" 
                            data-nama="{{ strtolower($laporan->user->name ?? '') }}"
                            data-komoditas="{{ strtolower($laporan->jenis_tanaman ?? '') }}">
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($laporan->user->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name">{{ $laporan->user->name ?? 'Petani' }}</span>
                                        <span class="user-location">📍 {{ $laporan->user->alamat_desa ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="item-info">
                                    <div class="item-icon">🌾</div>
                                    <span class="item-name">{{ $laporan->jenis_tanaman ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="quantity-display">
                                    <span class="quantity-value">{{ number_format($laporan->hasil_panen ?? 0, 2) }}</span>
                                    <span class="quantity-unit">Kilogram</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-display">
                                    <span class="date-icon">📅</span>
                                    <span class="date-text">{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : $laporan->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-success">
                                    <span class="status-dot"></span>
                                    Terverifikasi
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('guest.laporan.show', $laporan->id) }}" class="action-btn">
                                    <span>👁️</span>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <h5>Belum ada laporan panen terverifikasi</h5>
                                    <p>Data laporan yang sudah diverifikasi petugas akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- No Results -->
            <div id="noResults" class="no-results d-none">
                <div class="no-results-icon">🔍</div>
                <p>Tidak ada hasil yang cocok dengan filter Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ========================================
       HERO SECTION PREMIUM
    ======================================== */
    .laporan-hero-premium {
        background: linear-gradient(135deg, #065f46 0%, #047857 50%, #10b981 100%);
        padding: 100px 0 140px;
        position: relative;
        overflow: hidden;
    }

    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        font-size: 2rem;
        opacity: 0.15;
        animation: float-particle 20s infinite ease-in-out;
    }

    .particle-1 { top: 15%; left: 10%; animation-delay: 0s; }
    .particle-2 { top: 25%; right: 15%; animation-delay: 4s; }
    .particle-3 { bottom: 35%; left: 20%; animation-delay: 8s; }
    .particle-4 { top: 40%; right: 25%; animation-delay: 12s; }
    .particle-5 { bottom: 25%; right: 10%; animation-delay: 16s; }

    @keyframes float-particle {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
        25% { transform: translateY(-30px) rotate(10deg); opacity: 0.25; }
        50% { transform: translateY(-15px) rotate(-5deg); opacity: 0.2; }
        75% { transform: translateY(-40px) rotate(5deg); opacity: 0.15; }
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
        margin-bottom: 24px;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: #fbbf24;
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
    }

    .hero-title-premium {
        font-size: 3.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .text-gradient {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle-premium {
        font-size: 1.15rem;
        color: rgba(255,255,255,0.9);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.8;
    }

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        line-height: 0;
    }

    .hero-wave svg {
        width: 100%;
        height: 80px;
    }

    /* Animations */
    .animate-fade-in { animation: fadeIn 0.8s ease forwards; }
    .animate-slide-up { animation: slideUp 0.8s ease forwards; }
    .animate-slide-up-delay { animation: slideUp 0.8s ease 0.2s forwards; opacity: 0; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    /* ========================================
       PREMIUM STAT CARDS
    ======================================== */
    .premium-stat-card {
        background: white;
        border-radius: 20px;
        padding: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    }

    .stat-card-bg {
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.4s ease;
    }

    .premium-stat-card:hover .stat-card-bg {
        transform: scale(1.2);
        opacity: 0.15;
    }

    .gradient-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .gradient-amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

    .stat-card-content {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .stat-icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .stat-icon-wrapper.amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    }

    .stat-icon-wrapper.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    .stat-icon-inner {
        font-size: 2rem;
    }

    .stat-details {
        flex: 1;
    }

    .stat-label-premium {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        display: block;
        margin-bottom: 4px;
    }

    .stat-value-premium {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin: 0;
        line-height: 1.2;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 4px;
    }

    .badge-dot-sm {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-dot-sm.green { background: #10b981; }
    .badge-dot-sm.amber { background: #f59e0b; }
    .badge-dot-sm.blue { background: #3b82f6; }

    /* ========================================
       PREMIUM DATA CARD
    ======================================== */
    .premium-data-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .data-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 28px 32px;
        border-bottom: 1px solid #f3f4f6;
        background: linear-gradient(180deg, #fafffe 0%, #ffffff 100%);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon-box {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .header-text h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 4px;
    }

    .header-text p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .export-pdf-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }

    .export-pdf-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        color: white;
    }

    .data-count-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f3f4f6;
        padding: 10px 18px;
        border-radius: 50px;
        font-weight: 600;
        color: #374151;
    }

    .count-icon { font-size: 1rem; }

    .data-card-body {
        padding: 32px;
    }

    /* ========================================
       PREMIUM FILTER
    ======================================== */
    .premium-filter {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        padding: 24px;
        border-radius: 16px;
        margin-bottom: 28px;
        border: 1px solid #fde68a;
    }

    .filter-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input-group {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0 16px;
        transition: all 0.3s ease;
    }

    .filter-input-group:focus-within {
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .filter-icon {
        font-size: 1rem;
        margin-right: 10px;
    }

    .filter-input {
        flex: 1;
        border: none;
        padding: 14px 0;
        font-size: 0.95rem;
        background: transparent;
        outline: none;
    }

    .filter-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        outline: none;
    }

    .filter-reset-btn {
        width: 100%;
        padding: 14px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-reset-btn:hover {
        background: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }

    /* ========================================
       PREMIUM TABLE
    ======================================== */
    .premium-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
    }

    .premium-table {
        width: 100%;
        border-collapse: collapse;
    }

    .premium-table thead tr {
        background: linear-gradient(135deg, #047857 0%, #10b981 100%);
    }

    .premium-table thead th {
        padding: 18px 16px;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        white-space: nowrap;
    }

    .premium-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background: #fefce8;
    }

    .premium-table tbody td {
        padding: 18px 16px;
        vertical-align: middle;
    }

    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #fef3c7;
        border-radius: 8px;
        font-weight: 700;
        color: #b45309;
        font-size: 0.85rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 700;
        color: #1f2937;
    }

    .user-location {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .item-icon {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .item-name {
        font-weight: 600;
        color: #374151;
    }

    .quantity-display {
        display: flex;
        flex-direction: column;
    }

    .quantity-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: #047857;
    }

    .quantity-unit {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .date-display {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
    }

    .date-icon { font-size: 1rem; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .status-badge.status-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #059669;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: linear-gradient(135deg, #047857 0%, #10b981 100%);
        color: white;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(4, 120, 87, 0.35);
        color: white;
    }

    /* Empty & No Results */
    .empty-state, .no-results {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon, .no-results-icon {
        font-size: 4rem;
        margin-bottom: 16px;
    }

    .empty-state h5, .no-results p {
        color: #6b7280;
        margin: 0;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.9rem;
        margin-top: 8px;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 768px) {
        .laporan-hero-premium {
            padding: 80px 0 120px;
        }

        .hero-title-premium {
            font-size: 2.25rem;
        }

        .premium-stat-card {
            padding: 20px;
        }

        .stat-value-premium {
            font-size: 2rem;
        }

        .data-card-header {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }

        .header-left {
            flex-direction: column;
            text-align: center;
        }

        .data-card-body {
            padding: 20px;
        }

        .premium-filter {
            padding: 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function filterLaporan() {
    const search = document.getElementById('searchLaporan').value.toLowerCase();
    const komoditas = document.getElementById('komoditasFilter').value.toLowerCase();
    const rows = document.querySelectorAll('.laporan-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const rowNama = row.dataset.nama || '';
        const rowKomoditas = row.dataset.komoditas || '';
        const matchSearch = rowNama.includes(search) || rowKomoditas.includes(search);
        const matchKomoditas = !komoditas || rowKomoditas === komoditas;

        if (matchSearch && matchKomoditas) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const noResults = document.getElementById('noResults');
    if (visibleCount === 0 && rows.length > 0) {
        noResults.classList.remove('d-none');
    } else {
        noResults.classList.add('d-none');
    }
}

function resetFilter() {
    document.getElementById('searchLaporan').value = '';
    document.getElementById('komoditasFilter').value = '';
    filterLaporan();
}

document.getElementById('searchLaporan').addEventListener('input', filterLaporan);
document.getElementById('komoditasFilter').addEventListener('change', filterLaporan);
</script>
@endpush
