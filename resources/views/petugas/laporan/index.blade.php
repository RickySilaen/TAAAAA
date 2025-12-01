@extends('layouts.app')

@section('title', 'Verifikasi Laporan - Petugas')

@section('content')
<style>
    .ptg-container { padding: 24px; }
    
    .ptg-header-card {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(139, 92, 246, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .ptg-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .ptg-header-card h1 { color: #fff; font-size: 28px; font-weight: 700; margin: 0 0 8px 0; }
    .ptg-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .ptg-header-icon {
        width: 60px; height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 20px;
    }
    .ptg-header-icon i { font-size: 28px !important; color: #fff !important; }

    .ptg-stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
    @media (max-width: 992px) { .ptg-stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .ptg-stats-row { grid-template-columns: 1fr; } }
    
    .ptg-stat-box {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .ptg-stat-box:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
    
    .ptg-stat-box .stat-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
    }
    .ptg-stat-box .stat-icon i { font-size: 22px !important; color: #fff !important; }
    .ptg-stat-box .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .ptg-stat-box .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
    .ptg-stat-box .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
    
    .ptg-stat-box .stat-label { font-size: 13px; color: #64748b; font-weight: 500; text-transform: uppercase; }
    .ptg-stat-box .stat-value { font-size: 32px; font-weight: 700; }
    .ptg-stat-box .stat-value.purple { color: #8b5cf6; }
    .ptg-stat-box .stat-value.green { color: #10b981; }
    .ptg-stat-box .stat-value.orange { color: #f59e0b; }

    .ptg-table-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .ptg-table-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        padding: 20px 24px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .ptg-table-header h5 { color: #fff; margin: 0; font-weight: 600; font-size: 16px; }
    .ptg-table-header h5 i { margin-right: 8px; }
    
    .ptg-search-box { position: relative; min-width: 280px; }
    .ptg-search-box input {
        width: 100%; padding: 12px 16px 12px 44px;
        border: none; border-radius: 10px;
        background: rgba(255,255,255,0.2); color: #fff; font-size: 14px;
    }
    .ptg-search-box input::placeholder { color: rgba(255,255,255,0.7); }
    .ptg-search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.7); }
    
    .ptg-table { width: 100%; border-collapse: collapse; }
    .ptg-table thead th {
        background: #f8fafc; padding: 16px; text-align: left;
        font-size: 12px; font-weight: 600; color: #475569;
        text-transform: uppercase; border-bottom: 2px solid #e2e8f0;
    }
    .ptg-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.2s; }
    .ptg-table tbody tr:hover { background: #f8fafc; }
    .ptg-table tbody td { padding: 16px; font-size: 14px; color: #334155; vertical-align: middle; }
    
    .ptg-avatar {
        width: 44px; height: 44px; border-radius: 12px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 14px; flex-shrink: 0;
    }
    .ptg-avatar img { width: 100%; height: 100%; border-radius: 12px; object-fit: cover; }
    .ptg-user-info .name { font-weight: 600; color: #1e293b; margin-bottom: 2px; }
    .ptg-user-info .desa { font-size: 12px; color: #64748b; }
    
    .ptg-badge {
        padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .ptg-badge i { font-size: 10px !important; }
    .ptg-badge.success { background: #dcfce7; color: #16a34a; }
    .ptg-badge.warning { background: #fef3c7; color: #d97706; }
    .ptg-badge.danger { background: #fee2e2; color: #dc2626; }
    .ptg-badge.info { background: #dbeafe; color: #2563eb; }
    
    .ptg-action-btn {
        padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
        display: inline-flex; align-items: center; gap: 6px;
        border: none; cursor: pointer; transition: all 0.2s; text-decoration: none;
        background: #ede9fe; color: #7c3aed;
    }
    .ptg-action-btn:hover { background: #7c3aed; color: #fff; }
    
    .ptg-empty { text-align: center; padding: 60px 20px; }
    .ptg-empty-icon {
        width: 100px; height: 100px;
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .ptg-empty-icon i { font-size: 40px !important; color: #8b5cf6 !important; }
    .ptg-empty h5 { color: #475569; margin-bottom: 8px; font-weight: 600; }
    .ptg-empty p { color: #94a3b8; margin: 0; }
</style>

<div class="ptg-container">
    <div class="ptg-header-card">
        <div class="d-flex align-items-center">
            <div class="ptg-header-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <h1>Verifikasi Laporan</h1>
                <p>Verifikasi laporan petani - {{ Auth::user()->alamat_desa }}</p>
            </div>
        </div>
    </div>

    <div class="ptg-stats-row">
        <div class="ptg-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Laporan</div>
                    <div class="stat-value purple">{{ $laporans->count() }}</div>
                    <div class="stat-desc">📋 Semua data</div>
                </div>
                <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
            </div>
        </div>
        <div class="ptg-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Diverifikasi</div>
                    <div class="stat-value green">{{ $laporans->where('status', 'verified')->count() }}</div>
                    <div class="stat-desc">✅ Sudah diverifikasi</div>
                </div>
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="ptg-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value orange">{{ $laporans->where('status', 'pending')->count() }}</div>
                    <div class="stat-desc">⏳ Menunggu verifikasi</div>
                </div>
                <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>

    <div class="ptg-table-card">
        <div class="ptg-table-header">
            <h5><i class="fas fa-table"></i>Daftar Laporan Petani</h5>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('petugas.export.laporan.pdf') }}" class="btn btn-light btn-sm" style="border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-file-pdf text-danger me-1"></i> Export PDF
                </a>
                <div class="ptg-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari laporan..." onkeyup="searchTable()">
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="ptg-table" id="laporanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Petani</th>
                        <th>Deskripsi</th>
                        <th>Hasil Panen</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $laporan)
                    <tr>
                        <td><span class="fw-bold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="ptg-avatar">
                                    @if($laporan->user->profile_picture)
                                        <img src="{{ asset('storage/' . $laporan->user->profile_picture) }}" alt="avatar">
                                    @else
                                        {{ strtoupper(substr($laporan->user->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="ptg-user-info">
                                    <div class="name">{{ $laporan->user->name }}</div>
                                    <div class="desa">{{ $laporan->user->alamat_desa }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($laporan->deskripsi_kemajuan, 40) }}</div>
                            @if($laporan->jenis_tanaman)
                            <div class="text-muted small">🌱 {{ $laporan->jenis_tanaman }}</div>
                            @endif
                        </td>
                        <td><span class="ptg-badge success">{{ number_format($laporan->hasil_panen) }} kg</span></td>
                        <td>
                            <div class="fw-medium">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            @if($laporan->status == 'verified')
                                <span class="ptg-badge success"><i class="fas fa-check"></i> Terverifikasi</span>
                            @elseif($laporan->status == 'rejected')
                                <span class="ptg-badge danger"><i class="fas fa-times"></i> Ditolak</span>
                            @else
                                <span class="ptg-badge warning"><i class="fas fa-clock"></i> Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('petugas.laporan.show', $laporan->id) }}" class="ptg-action-btn">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ptg-empty">
                                <div class="ptg-empty-icon"><i class="fas fa-clipboard-list"></i></div>
                                <h5>Belum Ada Laporan</h5>
                                <p>Laporan dari petani di wilayah Anda akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#laporanTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}
</script>
@endsection
