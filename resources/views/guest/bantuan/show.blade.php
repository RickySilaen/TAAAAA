@extends('layouts.guest')

@section('title', 'Detail Bantuan - Sistem Pertanian')

@push('styles')
<style>
    .bantuan-detail-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #43a047 100%);
        padding: 60px 0;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    
    .bantuan-detail-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,193,7,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .bantuan-detail-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .detail-main-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        margin-top: -80px;
        position: relative;
        z-index: 10;
        overflow: hidden;
    }
    
    .jenis-bantuan-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: #fff;
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 1.3rem;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(46,125,50,0.3);
    }
    
    .jenis-bantuan-badge svg {
        width: 28px;
        height: 28px;
    }
    
    .stat-card {
        background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .stat-card .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #2e7d32;
    }
    
    .stat-card .stat-value.status-badge {
        font-size: 1rem;
    }
    
    .status-badge-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
    }
    
    .status-badge-wrapper.dikirim {
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: #fff;
    }
    
    .status-badge-wrapper.pending {
        background: linear-gradient(135deg, #f57c00 0%, #ff9800 100%);
        color: #fff;
    }
    
    .info-section {
        padding: 30px 0;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border-radius: 16px;
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .info-item.penerima {
        border-color: #2e7d32;
        background: linear-gradient(135deg, rgba(46,125,50,0.05) 0%, rgba(255,255,255,1) 100%);
    }
    
    .info-item.tanggal {
        border-color: #1976d2;
        background: linear-gradient(135deg, rgba(25,118,210,0.05) 0%, rgba(255,255,255,1) 100%);
    }
    
    .info-item.catatan {
        border-color: #f57c00;
        background: linear-gradient(135deg, rgba(245,124,0,0.05) 0%, rgba(255,255,255,1) 100%);
    }
    
    .info-item .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-item.penerima .icon-wrapper {
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
    }
    
    .info-item.tanggal .icon-wrapper {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
    }
    
    .info-item.catatan .icon-wrapper {
        background: linear-gradient(135deg, #f57c00 0%, #ff9800 100%);
    }
    
    .info-item .icon-wrapper svg {
        width: 24px;
        height: 24px;
        fill: #fff;
        color: #fff;
    }
    
    .info-item .icon-wrapper .icon-emoji,
    .meta-item .meta-icon .icon-emoji {
        font-size: 24px;
        line-height: 1;
    }
    
    .info-item .info-content h6 {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    
    .info-item .info-content p {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }
    
    .meta-section {
        background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 20px;
        padding: 30px;
        margin-top: 30px;
    }
    
    .meta-item {
        text-align: center;
        padding: 15px;
    }
    
    .meta-item .meta-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .meta-item .meta-icon.created {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
    }
    
    .meta-item .meta-icon.updated {
        background: linear-gradient(135deg, #00897b 0%, #26a69a 100%);
    }
    
    .meta-item .meta-icon.id-badge {
        background: linear-gradient(135deg, #7b1fa2 0%, #ab47bc 100%);
    }
    
    .meta-item .meta-icon svg {
        width: 24px;
        height: 24px;
        fill: #fff;
        color: #fff;
    }
    
    .meta-item h6 {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }
    
    .meta-item small {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .info-additional-card {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        border: none;
        margin-top: 30px;
    }
    
    .info-additional-card h5 {
        color: #2e7d32;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .info-additional-card p {
        color: #4a5568;
        margin-bottom: 25px;
        line-height: 1.7;
    }
    
    .btn-contact {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: #fff;
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(46,125,50,0.3);
    }
    
    .btn-contact:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(46,125,50,0.4);
        color: #fff;
    }
    
    .btn-contact svg {
        width: 20px;
        height: 20px;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #2e7d32;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid #2e7d32;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #2e7d32;
        color: #fff;
    }
    
    .btn-back svg {
        width: 18px;
        height: 18px;
        transition: transform 0.3s ease;
    }
    
    .btn-back:hover svg {
        transform: translateX(-5px);
    }
    
    @media (max-width: 768px) {
        .bantuan-detail-hero {
            padding: 40px 0;
        }
        
        .detail-main-card {
            margin-top: -40px;
            border-radius: 16px;
        }
        
        .jenis-bantuan-badge {
            font-size: 1rem;
            padding: 10px 20px;
        }
        
        .stat-card .stat-value {
            font-size: 1.5rem;
        }
        
        .info-item {
            flex-direction: column;
            text-align: center;
        }
        
        .info-item .icon-wrapper {
            margin: 0 auto;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bantuan-detail-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center position-relative" style="z-index: 5;">
                <h1 class="display-5 fw-bold mb-3">Detail Program Bantuan</h1>
                <p class="lead opacity-90 mb-4">Informasi lengkap tentang program bantuan pertanian.</p>
                <a href="{{ route('bantuan.publik') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali ke Daftar Bantuan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Detail Card -->
            <div class="detail-main-card">
                <div class="card-body p-4 p-lg-5">
                    <!-- Jenis Bantuan Badge -->
                    <div class="text-center mb-4">
                        <div class="jenis-bantuan-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                            </svg>
                            {{ $bantuan->jenis_bantuan }}
                        </div>
                    </div>
                    
                    <!-- Stats Row -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="stat-card">
                                <div class="stat-label">Jumlah Bantuan</div>
                                <div class="stat-value">{{ number_format($bantuan->jumlah) }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-card">
                                <div class="stat-label">Status Distribusi</div>
                                <div class="stat-value status-badge">
                                    <span class="status-badge-wrapper {{ $bantuan->status === 'Dikirim' ? 'dikirim' : 'pending' }}">
                                        @if($bantuan->status === 'Dikirim')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                            </svg>
                                        @endif
                                        {{ $bantuan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Section -->
                    <div class="info-section">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item penerima">
                                    <div class="icon-wrapper">
                                        <span class="icon-emoji">👤</span>
                                    </div>
                                    <div class="info-content">
                                        <h6>Penerima Bantuan</h6>
                                        <p>{{ $bantuan->user->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item tanggal">
                                    <div class="icon-wrapper">
                                        <span class="icon-emoji">📅</span>
                                    </div>
                                    <div class="info-content">
                                        <h6>Tanggal Distribusi</h6>
                                        <p>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($bantuan->catatan)
                            <div class="col-12">
                                <div class="info-item catatan">
                                    <div class="icon-wrapper">
                                        <span class="icon-emoji">📝</span>
                                    </div>
                                    <div class="info-content">
                                        <h6>Catatan</h6>
                                        <p>{{ $bantuan->catatan }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Meta Section -->
                    <div class="meta-section">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="meta-item">
                                    <div class="meta-icon created">
                                        <span class="icon-emoji">📆</span>
                                    </div>
                                    <h6>Dibuat</h6>
                                    <small>{{ $bantuan->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="meta-item">
                                    <div class="meta-icon updated">
                                        <span class="icon-emoji">🔄</span>
                                    </div>
                                    <h6>Terakhir Update</h6>
                                    <small>{{ $bantuan->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="meta-item">
                                    <div class="meta-icon id-badge">
                                        <span class="icon-emoji">🆔</span>
                                    </div>
                                    <h6>ID Bantuan</h6>
                                    <small>#{{ $bantuan->id }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Info Additional -->
            <div class="info-additional-card">
                <h5>
                    ℹ️ Informasi Tambahan
                </h5>
                <p>
                    Program bantuan ini merupakan bagian dari komitmen pemerintah untuk mendukung kesejahteraan petani.
                    Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kontak yang tersedia.
                </p>
                <a href="{{ route('kontak') }}" class="btn-contact">\n                    ✉️ Hubungi Kami\n                </a>
            </div>
        </div>
    </div>
</div>
@endsection
