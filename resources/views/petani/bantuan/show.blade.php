@extends('layouts.app')

@section('title', 'Detail Permintaan Bantuan')

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
    
    .dtl-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    @media (max-width: 768px) { .dtl-info-grid { grid-template-columns: 1fr; } }
    
    .dtl-info-item { padding: 16px; background: #f8fafc; border-radius: 12px; }
    .dtl-info-item label { display: block; font-size: 12px; color: #64748b; margin-bottom: 6px; text-transform: uppercase; font-weight: 500; }
    .dtl-info-item p { margin: 0; font-size: 16px; color: #1e293b; font-weight: 600; }
    
    .dtl-status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px; border-radius: 50px; font-size: 14px; font-weight: 600;
    }
    .dtl-status-badge.pending { background: #fef3c7; color: #d97706; }
    .dtl-status-badge.approved { background: #dcfce7; color: #16a34a; }
    .dtl-status-badge.rejected { background: #fee2e2; color: #dc2626; }
    .dtl-status-badge.delivered { background: #dbeafe; color: #2563eb; }
    
    .dtl-alert {
        padding: 20px; border-radius: 16px; margin-top: 20px;
        display: flex; align-items: flex-start; gap: 16px;
    }
    .dtl-alert.success { background: #dcfce7; border: 1px solid #10b981; }
    .dtl-alert.danger { background: #fee2e2; border: 1px solid #ef4444; }
    .dtl-alert.info { background: #dbeafe; border: 1px solid #3b82f6; }
    .dtl-alert .icon { font-size: 24px; flex-shrink: 0; }
    .dtl-alert .content h5 { margin: 0 0 8px; font-weight: 600; color: #1e293b; }
    .dtl-alert .content p { margin: 0; color: #64748b; }
</style>

<div class="dtl-container">
    <div class="dtl-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="dtl-header-icon">📦</div>
                <div>
                    <h1>Detail Permintaan Bantuan</h1>
                    <p>Informasi lengkap permintaan bantuan Anda</p>
                </div>
            </div>
            <div>
                @if($bantuan->status == 'pending')
                <a href="{{ route('petani.bantuan.edit', $bantuan->id) }}" class="dtl-edit-btn">
                    ✏️ Edit
                </a>
                @endif
                <a href="{{ route('petani.bantuan.index') }}" class="dtl-back-btn">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="dtl-card">
        <div class="dtl-card-header">
            <span class="icon">📋</span>
            <h5>Informasi Bantuan</h5>
        </div>
        <div class="dtl-card-body">
            <div class="dtl-info-grid">
                <div class="dtl-info-item">
                    <label>📦 Jenis Bantuan</label>
                    <p>{{ $bantuan->jenis_bantuan }}</p>
                </div>
                <div class="dtl-info-item">
                    <label>🔢 Jumlah</label>
                    <p>{{ $bantuan->jumlah }}</p>
                </div>
                <div class="dtl-info-item">
                    <label>📅 Tanggal Permintaan</label>
                    <p>{{ $bantuan->tanggal_permintaan ? \Carbon\Carbon::parse($bantuan->tanggal_permintaan)->format('d F Y') : ($bantuan->created_at ? $bantuan->created_at->format('d F Y') : '-') }}</p>
                </div>
                <div class="dtl-info-item">
                    <label>📊 Status</label>
                    <p>
                        @if($bantuan->status == 'pending')
                            <span class="dtl-status-badge pending">⏳ Menunggu Persetujuan</span>
                        @elseif($bantuan->status == 'approved')
                            <span class="dtl-status-badge approved">✅ Disetujui</span>
                        @elseif($bantuan->status == 'rejected')
                            <span class="dtl-status-badge rejected">❌ Ditolak</span>
                        @elseif($bantuan->status == 'delivered')
                            <span class="dtl-status-badge delivered">🚚 Telah Dikirim</span>
                        @else
                            <span class="dtl-status-badge">{{ $bantuan->status }}</span>
                        @endif
                    </p>
                </div>
                @if($bantuan->tanggal)
                <div class="dtl-info-item">
                    <label>🚚 Tanggal Dikirim</label>
                    <p>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</p>
                </div>
                @endif
                <div class="dtl-info-item">
                    <label>🕐 Dibuat Pada</label>
                    <p>{{ $bantuan->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            @if($bantuan->keterangan)
            <div class="dtl-info-item" style="margin-top: 20px;">
                <label>📝 Keterangan</label>
                <p style="font-weight: 400;">{{ $bantuan->keterangan }}</p>
            </div>
            @endif

            @if($bantuan->status == 'rejected' && $bantuan->rejection_reason)
            <div class="dtl-alert danger">
                <span class="icon">⚠️</span>
                <div class="content">
                    <h5>Alasan Penolakan</h5>
                    <p>{{ $bantuan->rejection_reason }}</p>
                </div>
            </div>
            @endif

            @if($bantuan->status == 'approved')
            <div class="dtl-alert success">
                <span class="icon">✅</span>
                <div class="content">
                    <h5>Bantuan Disetujui</h5>
                    <p>Permintaan bantuan Anda telah disetujui. Silakan tunggu informasi selanjutnya untuk pengambilan bantuan.</p>
                </div>
            </div>
            @endif

            @if($bantuan->status == 'delivered')
            <div class="dtl-alert info">
                <span class="icon">🚚</span>
                <div class="content">
                    <h5>Bantuan Telah Dikirim</h5>
                    <p>Bantuan telah dikirim pada tanggal {{ $bantuan->tanggal ? \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') : '-' }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
