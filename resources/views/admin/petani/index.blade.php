@extends('layouts.app')

@section('title', 'Kelola Petani')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-users text-success"></i> Kelola Petani
            </h2>
            <p class="text-muted">Manajemen akun petani dalam sistem</p>
        </div>
        <a href="{{ route('admin.petani.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Tambah Petani Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Petani</p>
                            <h3 class="mb-0">{{ $petani->total() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Terverifikasi</p>
                            <h3 class="mb-0">{{ $petani->where('is_verified', true)->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-check fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Belum Verifikasi</p>
                            <h3 class="mb-0">{{ $petani->where('is_verified', false)->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Bergabung Bulan Ini</p>
                            <h3 class="mb-0">{{ \App\Models\User::where('role', 'petani')->whereMonth('created_at', now()->month)->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-check fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Petani Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Daftar Petani
            </h5>
        </div>
        <div class="card-body p-0">
            @if($petani->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama Petani</th>
                                <th width="18%">Email</th>
                                <th width="12%">Telepon</th>
                                <th width="15%">Alamat</th>
                                <th width="10%">Status</th>
                                <th width="10%">Bergabung</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petani as $index => $p)
                                <tr>
                                    <td>{{ $petani->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-success text-white me-2">
                                                {{ strtoupper(substr($p->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $p->name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope text-muted"></i>
                                        {{ $p->email }}
                                    </td>
                                    <td>
                                        @if($p->telepon)
                                            <i class="fas fa-phone text-muted"></i>
                                            {{ $p->telepon }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @if($p->alamat_kecamatan)
                                                <i class="fas fa-map-marker-alt text-success"></i>
                                                <strong>{{ $p->alamat_kecamatan }}</strong>
                                            @endif
                                        </div>
                                        @if($p->alamat_desa)
                                            <small class="text-muted">{{ $p->alamat_desa }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->is_verified)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $p->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.petani.show', $p->id) }}" 
                                               class="btn btn-sm btn-info"
                                               data-bs-toggle="tooltip" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.petani.edit', $p->id) }}" 
                                               class="btn btn-sm btn-warning"
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $p->id }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus petani:</p>
                                                <div class="alert alert-warning">
                                                    <strong>{{ $p->name }}</strong><br>
                                                    <small>{{ $p->email }}</small>
                                                </div>
                                                <p class="text-danger mb-0">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Peringatan:</strong> 
                                                    Petani yang memiliki data laporan atau bantuan tidak dapat dihapus. 
                                                    Aksi ini tidak dapat dibatalkan!
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i> Batal
                                                </button>
                                                <form action="{{ route('admin.petani.destroy', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i> Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $petani->firstItem() }} - {{ $petani->lastItem() }} 
                            dari {{ $petani->total() }} petani
                        </div>
                        {{ $petani->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada petani terdaftar</h5>
                    <p class="text-muted">Klik tombol "Tambah Petani Baru" untuk mendaftarkan petani</p>
                    <a href="{{ route('admin.petani.create') }}" class="btn btn-success mt-3">
                        <i class="fas fa-plus-circle"></i> Tambah Petani
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
@endsection
