@extends('layouts.app')

@section('title', 'Verifikasi Petani - Petugas')

@section('content')
<style>
    .ptg-container { padding: 24px; }
    
    .ptg-header-card {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(59, 130, 246, 0.3);
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

    .ptg-stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 24px; }
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
    .ptg-stat-box .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .ptg-stat-box .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
    
    .ptg-stat-box .stat-label { font-size: 13px; color: #64748b; font-weight: 500; text-transform: uppercase; }
    .ptg-stat-box .stat-value { font-size: 32px; font-weight: 700; }
    .ptg-stat-box .stat-value.orange { color: #f59e0b; }
    .ptg-stat-box .stat-value.green { color: #10b981; }

    .ptg-table-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .ptg-table-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
    .ptg-table tbody tr.pending { background: rgba(251, 191, 36, 0.08); }
    .ptg-table tbody td { padding: 16px; font-size: 14px; color: #334155; vertical-align: middle; }
    
    .ptg-avatar {
        width: 44px; height: 44px; border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 14px; flex-shrink: 0;
    }
    .ptg-avatar img { width: 100%; height: 100%; border-radius: 12px; object-fit: cover; }
    .ptg-user-info .name { font-weight: 600; color: #1e293b; margin-bottom: 2px; }
    .ptg-user-info .new-badge { 
        display: inline-block; padding: 2px 8px; border-radius: 4px;
        font-size: 10px; font-weight: 600; background: #fef3c7; color: #d97706;
    }
    
    .ptg-badge {
        padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .ptg-badge i { font-size: 10px !important; }
    .ptg-badge.success { background: #dcfce7; color: #16a34a; }
    .ptg-badge.warning { background: #fef3c7; color: #d97706; }
    
    .ptg-actions { display: flex; gap: 6px; }
    .ptg-action-btn {
        width: 36px; height: 36px; border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; cursor: pointer; transition: all 0.2s; text-decoration: none;
    }
    .ptg-action-btn i { font-size: 14px !important; }
    .ptg-action-btn.view { background: #dbeafe; color: #2563eb; }
    .ptg-action-btn.view:hover { background: #2563eb; color: #fff; }
    .ptg-action-btn.verify { background: #dcfce7; color: #16a34a; }
    .ptg-action-btn.verify:hover { background: #16a34a; color: #fff; }
    .ptg-action-btn.reject { background: #fee2e2; color: #dc2626; }
    .ptg-action-btn.reject:hover { background: #dc2626; color: #fff; }
    
    .ptg-empty { text-align: center; padding: 60px 20px; }
    .ptg-empty-icon {
        width: 100px; height: 100px;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .ptg-empty-icon i { font-size: 40px !important; color: #3b82f6 !important; }
    .ptg-empty h5 { color: #475569; margin-bottom: 8px; font-weight: 600; }
    .ptg-empty p { color: #94a3b8; margin: 0; }
    
    .ptg-alert {
        display: flex; align-items: center; gap: 12px;
        padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 500;
    }
    .ptg-alert.success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .ptg-alert.danger { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .ptg-alert i { font-size: 20px !important; }
</style>

<div class="ptg-container">
    <div class="ptg-header-card">
        <div class="d-flex align-items-center">
            <div class="ptg-header-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <h1>Verifikasi Petani</h1>
                <p>Kelola dan verifikasi pendaftaran petani - {{ auth()->user()->alamat_desa }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="ptg-alert success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="ptg-alert danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <div class="ptg-stats-row">
        <div class="ptg-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                    <div class="stat-value orange">{{ $petanis->where('is_verified', false)->count() }}</div>
                    <div class="stat-desc">⏳ Petani baru</div>
                </div>
                <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
            </div>
        </div>
        <div class="ptg-stat-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Sudah Terverifikasi</div>
                    <div class="stat-value green">{{ $petanis->where('is_verified', true)->count() }}</div>
                    <div class="stat-desc">✅ Terverifikasi</div>
                </div>
                <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
            </div>
        </div>
    </div>

    <div class="ptg-table-card">
        <div class="ptg-table-header">
            <h5><i class="fas fa-users"></i>Daftar Petani - {{ auth()->user()->alamat_desa }}</h5>
            <div class="ptg-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari petani..." onkeyup="searchTable()">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="ptg-table" id="petaniTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Petani</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Desa</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petanis as $index => $item)
                    <tr class="{{ !$item->is_verified ? 'pending' : '' }}">
                        <td><span class="fw-bold text-muted">{{ $petanis->firstItem() + $index }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="ptg-avatar">
                                    @if($item->profile_picture)
                                        <img src="{{ asset('storage/' . $item->profile_picture) }}" alt="avatar">
                                    @else
                                        {{ strtoupper(substr($item->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="ptg-user-info">
                                    <div class="name">{{ $item->name }}</div>
                                    @if(!$item->is_verified)
                                    <span class="new-badge">Baru</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telepon ?? '-' }}</td>
                        <td>{{ $item->alamat_desa }}</td>
                        <td>
                            @if($item->is_verified)
                                <span class="ptg-badge success"><i class="fas fa-check"></i> Terverifikasi</span>
                            @else
                                <span class="ptg-badge warning"><i class="fas fa-clock"></i> Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $item->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $item->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div class="ptg-actions">
                                <a href="{{ route('petugas.petani.show', $item->id) }}" class="ptg-action-btn view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$item->is_verified)
                                <button type="button" class="ptg-action-btn verify" title="Verifikasi" 
                                        data-bs-toggle="modal" data-bs-target="#verifyModal{{ $item->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="ptg-action-btn reject" title="Tolak" 
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="ptg-empty">
                                <div class="ptg-empty-icon"><i class="fas fa-users"></i></div>
                                <h5>Belum Ada Petani</h5>
                                <p>Pendaftaran petani di wilayah Anda akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($petanis->hasPages())
        <div class="p-4 border-top">
            <div class="d-flex justify-content-center">
                {{ $petanis->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Verifikasi dan Tolak -->
@foreach($petanis as $item)
    @if(!$item->is_verified)
        <!-- Modal Verifikasi -->
        <div class="modal fade" id="verifyModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                        <h5 class="modal-title text-white"><i class="fas fa-check-circle me-2"></i>Verifikasi Akun</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669);">
                                <span class="text-white" style="font-size: 2rem;">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                            </div>
                            <h5 class="mb-1">{{ $item->name }}</h5>
                            <p class="text-muted mb-0">{{ $item->email }}</p>
                        </div>
                        
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Setelah diverifikasi, petani dapat login dan mengakses semua fitur sistem.
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-4 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('petugas.petani.verify', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tolak -->
        <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none;">
                        <h5 class="modal-title text-white"><i class="fas fa-times-circle me-2"></i>Tolak Pendaftaran</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #ef4444, #dc2626);">
                                <span class="text-white" style="font-size: 2rem;">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                            </div>
                            <h5 class="mb-1">{{ $item->name }}</h5>
                            <p class="text-muted mb-0">{{ $item->email }}</p>
                        </div>
                        
                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian!</strong> Akun ini akan dihapus permanen dari sistem.
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-4 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('petugas.petani.reject', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Tolak & Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#petaniTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}
</script>
@endsection
