@extends('layouts.app')

@section('title', 'Detail Petani - Petugas')

@section('content')
<style>
    .ptn-container { padding: 24px; }
    
    .ptn-header-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
    }
    
    .ptn-header-card h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .ptn-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .ptn-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px;
    }
    .ptn-header-icon i { font-size: 24px !important; color: #fff !important; }
    
    .ptn-back-btn {
        background: rgba(255,255,255,0.2); color: #fff;
        padding: 10px 20px; border-radius: 10px; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s;
    }
    .ptn-back-btn:hover { background: #fff; color: #059669; }
    
    .ptn-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
    }
    
    .ptn-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
    }
    .ptn-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; }
    .ptn-card-header i { font-size: 18px !important; color: #10b981 !important; }
    
    .ptn-card-body { padding: 24px; }
    
    .ptn-profile-card { text-align: center; padding: 32px 24px; }
    
    .ptn-avatar {
        width: 120px; height: 120px; border-radius: 50%;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 42px; font-weight: 700;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
    }
    .ptn-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    
    .ptn-profile-name { font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px; }
    .ptn-profile-email { font-size: 14px; color: #64748b; margin: 0 0 16px; }
    
    .ptn-status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px; border-radius: 50px; font-size: 14px; font-weight: 600;
    }
    .ptn-status-badge.verified { background: #dcfce7; color: #16a34a; }
    .ptn-status-badge.pending { background: #fef3c7; color: #d97706; }
    
    .ptn-verified-info { margin-top: 12px; font-size: 13px; color: #64748b; }
    
    .ptn-action-btns { margin-top: 24px; display: flex; flex-direction: column; gap: 12px; }
    .ptn-btn {
        padding: 14px 20px; border-radius: 12px; border: none;
        font-size: 15px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.3s;
    }
    .ptn-btn-success { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .ptn-btn-success:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
    .ptn-btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
    .ptn-btn-danger:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3); }
    
    .ptn-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    @media (max-width: 768px) { .ptn-info-grid { grid-template-columns: 1fr; } }
    
    .ptn-info-item { padding: 16px; background: #f8fafc; border-radius: 12px; }
    .ptn-info-item label { display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; text-transform: uppercase; font-weight: 500; }
    .ptn-info-item p { margin: 0; font-size: 15px; color: #1e293b; font-weight: 500; }
    .ptn-info-item .badge { font-size: 12px; padding: 6px 12px; border-radius: 8px; }
    .ptn-info-item .badge-info { background: #dbeafe; color: #2563eb; }
    
    .ptn-timeline { padding-left: 24px; border-left: 2px solid #e2e8f0; }
    .ptn-timeline-item { position: relative; padding-bottom: 24px; }
    .ptn-timeline-item:last-child { padding-bottom: 0; }
    .ptn-timeline-dot {
        position: absolute; left: -33px; top: 0;
        width: 20px; height: 20px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 10px; color: #fff;
    }
    .ptn-timeline-dot.green { background: #10b981; }
    .ptn-timeline-dot.blue { background: #3b82f6; }
    .ptn-timeline-content h6 { margin: 0 0 4px; font-size: 14px; font-weight: 600; color: #1e293b; }
    .ptn-timeline-content p { margin: 0; font-size: 13px; color: #64748b; }
    
    /* Modal Styles */
    .ptn-modal .modal-content { border-radius: 20px; border: none; overflow: hidden; }
    .ptn-modal .modal-header { padding: 20px 24px; border: none; }
    .ptn-modal .modal-header.success { background: linear-gradient(135deg, #10b981, #059669); }
    .ptn-modal .modal-header.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .ptn-modal .modal-title { color: #fff; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    .ptn-modal .btn-close { filter: brightness(0) invert(1); }
    .ptn-modal .modal-body { padding: 24px; }
    .ptn-modal .modal-footer { padding: 16px 24px; border: none; background: #f8fafc; }
    
    .ptn-modal-avatar {
        width: 80px; height: 80px; border-radius: 50%;
        margin: 0 auto 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; font-weight: 700; color: #fff;
    }
    .ptn-modal-avatar.success { background: linear-gradient(135deg, #10b981, #059669); }
    .ptn-modal-avatar.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .ptn-modal-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    
    .ptn-modal-info { background: #f8fafc; border-radius: 12px; padding: 16px; margin: 16px 0; }
    .ptn-modal-info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
    .ptn-modal-info-row:last-child { border-bottom: none; }
    .ptn-modal-info-row span:first-child { color: #64748b; font-size: 13px; }
    .ptn-modal-info-row span:last-child { color: #1e293b; font-weight: 500; font-size: 13px; }
    
    .ptn-alert { padding: 16px; border-radius: 12px; margin-top: 16px; display: flex; gap: 12px; }
    .ptn-alert.success { background: #dcfce7; border: 1px solid #10b981; }
    .ptn-alert.success .icon { color: #10b981; }
    .ptn-alert.danger { background: #fee2e2; border: 1px solid #ef4444; }
    .ptn-alert.danger .icon { color: #ef4444; }
    .ptn-alert .icon { font-size: 20px; flex-shrink: 0; }
    .ptn-alert .content { font-size: 13px; color: #374151; line-height: 1.5; }
    .ptn-alert .content strong { display: block; margin-bottom: 8px; }
    .ptn-alert .content ul { margin: 0; padding-left: 16px; }
    
    .ptn-modal-btn {
        padding: 12px 24px; border-radius: 10px; border: none;
        font-size: 14px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s;
    }
    .ptn-modal-btn-secondary { background: #e2e8f0; color: #475569; }
    .ptn-modal-btn-secondary:hover { background: #cbd5e1; }
    .ptn-modal-btn-success { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .ptn-modal-btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
</style>

<div class="ptn-container">
    <div class="ptn-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="ptn-header-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h1>Detail Petani</h1>
                    <p>Informasi lengkap petani terdaftar</p>
                </div>
            </div>
            <a href="{{ route('petugas.petani.index') }}" class="ptn-back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="ptn-card">
                <div class="ptn-profile-card">
                    <div class="ptn-avatar">
                        @if($petani->profile_picture)
                            <img src="{{ asset('storage/' . $petani->profile_picture) }}" alt="Profile">
                        @else
                            {{ strtoupper(substr($petani->name, 0, 1)) }}
                        @endif
                    </div>
                    
                    <h4 class="ptn-profile-name">{{ $petani->name }}</h4>
                    <p class="ptn-profile-email">{{ $petani->email }}</p>
                    
                    @if($petani->is_verified)
                        <span class="ptn-status-badge verified">✅ Terverifikasi</span>
                        <p class="ptn-verified-info">
                            📅 {{ $petani->verified_at->format('d F Y, H:i') }}
                            @if($petani->verifiedBy)
                                <br>oleh {{ $petani->verifiedBy->name }}
                            @endif
                        </p>
                    @else
                        <span class="ptn-status-badge pending">⏳ Menunggu Verifikasi</span>
                        <p class="ptn-verified-info">Mendaftar {{ $petani->created_at->diffForHumans() }}</p>
                        
                        <div class="ptn-action-btns">
                            <button type="button" class="ptn-btn ptn-btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal">
                                ✅ Verifikasi Akun
                            </button>
                            <button type="button" class="ptn-btn ptn-btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                ❌ Tolak Pendaftaran
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="ptn-card">
                <div class="ptn-card-header">
                    <i class="fas fa-id-card"></i>
                    <h5>Informasi Petani</h5>
                </div>
                <div class="ptn-card-body">
                    <div class="ptn-info-grid">
                        <div class="ptn-info-item">
                            <label>👤 Nama Lengkap</label>
                            <p>{{ $petani->name }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>📧 Email</label>
                            <p>{{ $petani->email }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>📱 Nomor Telepon</label>
                            <p>{{ $petani->telepon ?? '-' }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>🏷️ Role</label>
                            <p><span class="badge badge-info">{{ ucfirst($petani->role) }}</span></p>
                        </div>
                        <div class="ptn-info-item">
                            <label>🏘️ Alamat Desa</label>
                            <p>{{ $petani->alamat_desa ?? '-' }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>📍 Alamat Kecamatan</label>
                            <p>{{ $petani->alamat_kecamatan ?? '-' }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>📅 Tanggal Pendaftaran</label>
                            <p>{{ $petani->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="ptn-info-item">
                            <label>🌾 Luas Lahan</label>
                            <p>{{ $petani->luas_lahan ?? '-' }} Ha</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ptn-card">
                <div class="ptn-card-header">
                    <i class="fas fa-history"></i>
                    <h5>Riwayat Aktivitas</h5>
                </div>
                <div class="ptn-card-body">
                    <div class="ptn-timeline">
                        <div class="ptn-timeline-item">
                            <div class="ptn-timeline-dot green">✓</div>
                            <div class="ptn-timeline-content">
                                <h6>📝 Pendaftaran Akun</h6>
                                <p>{{ $petani->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($petani->is_verified)
                        <div class="ptn-timeline-item">
                            <div class="ptn-timeline-dot blue">✓</div>
                            <div class="ptn-timeline-content">
                                <h6>✅ Akun Diverifikasi</h6>
                                <p>{{ $petani->verified_at->format('d F Y, H:i') }}
                                @if($petani->verifiedBy)
                                    oleh {{ $petani->verifiedBy->name }}
                                @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$petani->is_verified)
<!-- Modal Verifikasi -->
<div class="modal fade ptn-modal" id="verifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header success">
                <h5 class="modal-title">✅ Konfirmasi Verifikasi Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="ptn-modal-avatar success">
                    @if($petani->profile_picture)
                        <img src="{{ asset('storage/' . $petani->profile_picture) }}" alt="Profile">
                    @else
                        {{ strtoupper(substr($petani->name, 0, 1)) }}
                    @endif
                </div>
                <h5 style="margin: 0 0 4px; font-weight: 600; color: #1e293b;">{{ $petani->name }}</h5>
                <p style="margin: 0 0 16px; color: #64748b; font-size: 14px;">{{ $petani->email }}</p>
                
                <p style="font-weight: 500; color: #374151;">Apakah Anda yakin ingin memverifikasi akun petani ini?</p>
                
                <div class="ptn-modal-info text-start">
                    <div class="ptn-modal-info-row">
                        <span>🏘️ Desa</span>
                        <span>{{ $petani->alamat_desa ?? '-' }}</span>
                    </div>
                    <div class="ptn-modal-info-row">
                        <span>📍 Kecamatan</span>
                        <span>{{ $petani->alamat_kecamatan ?? '-' }}</span>
                    </div>
                    <div class="ptn-modal-info-row">
                        <span>📱 Telepon</span>
                        <span>{{ $petani->telepon ?? '-' }}</span>
                    </div>
                    <div class="ptn-modal-info-row">
                        <span>📅 Terdaftar</span>
                        <span>{{ $petani->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                
                <div class="ptn-alert success text-start">
                    <div class="icon">ℹ️</div>
                    <div class="content">
                        Setelah diverifikasi, <strong>{{ $petani->name }}</strong> akan mendapat notifikasi dan dapat login untuk mengakses sistem.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ptn-modal-btn ptn-modal-btn-secondary" data-bs-dismiss="modal">
                    ❌ Batal
                </button>
                <form action="{{ route('petugas.petani.verify', $petani->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="ptn-modal-btn ptn-modal-btn-success">
                        ✅ Ya, Verifikasi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade ptn-modal" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header danger">
                <h5 class="modal-title">⚠️ Konfirmasi Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="ptn-modal-avatar danger">
                    @if($petani->profile_picture)
                        <img src="{{ asset('storage/' . $petani->profile_picture) }}" alt="Profile">
                    @else
                        {{ strtoupper(substr($petani->name, 0, 1)) }}
                    @endif
                </div>
                <h5 style="margin: 0 0 4px; font-weight: 600; color: #dc2626;">{{ $petani->name }}</h5>
                <p style="margin: 0 0 16px; color: #64748b; font-size: 14px;">{{ $petani->email }}</p>
                
                <p style="font-weight: 600; color: #dc2626;">⚠️ Yakin ingin menolak pendaftaran ini?</p>
                
                <div class="ptn-alert danger text-start">
                    <div class="icon">⚠️</div>
                    <div class="content">
                        <strong>PERHATIAN!</strong>
                        <ul>
                            <li>Akun <strong>{{ $petani->name }}</strong> akan dihapus secara permanen</li>
                            <li>Data tidak dapat dipulihkan kembali</li>
                            <li>Petani harus mendaftar ulang jika ingin masuk sistem</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ptn-modal-btn ptn-modal-btn-secondary" data-bs-dismiss="modal">
                    ← Batal, Kembali
                </button>
                <form action="{{ route('petugas.petani.reject', $petani->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ptn-modal-btn ptn-modal-btn-danger">
                        🗑️ Ya, Tolak & Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
