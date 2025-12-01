@extends('layouts.app')

@section('title', 'Detail Laporan - Petugas')

@section('content')
<style>
    .lpr-container { padding: 24px; }
    
    .lpr-header-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
    }
    
    .lpr-header-card h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .lpr-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .lpr-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px;
    }
    .lpr-header-icon i { font-size: 24px !important; color: #fff !important; }
    
    .lpr-back-btn {
        background: rgba(255,255,255,0.2); color: #fff;
        padding: 10px 20px; border-radius: 10px; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s;
    }
    .lpr-back-btn:hover { background: #fff; color: #059669; }
    
    .lpr-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
    }
    
    .lpr-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
    }
    .lpr-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; }
    .lpr-card-header i { font-size: 18px !important; color: #10b981 !important; }
    
    .lpr-card-body { padding: 24px; }
    
    .lpr-profile {
        display: flex; align-items: center; gap: 16px;
        padding: 20px; background: #f8fafc; border-radius: 16px; margin-bottom: 24px;
        flex-wrap: wrap;
    }
    
    .lpr-profile-avatar {
        width: 72px; height: 72px; border-radius: 16px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 24px; font-weight: 700; flex-shrink: 0;
    }
    .lpr-profile-avatar img { width: 100%; height: 100%; border-radius: 16px; object-fit: cover; }
    
    .lpr-profile-info h4 { margin: 0 0 4px 0; font-weight: 600; color: #1e293b; }
    .lpr-profile-info p { margin: 0; color: #64748b; font-size: 14px; }
    
    .lpr-status-badge {
        padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .lpr-status-badge.success { background: #dcfce7; color: #16a34a; }
    .lpr-status-badge.warning { background: #fef3c7; color: #d97706; }
    .lpr-status-badge.danger { background: #fee2e2; color: #dc2626; }
    
    .lpr-info-grid {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) { .lpr-info-grid { grid-template-columns: 1fr; } }
    
    .lpr-info-item label { display: block; font-size: 13px; color: #64748b; margin-bottom: 6px; font-weight: 500; }
    .lpr-info-item p { margin: 0; font-size: 15px; color: #1e293b; font-weight: 500; }
    
    .lpr-highlight-box {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 2px solid #10b981; border-radius: 16px;
        padding: 20px; text-align: center; margin-bottom: 20px;
    }
    .lpr-highlight-box label { font-size: 14px; color: #059669; font-weight: 500; margin-bottom: 8px; display: block; }
    .lpr-highlight-box .value { font-size: 32px; font-weight: 700; color: #065f46; }
    .lpr-highlight-box .unit { font-size: 16px; color: #10b981; }
    
    .lpr-desc-box {
        background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 16px;
    }
    .lpr-desc-box label { display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 500; }
    .lpr-desc-box p { margin: 0; color: #1e293b; line-height: 1.6; }
    
    .lpr-form-group { margin-bottom: 20px; }
    .lpr-form-group label { display: block; font-weight: 600; color: #374151; margin-bottom: 8px; }
    
    .lpr-form-select, .lpr-form-textarea {
        width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 14px; color: #1e293b; background: #fff; transition: all 0.3s;
    }
    .lpr-form-select:focus, .lpr-form-textarea:focus {
        outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .lpr-submit-btn {
        width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #10b981, #059669);
        color: #fff; border: none; border-radius: 12px; font-size: 15px; font-weight: 600;
        cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    }
    .lpr-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
    
    .lpr-verified-box {
        text-align: center; padding: 30px 20px;
    }
    .lpr-verified-box .icon { font-size: 64px; margin-bottom: 16px; }
    .lpr-verified-box h4 { margin: 0 0 8px 0; font-weight: 600; color: #1e293b; }
    .lpr-verified-box p { margin: 0; color: #64748b; font-size: 14px; }
</style>

<div class="lpr-container">
    <div class="lpr-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="lpr-header-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h1>Detail Laporan</h1>
                    <p>Verifikasi laporan pertanian petani</p>
                </div>
            </div>
            <a href="{{ route('petugas.laporan.index') }}" class="lpr-back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="lpr-card">
                <div class="lpr-card-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informasi Laporan</h5>
                </div>
                <div class="lpr-card-body">
                    <div class="lpr-profile">
                        <div class="lpr-profile-avatar">
                            @if($laporan->user->profile_picture)
                                <img src="{{ asset('storage/' . $laporan->user->profile_picture) }}" alt="avatar">
                            @else
                                {{ strtoupper(substr($laporan->user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="lpr-profile-info">
                            <h4>{{ $laporan->user->name }}</h4>
                            <p>📍 {{ $laporan->user->alamat_desa ?? 'Alamat belum diisi' }}</p>
                            <p>🌾 Luas Lahan: {{ $laporan->user->luas_lahan ?? 0 }} hektar</p>
                        </div>
                        <div class="ms-auto">
                            @if($laporan->status == 'verified')
                                <span class="lpr-status-badge success">✅ Terverifikasi</span>
                            @elseif($laporan->status == 'rejected')
                                <span class="lpr-status-badge danger">❌ Ditolak</span>
                            @else
                                <span class="lpr-status-badge warning">⏳ Menunggu Verifikasi</span>
                            @endif
                        </div>
                    </div>

                    <div class="lpr-highlight-box">
                        <label>🌾 Hasil Panen</label>
                        <span class="value">{{ number_format($laporan->hasil_panen) }}</span>
                        <span class="unit">kg</span>
                    </div>

                    <div class="lpr-info-grid">
                        <div class="lpr-info-item">
                            <label>📅 Tanggal Laporan</label>
                            <p>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') : '-' }}</p>
                        </div>
                        @if($laporan->jenis_tanaman)
                        <div class="lpr-info-item">
                            <label>🌱 Jenis Tanaman</label>
                            <p>{{ $laporan->jenis_tanaman }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="lpr-desc-box">
                        <label>📝 Deskripsi Kemajuan</label>
                        <p>{{ $laporan->deskripsi_kemajuan ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    @if($laporan->catatan)
                    <div class="lpr-desc-box">
                        <label>📋 Catatan</label>
                        <p>{{ $laporan->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="lpr-card">
                <div class="lpr-card-header">
                    <i class="fas fa-clipboard-check"></i>
                    <h5>Verifikasi Laporan</h5>
                </div>
                <div class="lpr-card-body">
                    @if($laporan->status == 'pending')
                    <form action="{{ route('petugas.laporan.verify', $laporan->id) }}" method="POST">
                        @csrf
                        <div class="lpr-form-group">
                            <label>Catatan Verifikasi</label>
                            <textarea name="catatan" class="lpr-form-textarea" rows="4" placeholder="Tambahkan catatan verifikasi..."></textarea>
                        </div>

                        <button type="submit" class="lpr-submit-btn">
                            <i class="fas fa-check-circle"></i> Setujui Laporan
                        </button>
                    </form>
                    
                    <form action="{{ route('petugas.laporan.reject', $laporan->id) }}" method="POST" style="margin-top: 12px;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="alasan" value="">
                        <button type="submit" class="lpr-submit-btn" style="background: linear-gradient(135deg, #ef4444, #dc2626);" onclick="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                            <i class="fas fa-times-circle"></i> Tolak Laporan
                        </button>
                    </form>
                    @else
                    <div class="lpr-verified-box">
                        @if($laporan->status == 'verified')
                            <div class="icon">✅</div>
                            <h4>Laporan Terverifikasi</h4>
                        @else
                            <div class="icon">❌</div>
                            <h4>Laporan Ditolak</h4>
                        @endif
                        <p>Status: <strong>{{ ucfirst($laporan->status) }}</strong></p>
                        @if($laporan->catatan)
                        <p style="margin-top: 12px; font-size: 13px;">📝 {{ $laporan->catatan }}</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
