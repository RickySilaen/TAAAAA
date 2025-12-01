@extends('layouts.app')

@section('title', 'Laporan Panen Saya')

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
    
    .lpr-add-btn {
        background: #fff; color: #059669;
        padding: 12px 24px; border-radius: 12px; font-weight: 600;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s; border: none;
    }
    .lpr-add-btn:hover { background: #f0fdf4; color: #047857; transform: translateY(-2px); }
    
    .lpr-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    @media (max-width: 992px) { .lpr-stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .lpr-stats-row { grid-template-columns: 1fr; } }
    
    .lpr-stat-box {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex; align-items: center; gap: 16px;
    }
    .lpr-stat-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }
    .lpr-stat-icon.total { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1d4ed8; }
    .lpr-stat-icon.approved { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
    .lpr-stat-icon.pending { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
    .lpr-stat-icon.rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
    
    .lpr-stat-info h3 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; }
    .lpr-stat-info p { margin: 0; font-size: 13px; color: #64748b; }
    
    .lpr-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .lpr-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .lpr-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 10px; }
    .lpr-card-header h5 i { color: #10b981; }
    
    .lpr-search-box {
        display: flex; align-items: center; gap: 8px;
        background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;
        padding: 8px 14px; transition: all 0.3s;
    }
    .lpr-search-box:focus-within { border-color: #10b981; background: #fff; }
    .lpr-search-box input {
        border: none; background: transparent; outline: none;
        font-size: 14px; color: #374151; width: 200px;
    }
    .lpr-search-box i { color: #9ca3af; }
    
    .lpr-table { width: 100%; border-collapse: collapse; }
    .lpr-table thead { background: #f8fafc; }
    .lpr-table th {
        padding: 14px 20px; text-align: left; font-weight: 600;
        color: #64748b; font-size: 13px; text-transform: uppercase;
        letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;
    }
    .lpr-table td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .lpr-table tbody tr:hover { background: #f8fafc; }
    
    .lpr-badge {
        padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .lpr-badge.pending { background: #fef3c7; color: #d97706; }
    .lpr-badge.approved { background: #dcfce7; color: #16a34a; }
    .lpr-badge.rejected { background: #fee2e2; color: #dc2626; }
    
    .lpr-action-btn {
        padding: 8px 12px; border-radius: 8px; border: none;
        font-size: 13px; font-weight: 500; cursor: pointer;
        transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    }
    .lpr-action-btn.view { background: #dbeafe; color: #2563eb; }
    .lpr-action-btn.view:hover { background: #bfdbfe; }
    .lpr-action-btn.edit { background: #fef3c7; color: #d97706; }
    .lpr-action-btn.edit:hover { background: #fde68a; }
    .lpr-action-btn.delete { background: #fee2e2; color: #dc2626; }
    .lpr-action-btn.delete:hover { background: #fecaca; }
    
    .lpr-empty-state {
        text-align: center; padding: 60px 20px;
    }
    .lpr-empty-state .icon { font-size: 64px; margin-bottom: 16px; }
    .lpr-empty-state h4 { margin: 0 0 8px; color: #374151; font-weight: 600; }
    .lpr-empty-state p { margin: 0 0 20px; color: #6b7280; }
    
    .lpr-alert {
        padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 12px;
    }
    .lpr-alert.success { background: #dcfce7; border: 1px solid #10b981; color: #166534; }
    .lpr-alert.error { background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; }
    .lpr-alert .close-btn { margin-left: auto; background: none; border: none; cursor: pointer; font-size: 18px; opacity: 0.7; }
    
    .lpr-harvest-value {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        padding: 6px 12px; border-radius: 8px;
        color: #166534; font-weight: 700;
    }
</style>

<div class="lpr-container">
    <div class="lpr-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="lpr-header-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h1>🌾 Laporan Panen Saya</h1>
                    <p>Dokumentasikan dan lacak hasil panen pertanian Anda</p>
                </div>
            </div>
            <a href="{{ route('petani.laporan.create') }}" class="lpr-add-btn">
                ➕ Buat Laporan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="lpr-alert success">
        <span>✅</span>
        <span>{{ session('success') }}</span>
        <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if(session('error'))
    <div class="lpr-alert error">
        <span>❌</span>
        <span>{{ session('error') }}</span>
        <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    <div class="lpr-stats-row">
        <div class="lpr-stat-box">
            <div class="lpr-stat-icon total">📊</div>
            <div class="lpr-stat-info">
                <h3>{{ $laporans->total() }}</h3>
                <p>Total Laporan</p>
            </div>
        </div>
        <div class="lpr-stat-box">
            <div class="lpr-stat-icon approved">✅</div>
            <div class="lpr-stat-info">
                <h3>{{ $laporans->where('status', 'verified')->count() }}</h3>
                <p>Diverifikasi</p>
            </div>
        </div>
        <div class="lpr-stat-box">
            <div class="lpr-stat-icon pending">⏳</div>
            <div class="lpr-stat-info">
                <h3>{{ $laporans->where('status', 'pending')->count() }}</h3>
                <p>Menunggu Verifikasi</p>
            </div>
        </div>
        <div class="lpr-stat-box">
            <div class="lpr-stat-icon rejected">❌</div>
            <div class="lpr-stat-info">
                <h3>{{ $laporans->where('status', 'rejected')->count() }}</h3>
                <p>Ditolak</p>
            </div>
        </div>
    </div>

    <div class="lpr-card">
        <div class="lpr-card-header">
            <h5><i class="fas fa-list"></i> Daftar Laporan Panen</h5>
            <div class="lpr-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari laporan..." onkeyup="filterTable()">
            </div>
        </div>
        <div class="table-responsive">
            <table class="lpr-table" id="laporanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Tanaman</th>
                        <th>Hasil Panen</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td>{{ $loop->iteration + ($laporans->currentPage() - 1) * $laporans->perPage() }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 20px;">🌱</span>
                                <strong>{{ $laporan->jenis_tanaman }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="lpr-harvest-value">{{ number_format($laporan->hasil_panen, 2) }} kg</span>
                        </td>
                        <td>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                                <span class="lpr-badge pending">⏳ Menunggu</span>
                            @elseif($laporan->status == 'verified')
                                <span class="lpr-badge approved">✅ Terverifikasi</span>
                            @elseif($laporan->status == 'rejected')
                                <span class="lpr-badge rejected">❌ Ditolak</span>
                            @else
                                <span class="lpr-badge">{{ $laporan->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ route('petani.laporan.show', $laporan->id) }}" class="lpr-action-btn view">
                                    👁️ Detail
                                </a>
                                @if($laporan->status == 'pending')
                                <a href="{{ route('petani.laporan.edit', $laporan->id) }}" class="lpr-action-btn edit">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('petani.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="lpr-action-btn delete">🗑️ Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="lpr-empty-state">
                                <div class="icon">📝</div>
                                <h4>Belum Ada Laporan Panen</h4>
                                <p>Anda belum membuat laporan panen. Mulai dokumentasikan hasil panen Anda!</p>
                                <a href="{{ route('petani.laporan.create') }}" class="lpr-add-btn" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff;">
                                    ➕ Buat Laporan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporans->hasPages())
        <div style="padding: 20px 24px; border-top: 1px solid #e2e8f0;">
            {{ $laporans->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#laporanTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
@endsection
