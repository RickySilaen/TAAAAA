@extends('layouts.app')

@section('title', 'Detail Laporan Bantuan')

@push('styles')
<style>
    .detail-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(46,125,50,0.3);
    }
    
    .detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }
    
    .detail-card-header {
        background: linear-gradient(135deg, #f8fdf9, #e8f5e9);
        padding: 1.5rem;
        border-bottom: 2px solid #c8e6c9;
    }
    
    .detail-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1b5e20;
        margin: 0;
    }
    
    .info-table {
        margin: 0;
    }
    
    .info-table tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-table tr:last-child {
        border-bottom: none;
    }
    
    .info-table th {
        font-weight: 600;
        color: #555;
        padding: 1rem;
        vertical-align: top;
        width: 200px;
    }
    
    .info-table td {
        padding: 1rem;
        color: #333;
    }
    
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .photo-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .photo-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    
    .photo-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }
    
    .photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .photo-item:hover .photo-overlay {
        opacity: 1;
    }
    
    .photo-overlay i {
        color: white;
        font-size: 2rem;
    }
    
    .action-card {
        position: sticky;
        top: 20px;
    }
    
    .action-btn {
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Hero Header -->
    <div class="detail-hero">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2" style="color: white;">Detail Laporan Bantuan</h1>
                <p class="mb-0" style="opacity: 0.9;">{{ $laporan->judul }}</p>
            </div>
            <a href="{{ route('admin.laporan-bantuan.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Informasi Laporan -->
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <h6 class="detail-card-title">
                        <i class="fas fa-info-circle me-2"></i>Informasi Laporan
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="info-table table table-borderless mb-0">
                        <tr>
                            <th>Status</th>
                            <td>{!! $laporan->status_badge !!}</td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <td><strong>{{ $laporan->judul }}</strong></td>
                        </tr>
                        <tr>
                            <th>Jenis Bantuan</th>
                            <td><span class="badge bg-primary rounded-pill px-3 py-2">{{ $laporan->jenis_bantuan }}</span></td>
                        </tr>
                        @if($laporan->jumlah_bantuan)
                        <tr>
                            <th>Jumlah Bantuan</th>
                            <td><strong class="text-success">{{ number_format($laporan->jumlah_bantuan, 0, ',', '.') }}</strong> {{ $laporan->satuan }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $laporan->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 700;">
                                        {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $laporan->user->name }}</strong><br>
                                        <small class="text-muted">{{ $laporan->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $laporan->alamat_desa ?? 'N/A' }}, Kec. {{ $laporan->alamat_kecamatan ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Penerimaan</th>
                            <td>
                                <i class="fas fa-calendar-check text-success me-2"></i>
                                {{ $laporan->tanggal_penerimaan ? $laporan->tanggal_penerimaan->format('d F Y') : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaporan</th>
                            <td>
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ $laporan->tanggal_pelaporan->format('d F Y H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Dilihat</th>
                            <td>
                                <i class="fas fa-eye text-info me-2"></i>
                                <strong>{{ $laporan->views_count }}</strong> kali
                            </td>
                        </tr>
                        @if($laporan->verifier)
                        <tr>
                            <th>Diverifikasi oleh</th>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 700;">
                                        {{ strtoupper(substr($laporan->verifier->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $laporan->verifier->name }}</strong><br>
                                        <small class="text-muted">{{ $laporan->verified_at->format('d F Y H:i') }}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if($laporan->catatan_verifikasi)
                        <tr>
                            <th>Catatan Verifikasi</th>
                            <td>
                                <div class="alert alert-info mb-0" style="border-radius: 12px;">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    {{ $laporan->catatan_verifikasi }}
                                </div>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Foto Bukti -->
            @if(!empty($laporan->foto_bukti_urls))
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <h6 class="detail-card-title">
                        <i class="fas fa-images me-2"></i>Foto Bukti ({{ count($laporan->foto_bukti_urls) }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="photo-grid">
                        @foreach($laporan->foto_bukti_urls as $index => $photo)
                        <div class="photo-item" onclick="window.open('{{ $photo }}', '_blank')">
                            <img src="{{ $photo }}" alt="Foto {{ $index + 1 }}">
                            <div class="photo-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="detail-card action-card mb-4">
                <div class="detail-card-header">
                    <h6 class="detail-card-title">
                        <i class="fas fa-bolt me-2"></i>Aksi
                    </h6>
                </div>
                <div class="card-body">
                    @if($laporan->status === 'pending')
                        <form action="{{ route('admin.laporan-bantuan.verify', $laporan->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="catatan_verifikasi" class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea class="form-control" 
                                          id="catatan_verifikasi" 
                                          name="catatan_verifikasi" 
                                          rows="3"
                                          style="border-radius: 12px;"
                                          placeholder="Tambahkan catatan verifikasi..."></textarea>
                            </div>
                            <button type="submit" class="action-btn btn btn-success w-100 mb-2">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi Laporan
                            </button>
                        </form>

                        <form action="{{ route('admin.laporan-bantuan.reject', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="catatan_reject" class="form-label fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea class="form-control" 
                                          id="catatan_reject" 
                                          name="catatan_verifikasi" 
                                          rows="3"
                                          style="border-radius: 12px;"
                                          placeholder="Jelaskan alasan penolakan..."
                                          required></textarea>
                            </div>
                            <button type="submit" class="action-btn btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Tolak Laporan
                            </button>
                        </form>
                    @endif

                    @if($laporan->status === 'verified')
                        <form action="{{ route('admin.laporan-bantuan.publish', $laporan->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="action-btn btn btn-primary w-100 mb-2">
                                <i class="fas fa-globe me-2"></i>Publikasikan ke Dashboard Publik
                            </button>
                        </form>
                    @endif

                    @if($laporan->is_public)
                        <form action="{{ route('admin.laporan-bantuan.unpublish', $laporan->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="action-btn btn btn-warning w-100 mb-2">
                                <i class="fas fa-eye-slash me-2"></i>Hapus dari Dashboard Publik
                            </button>
                        </form>

                        <a href="{{ route('transparansi.bantuan.show', $laporan->id) }}" 
                           target="_blank" 
                           class="action-btn btn btn-info w-100 text-white">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat di Dashboard Publik
                        </a>
                    @endif
                </div>
            </div>

            <!-- Info Tambahan -->
            @if($laporan->bantuan)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Terkait Pengajuan Bantuan</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>{{ $laporan->bantuan->jenis_bantuan }}</strong></p>
                    <small class="text-muted">
                        Diajukan: {{ $laporan->bantuan->created_at->format('d F Y') }}<br>
                        Status: {{ $laporan->bantuan->status }}
                    </small>
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-plus-circle text-primary"></i>
                            <div class="timeline-content">
                                <strong>Dibuat</strong><br>
                                <small>{{ $laporan->created_at->format('d F Y H:i') }}</small>
                            </div>
                        </div>
                        @if($laporan->verified_at)
                        <div class="timeline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <div class="timeline-content">
                                <strong>{{ $laporan->status === 'rejected' ? 'Ditolak' : 'Diverifikasi' }}</strong><br>
                                <small>{{ $laporan->verified_at->format('d F Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 10px;
    bottom: 10px;
    width: 2px;
    background: #e3e6f0;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item i {
    position: absolute;
    left: -24px;
    background: white;
    padding: 2px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endsection
