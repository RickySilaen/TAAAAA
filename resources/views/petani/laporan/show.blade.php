@extends('layouts.app')

@section('title', 'Detail Laporan Panen')

@section('content')
<style>
    .dtl-container { padding: 24px; }
    
    .dtl-header-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
    }
    
    .dtl-header-card h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .dtl-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .dtl-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px; font-size: 28px;
    }
    
    .dtl-back-btn {
        background: rgba(255,255,255,0.2); color: #fff;
        padding: 10px 20px; border-radius: 10px; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s; margin-right: 10px;
    }
    .dtl-back-btn:hover { background: #fff; color: #059669; }
    
    .dtl-edit-btn {
        background: #fef3c7; color: #d97706;
        padding: 10px 20px; border-radius: 10px; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s;
    }
    .dtl-edit-btn:hover { background: #fde68a; color: #b45309; }
    
    .dtl-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
    }
    
    .dtl-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
    }
    .dtl-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; }
    .dtl-card-header .icon { font-size: 20px; }
    
    .dtl-card-body { padding: 24px; }
    
    .dtl-highlight-box {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 2px solid #10b981; border-radius: 16px;
        padding: 24px; text-align: center; margin-bottom: 24px;
    }
    .dtl-highlight-box label { font-size: 14px; color: #059669; font-weight: 500; margin-bottom: 8px; display: block; }
    .dtl-highlight-box .value { font-size: 36px; font-weight: 700; color: #065f46; }
    .dtl-highlight-box .unit { font-size: 18px; color: #10b981; }
    
    .dtl-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    @media (max-width: 768px) { .dtl-info-grid { grid-template-columns: 1fr; } }
    
    .dtl-info-item { padding: 16px; background: #f8fafc; border-radius: 12px; }
    .dtl-info-item label { display: block; font-size: 12px; color: #64748b; margin-bottom: 6px; text-transform: uppercase; font-weight: 500; }
    .dtl-info-item p { margin: 0; font-size: 16px; color: #1e293b; font-weight: 600; }
    
    .dtl-desc-box {
        background: #f8fafc; border-radius: 12px; padding: 20px; margin-top: 20px;
    }
    .dtl-desc-box label { display: block; font-size: 12px; color: #64748b; margin-bottom: 8px; text-transform: uppercase; font-weight: 500; }
    .dtl-desc-box p { margin: 0; color: #374151; line-height: 1.6; }
    
    .dtl-status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px; border-radius: 50px; font-size: 14px; font-weight: 600;
    }
    .dtl-status-badge.pending { background: #fef3c7; color: #d97706; }
    .dtl-status-badge.approved { background: #dcfce7; color: #16a34a; }
    .dtl-status-badge.rejected { background: #fee2e2; color: #dc2626; }
    
    .dtl-alert {
        padding: 20px; border-radius: 16px; margin-top: 20px;
        display: flex; align-items: flex-start; gap: 16px;
    }
    .dtl-alert.danger { background: #fee2e2; border: 1px solid #ef4444; }
    .dtl-alert .icon { font-size: 24px; flex-shrink: 0; }
    .dtl-alert .content h5 { margin: 0 0 8px; font-weight: 600; color: #1e293b; }
    .dtl-alert .content p { margin: 0; color: #64748b; }
    
    .dtl-photo-card {
        background: #fff; border-radius: 16px; overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .dtl-photo-card .header {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 16px 20px; color: #fff; font-weight: 600;
        display: flex; align-items: center; gap: 10px;
    }
    .dtl-photo-card .body { padding: 16px; text-align: center; }
    .dtl-photo-card img { max-width: 100%; border-radius: 12px; }
</style>

<div class="dtl-container">
    <div class="dtl-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="dtl-header-icon">🌾</div>
                <div>
                    <h1>Detail Laporan Panen</h1>
                    <p>Informasi lengkap hasil panen Anda</p>
                </div>
            </div>
            <div>
                @if($laporan->status == 'pending')
                <a href="{{ route('petani.laporan.edit', $laporan->id) }}" class="dtl-edit-btn">
                    ✏️ Edit
                </a>
                @endif
                <a href="{{ route('petani.laporan.index') }}" class="dtl-back-btn">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="dtl-card">
                <div class="dtl-card-header">
                    <span class="icon">📋</span>
                    <h5>Informasi Laporan</h5>
                </div>
                <div class="dtl-card-body">
                    <div class="dtl-highlight-box">
                        <label>🌾 Hasil Panen</label>
                        <span class="value">{{ number_format($laporan->hasil_panen, 2) }}</span>
                        <span class="unit">kg</span>
                    </div>

                    <div class="dtl-info-grid">
                        <div class="dtl-info-item">
                            <label>🌱 Jenis Tanaman</label>
                            <p>{{ $laporan->jenis_tanaman }}</p>
                        </div>
                        <div class="dtl-info-item">
                            <label>📐 Luas Panen</label>
                            <p>{{ $laporan->luas_panen ? number_format($laporan->luas_panen, 2) . ' ha' : '-' }}</p>
                        </div>
                        <div class="dtl-info-item">
                            <label>📅 Tanggal Panen</label>
                            <p>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="dtl-info-item">
                            <label>📊 Status</label>
                            <p>
                                @if($laporan->status == 'pending')
                                    <span class="dtl-status-badge pending">⏳ Menunggu Verifikasi</span>
                                @elseif($laporan->status == 'verified')
                                    <span class="dtl-status-badge approved">✅ Terverifikasi</span>
                                @elseif($laporan->status == 'rejected')
                                    <span class="dtl-status-badge rejected">❌ Ditolak</span>
                                @else
                                    <span class="dtl-status-badge">{{ $laporan->status }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="dtl-info-item">
                            <label>🕐 Dibuat Pada</label>
                            <p>{{ $laporan->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    @if($laporan->deskripsi_kemajuan)
                    <div class="dtl-desc-box">
                        <label>📝 Deskripsi Kemajuan</label>
                        <p>{{ $laporan->deskripsi_kemajuan }}</p>
                    </div>
                    @endif

                    @if($laporan->catatan)
                    <div class="dtl-desc-box">
                        <label>📋 Catatan</label>
                        <p>{{ $laporan->catatan }}</p>
                    </div>
                    @endif

                    @if($laporan->status == 'rejected' && $laporan->rejection_reason)
                    <div class="dtl-alert danger">
                        <span class="icon">⚠️</span>
                        <div class="content">
                            <h5>Alasan Penolakan</h5>
                            <p>{{ $laporan->rejection_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($laporan->foto)
            <div class="dtl-photo-card">
                <div class="header">
                    📷 Foto Hasil Panen
                </div>
                <div class="body">
                    <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" alt="Foto Panen">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
