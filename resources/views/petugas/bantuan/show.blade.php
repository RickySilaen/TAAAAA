@extends('layouts.app')

@section('title', 'Detail Bantuan - Petugas')

@section('content')
<style>
    .ptg-container { padding: 24px; }
    
    .ptg-header-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
    }
    
    .ptg-header-card h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .ptg-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .ptg-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px;
    }
    .ptg-header-icon i { font-size: 24px !important; color: #fff !important; }
    
    .ptg-back-btn {
        background: rgba(255,255,255,0.2); color: #fff;
        padding: 10px 20px; border-radius: 10px; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s;
    }
    .ptg-back-btn:hover { background: #fff; color: #059669; }
    
    .ptg-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
    }
    
    .ptg-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
    }
    .ptg-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; }
    .ptg-card-header i { font-size: 18px !important; color: #10b981 !important; }
    
    .ptg-card-body { padding: 24px; }
    
    .ptg-profile {
        display: flex; align-items: center; gap: 16px;
        padding: 20px; background: #f8fafc; border-radius: 16px; margin-bottom: 24px;
    }
    
    .ptg-profile-avatar {
        width: 72px; height: 72px; border-radius: 16px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 24px; font-weight: 700;
    }
    .ptg-profile-avatar img { width: 100%; height: 100%; border-radius: 16px; object-fit: cover; }
    
    .ptg-profile-info h4 { margin: 0 0 4px 0; font-weight: 600; color: #1e293b; }
    .ptg-profile-info p { margin: 0; color: #64748b; font-size: 14px; }
    
    .ptg-status-badge {
        padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .ptg-status-badge i { font-size: 12px !important; }
    .ptg-status-badge.success { background: #dcfce7; color: #16a34a; }
    .ptg-status-badge.warning { background: #fef3c7; color: #d97706; }
    .ptg-status-badge.danger { background: #fee2e2; color: #dc2626; }
    
    .ptg-info-row {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) { .ptg-info-row { grid-template-columns: 1fr; } }
    
    .ptg-info-item label { display: block; font-size: 13px; color: #64748b; margin-bottom: 6px; font-weight: 500; }
    .ptg-info-item p { margin: 0; font-size: 15px; color: #1e293b; font-weight: 500; }
    
    .ptg-form-group { margin-bottom: 20px; }
    .ptg-form-group label { display: block; font-weight: 600; color: #374151; margin-bottom: 8px; }
    
    .ptg-form-select, .ptg-form-textarea {
        width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 14px; color: #1e293b; background: #fff; transition: all 0.3s;
    }
    .ptg-form-select:focus, .ptg-form-textarea:focus {
        outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .ptg-submit-btn {
        width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #10b981, #059669);
        color: #fff; border: none; border-radius: 12px; font-size: 15px; font-weight: 600;
        cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    }
    .ptg-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
</style>

<div class="ptg-container">
    <div class="ptg-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="ptg-header-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h1>Detail Bantuan</h1>
                    <p>Informasi lengkap bantuan petani</p>
                </div>
            </div>
            <a href="{{ route('petugas.bantuan.index') }}" class="ptg-back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="ptg-card">
                <div class="ptg-card-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informasi Bantuan</h5>
                </div>
                <div class="ptg-card-body">
                    <div class="ptg-profile">
                        <div class="ptg-profile-avatar">
                            @if($bantuan->user->profile_picture)
                                <img src="{{ asset('storage/' . $bantuan->user->profile_picture) }}" alt="avatar">
                            @else
                                {{ strtoupper(substr($bantuan->user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="ptg-profile-info">
                            <h4>{{ $bantuan->user->name }}</h4>
                            <p>📍 {{ $bantuan->user->alamat_desa }}</p>
                            <p>🌾 Luas Lahan: {{ $bantuan->user->luas_lahan }} hektar</p>
                        </div>
                        <div class="ms-auto">
                            @if($bantuan->status == 'Dikirim')
                                <span class="ptg-status-badge success"><i class="fas fa-check"></i> Dikirim</span>
                            @elseif($bantuan->status == 'Diproses')
                                <span class="ptg-status-badge warning"><i class="fas fa-clock"></i> Diproses</span>
                            @else
                                <span class="ptg-status-badge danger"><i class="fas fa-times"></i> Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <div class="ptg-info-row">
                        <div class="ptg-info-item">
                            <label>📅 Tanggal Pengajuan</label>
                            <p>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</p>
                        </div>
                        <div class="ptg-info-item">
                            <label>📦 Jenis Bantuan</label>
                            <p>{{ $bantuan->jenis_bantuan }}</p>
                        </div>
                    </div>

                    <div class="ptg-info-item">
                        <label>🔢 Jumlah</label>
                        <p>{{ $bantuan->jumlah }}</p>
                    </div>

                    @if($bantuan->catatan)
                    <div class="ptg-info-item mt-3">
                        <label>📝 Catatan</label>
                        <p>{{ $bantuan->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ptg-card">
                <div class="ptg-card-header">
                    <i class="fas fa-edit"></i>
                    <h5>Update Status</h5>
                </div>
                <div class="ptg-card-body">
                    <form action="{{ route('petugas.bantuan.update-status', $bantuan->id) }}" method="POST">
                        @csrf
                        <div class="ptg-form-group">
                            <label>Status Bantuan</label>
                            <select name="status" class="ptg-form-select" required>
                                <option value="Diproses" {{ $bantuan->status == 'Diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                                <option value="Dikirim" {{ $bantuan->status == 'Dikirim' ? 'selected' : '' }}>✅ Dikirim</option>
                                <option value="Ditolak" {{ $bantuan->status == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </div>

                        <div class="ptg-form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="catatan" class="ptg-form-textarea" rows="4" placeholder="Tambahkan catatan...">{{ $bantuan->catatan }}</textarea>
                        </div>

                        <button type="submit" class="ptg-submit-btn">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
