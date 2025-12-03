@extends('layouts.app')

@section('title', 'Laporan Bantuan Saya')

@push('styles')
<style>
    /* Performance Optimizations */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .page-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(27, 94, 32, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h60v60H0z" fill="none"/><path d="M30 0v60M0 30h60" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
        opacity: 0.3;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: rgba(255,255,255,0.95);
        font-size: 1.1rem;
        margin: 0;
    }

    .btn-create {
        background: white;
        color: #1b5e20;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-create:hover {
        background: #f1f8e9;
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.2);
        color: #1b5e20;
    }

    .btn-create i {
        font-size: 1.2rem;
    }

    /* Alert Messages */
    .alert-custom {
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border: none;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        animation: slideDown 0.4s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-custom i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: width 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .stat-card:hover::before {
        width: 8px;
    }

    .stat-card.primary::before {
        background: linear-gradient(180deg, #2196f3 0%, #1976d2 100%);
    }

    .stat-card.warning::before {
        background: linear-gradient(180deg, #ff9800 0%, #f57c00 100%);
    }

    .stat-card.success::before {
        background: linear-gradient(180deg, #4caf50 0%, #388e3c 100%);
    }

    .stat-card.info::before {
        background: linear-gradient(180deg, #00bcd4 0%, #0097a7 100%);
    }

    .stat-card-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-info h6 {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        opacity: 0.7;
    }

    .stat-info .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #2c3e50;
        line-height: 1;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        opacity: 0.15;
    }

    .stat-card.primary .stat-icon {
        background: #2196f3;
        color: #2196f3;
    }

    .stat-card.warning .stat-icon {
        background: #ff9800;
        color: #ff9800;
    }

    .stat-card.success .stat-icon {
        background: #4caf50;
        color: #4caf50;
    }

    .stat-card.info .stat-icon {
        background: #00bcd4;
        color: #00bcd4;
    }

    /* Main Card */
    .main-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .main-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.75rem 2rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .main-card-header h6 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .main-card-body {
        padding: 2rem;
    }

    /* Table Styles */
    .table-modern {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        border: none;
        white-space: nowrap;
    }

    .table-modern thead th:first-child {
        border-radius: 12px 0 0 0;
    }

    .table-modern thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-modern tbody tr:hover {
        background: #f8faf8;
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .table-modern tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.95rem;
    }

    .table-modern tbody td strong {
        color: #2c3e50;
        font-weight: 600;
    }

    /* Badge Styles */
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Action Buttons */
    .btn-action {
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        border: none;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-action i {
        font-size: 1rem;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
        color: white;
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, #ef5350 0%, #e53935 100%);
        color: white;
    }

    .btn-info-custom {
        background: white;
        color: #00bcd4;
        border: 2px solid #00bcd4;
    }

    .btn-info-custom:hover {
        background: #00bcd4;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .empty-state p {
        font-size: 1.1rem;
        color: #999;
        margin-bottom: 1.5rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(27, 94, 32, 0.4);
        color: white;
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px 16px 0 0;
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .modal-title {
        font-weight: 700;
        color: #2c3e50;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 2px solid #f0f0f0;
    }

    /* Pagination */
    .pagination {
        margin-top: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .main-card-body {
            padding: 1rem;
        }

        .table-responsive {
            border-radius: 12px;
        }
    }

    /* Icon Fix */
    i.fas, i.fa {
        font-style: normal;
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h1 class="page-title">Laporan Bantuan Saya</h1>
                        <p class="page-subtitle">Kelola laporan bantuan yang telah Anda terima</p>
                    </div>
                    <a href="{{ route('petani.laporan-bantuan.create') }}" class="btn-create">
                        <i class="fas fa-plus-circle"></i>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h6>Total Laporan</h6>
                        <div class="stat-value">{{ $reports->total() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h6>Menunggu Verifikasi</h6>
                        <div class="stat-value">{{ $reports->where('status', 'pending')->count() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h6>Terverifikasi</h6>
                        <div class="stat-value">{{ $reports->where('status', 'verified')->count() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h6>Dipublikasikan</h6>
                        <div class="stat-value">{{ $reports->where('status', 'published')->count() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="main-card">
            <div class="main-card-header">
                <h6>Daftar Laporan Bantuan</h6>
            </div>
            <div class="main-card-body">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul Laporan</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $laporan)
                                <tr>
                                    <td>
                                        <strong>{{ $laporan->tanggal_pelaporan->format('d/m/Y') }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $laporan->judul }}</strong>
                                        @if($laporan->is_public)
                                            <span class="badge-custom bg-info text-white ms-2">
                                                <i class="fas fa-eye"></i> Publik
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $laporan->jenis_bantuan }}</td>
                                    <td>
                                        @if($laporan->jumlah_bantuan)
                                            <strong>{{ number_format($laporan->jumlah_bantuan, 0, ',', '.') }}</strong> {{ $laporan->satuan }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{!! $laporan->status_badge !!}</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($laporan->status === 'pending' || $laporan->status === 'rejected')
                                                <a href="{{ route('petani.laporan-bantuan.edit', $laporan->id) }}" 
                                                   class="btn-action btn-warning-custom" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            
                                            @if($laporan->status === 'pending')
                                                <form action="{{ route('petani.laporan-bantuan.destroy', $laporan->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn-action btn-danger-custom" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($laporan->status === 'rejected' && $laporan->catatan_verifikasi)
                                                <button class="btn-action btn-info-custom" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#catatanModal{{ $laporan->id }}"
                                                        title="Lihat Alasan">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            @endif
                                        </div>

                                        @if($laporan->status === 'rejected' && $laporan->catatan_verifikasi)
                                            <!-- Modal Catatan -->
                                            <div class="modal fade" id="catatanModal{{ $laporan->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-info-circle me-2 text-warning"></i>
                                                                Catatan Verifikasi
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning mb-3">
                                                                <strong>Alasan Penolakan:</strong>
                                                            </div>
                                                            <p style="font-size: 1.05rem; line-height: 1.6;">{{ $laporan->catatan_verifikasi }}</p>
                                                            @if($laporan->verifier)
                                                                <div class="mt-3 pt-3 border-top">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-user me-1"></i> 
                                                                        Diverifikasi oleh: <strong>{{ $laporan->verifier->name }}</strong><br>
                                                                        <i class="fas fa-calendar me-1"></i> 
                                                                        Tanggal: <strong>{{ $laporan->verified_at->format('d/m/Y H:i') }}</strong>
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i> Tutup
                                                            </button>
                                                            <a href="{{ route('petani.laporan-bantuan.edit', $laporan->id) }}" 
                                                               class="btn-action btn-warning-custom">
                                                                <i class="fas fa-edit me-1"></i> Edit Laporan
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada laporan bantuan.</p>
                        <a href="{{ route('petani.laporan-bantuan.create') }}" class="btn-primary-custom">
                            <i class="fas fa-plus-circle"></i>
                            Buat Laporan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
