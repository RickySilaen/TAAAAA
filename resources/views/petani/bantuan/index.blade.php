@extends('layouts.app')

@section('title', 'Permintaan Bantuan Saya')

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
    
    .ptn-add-btn {
        background: #fff; color: #059669;
        padding: 12px 24px; border-radius: 12px; font-weight: 600;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s; border: none;
    }
    .ptn-add-btn:hover { background: #f0fdf4; color: #047857; transform: translateY(-2px); }
    
    .ptn-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    @media (max-width: 992px) { .ptn-stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .ptn-stats-row { grid-template-columns: 1fr; } }
    
    .ptn-stat-box {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex; align-items: center; gap: 16px;
    }
    .ptn-stat-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }
    .ptn-stat-icon.total { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1d4ed8; }
    .ptn-stat-icon.approved { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
    .ptn-stat-icon.pending { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
    .ptn-stat-icon.rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
    
    .ptn-stat-info h3 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; }
    .ptn-stat-info p { margin: 0; font-size: 13px; color: #64748b; }
    
    .ptn-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .ptn-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .ptn-card-header h5 { margin: 0; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 10px; }
    .ptn-card-header h5 i { color: #10b981; }
    
    .ptn-search-box {
        display: flex; align-items: center; gap: 8px;
        background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px;
        padding: 8px 14px; transition: all 0.3s;
    }
    .ptn-search-box:focus-within { border-color: #10b981; background: #fff; }
    .ptn-search-box input {
        border: none; background: transparent; outline: none;
        font-size: 14px; color: #374151; width: 200px;
    }
    .ptn-search-box i { color: #9ca3af; }
    
    .ptn-table { width: 100%; border-collapse: collapse; }
    .ptn-table thead { background: #f8fafc; }
    .ptn-table th {
        padding: 14px 20px; text-align: left; font-weight: 600;
        color: #64748b; font-size: 13px; text-transform: uppercase;
        letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;
    }
    .ptn-table td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .ptn-table tbody tr:hover { background: #f8fafc; }
    
    .ptn-badge {
        padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .ptn-badge.pending { background: #fef3c7; color: #d97706; }
    .ptn-badge.approved { background: #dcfce7; color: #16a34a; }
    .ptn-badge.rejected { background: #fee2e2; color: #dc2626; }
    .ptn-badge.delivered { background: #dbeafe; color: #2563eb; }
    
    .ptn-action-btn {
        padding: 8px 12px; border-radius: 8px; border: none;
        font-size: 13px; font-weight: 500; cursor: pointer;
        transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    }
    .ptn-action-btn.view { background: #dbeafe; color: #2563eb; }
    .ptn-action-btn.view:hover { background: #bfdbfe; }
    .ptn-action-btn.edit { background: #fef3c7; color: #d97706; }
    .ptn-action-btn.edit:hover { background: #fde68a; }
    .ptn-action-btn.delete { background: #fee2e2; color: #dc2626; }
    .ptn-action-btn.delete:hover { background: #fecaca; }
    
    .ptn-empty-state {
        text-align: center; padding: 60px 20px;
    }
    .ptn-empty-state .icon { font-size: 64px; margin-bottom: 16px; }
    .ptn-empty-state h4 { margin: 0 0 8px; color: #374151; font-weight: 600; }
    .ptn-empty-state p { margin: 0 0 20px; color: #6b7280; }
    
    .ptn-alert {
        padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 12px;
    }
    .ptn-alert.success { background: #dcfce7; border: 1px solid #10b981; color: #166534; }
    .ptn-alert.error { background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; }
    .ptn-alert .close-btn { margin-left: auto; background: none; border: none; cursor: pointer; font-size: 18px; opacity: 0.7; }
</style>

<div class="ptn-container">
    <div class="ptn-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="ptn-header-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h1>📦 Permintaan Bantuan Saya</h1>
                    <p>Kelola dan pantau status permintaan bantuan pertanian Anda</p>
                </div>
            </div>
            <a href="{{ route('petani.bantuan.create') }}" class="ptn-add-btn">
                ➕ Ajukan Bantuan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="ptn-alert success">
        <span>✅</span>
        <span>{{ session('success') }}</span>
        <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if(session('error'))
    <div class="ptn-alert error">
        <span>❌</span>
        <span>{{ session('error') }}</span>
        <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    <div class="ptn-stats-row">
        <div class="ptn-stat-box">
            <div class="ptn-stat-icon total">📊</div>
            <div class="ptn-stat-info">
                <h3>{{ $bantuans->total() }}</h3>
                <p>Total Permintaan</p>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="ptn-stat-icon approved">✅</div>
            <div class="ptn-stat-info">
                <h3>{{ $bantuans->where('status', 'approved')->count() + $bantuans->where('status', 'delivered')->count() }}</h3>
                <p>Disetujui</p>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="ptn-stat-icon pending">⏳</div>
            <div class="ptn-stat-info">
                <h3>{{ $bantuans->where('status', 'pending')->count() }}</h3>
                <p>Menunggu</p>
            </div>
        </div>
        <div class="ptn-stat-box">
            <div class="ptn-stat-icon rejected">❌</div>
            <div class="ptn-stat-info">
                <h3>{{ $bantuans->where('status', 'rejected')->count() }}</h3>
                <p>Ditolak</p>
            </div>
        </div>
    </div>

    <div class="ptn-card">
        <div class="ptn-card-header">
            <h5><i class="fas fa-list"></i> Daftar Permintaan Bantuan</h5>
            <div class="ptn-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari bantuan..." onkeyup="filterTable()">
            </div>
        </div>
        <div class="table-responsive">
            <table class="ptn-table" id="bantuanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Bantuan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bantuans as $bantuan)
                    <tr>
                        <td>{{ $loop->iteration + ($bantuans->currentPage() - 1) * $bantuans->perPage() }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 20px;">
                                    @if($bantuan->jenis_bantuan == 'Pupuk') 🧪
                                    @elseif($bantuan->jenis_bantuan == 'Bibit') 🌱
                                    @elseif($bantuan->jenis_bantuan == 'Pestisida') 🧴
                                    @elseif($bantuan->jenis_bantuan == 'Alat Pertanian') 🔧
                                    @elseif($bantuan->jenis_bantuan == 'Dana') 💰
                                    @else 📦
                                    @endif
                                </span>
                                <strong>{{ $bantuan->jenis_bantuan }}</strong>
                            </div>
                        </td>
                        <td><strong>{{ $bantuan->jumlah }}</strong></td>
                        <td>{{ $bantuan->tanggal_permintaan ? \Carbon\Carbon::parse($bantuan->tanggal_permintaan)->format('d/m/Y') : ($bantuan->created_at ? $bantuan->created_at->format('d/m/Y') : '-') }}</td>
                        <td>
                            @if($bantuan->status == 'pending')
                                <span class="ptn-badge pending">⏳ Menunggu</span>
                            @elseif($bantuan->status == 'approved')
                                <span class="ptn-badge approved">✅ Disetujui</span>
                            @elseif($bantuan->status == 'rejected')
                                <span class="ptn-badge rejected">❌ Ditolak</span>
                            @elseif($bantuan->status == 'delivered')
                                <span class="ptn-badge delivered">🚚 Dikirim</span>
                            @else
                                <span class="ptn-badge">{{ $bantuan->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ route('petani.bantuan.show', $bantuan->id) }}" class="ptn-action-btn view">
                                    👁️ Detail
                                </a>
                                @if($bantuan->status == 'pending')
                                <a href="{{ route('petani.bantuan.edit', $bantuan->id) }}" class="ptn-action-btn edit">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('petani.bantuan.destroy', $bantuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus permintaan bantuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ptn-action-btn delete">🗑️ Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="ptn-empty-state">
                                <div class="icon">📭</div>
                                <h4>Belum Ada Permintaan Bantuan</h4>
                                <p>Anda belum mengajukan permintaan bantuan. Mulai ajukan bantuan pertama Anda!</p>
                                <a href="{{ route('petani.bantuan.create') }}" class="ptn-add-btn" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff;">
                                    ➕ Ajukan Bantuan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bantuans->hasPages())
        <div style="padding: 20px 24px; border-top: 1px solid #e2e8f0;">
            {{ $bantuans->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#bantuanTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
@endsection
