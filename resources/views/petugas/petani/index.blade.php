@extends('layouts.app')

@section('title', 'Verifikasi Petani - Petugas')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-0">
                        <i class="fas fa-user-check me-2"></i>Verifikasi Petani
                    </h4>
                    <p class="text-white-50 mb-0">Kelola dan verifikasi pendaftaran petani di daerah Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center rounded-circle me-3">
                            <i class="fas fa-clock text-lg opacity-10"></i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Menunggu Verifikasi</p>
                            <h5 class="font-weight-bolder mb-0">{{ $petani->where('is_verified', false)->count() }} Petani</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle me-3">
                            <i class="fas fa-check-double text-lg opacity-10"></i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Sudah Terverifikasi</p>
                            <h5 class="font-weight-bolder mb-0">{{ $petani->where('is_verified', true)->count() }} Petani</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Petani Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Daftar Petani - {{ auth()->user()->alamat_desa }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Petani</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telepon</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Desa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Terdaftar</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petani as $index => $item)
                                <tr class="{{ !$item->is_verified ? 'table-warning' : '' }}">
                                    <td>
                                        <div class="px-3 py-1">
                                            <p class="text-xs font-weight-bold mb-0">{{ $petani->firstItem() + $index }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($item->profile_picture)
                                                    <img src="{{ asset('storage/' . $item->profile_picture) }}" class="avatar avatar-sm me-3" alt="user">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-primary">
                                                        <span class="text-white text-xs">{{ strtoupper(substr($item->name, 0, 2)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                                @if(!$item->is_verified)
                                                    <span class="badge badge-sm bg-warning">Baru</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->telepon ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->alamat_desa }}</p>
                                    </td>
                                    <td>
                                        @if($item->is_verified)
                                            <span class="badge badge-sm bg-gradient-success">
                                                <i class="fas fa-check me-1"></i>Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-warning">
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('petugas.petani.show', $item->id) }}" class="btn btn-link text-info text-gradient px-2 mb-0" title="Detail">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            @if(!$item->is_verified)
                                                <!-- Tombol Verifikasi -->
                                                <button type="button" class="btn btn-link text-success text-gradient px-2 mb-0" 
                                                        title="Verifikasi Akun" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#verifyModal{{ $item->id }}">
                                                    <i class="fas fa-check-circle text-sm"></i>
                                                </button>
                                                
                                                <!-- Tombol Tolak -->
                                                <button type="button" class="btn btn-link text-danger text-gradient px-2 mb-0" 
                                                        title="Tolak Pendaftaran" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rejectModal{{ $item->id }}">
                                                    <i class="fas fa-times-circle text-sm"></i>
                                                </button>
                                            @else
                                                <span class="badge badge-sm bg-gradient-success">
                                                    <i class="fas fa-check me-1"></i>Sudah Diverifikasi
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada pendaftaran petani</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($petani->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $petani->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi dan Tolak untuk setiap petani -->
@foreach($petani as $item)
    @if(!$item->is_verified)
        <!-- Modal Verifikasi -->
        <div class="modal fade" id="verifyModal{{ $item->id }}" tabindex="-1" aria-labelledby="verifyModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
                        <h5 class="modal-title text-white" id="verifyModalLabel{{ $item->id }}">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Verifikasi Akun
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            @if($item->profile_picture)
                                <img src="{{ asset('storage/' . $item->profile_picture) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Profile">
                            @else
                                <div class="mx-auto rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="text-white" style="font-size: 2rem;">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <h6 class="text-center mb-3">Apakah Anda yakin ingin memverifikasi akun petani ini?</h6>
                        
                        <div class="card border">
                            <div class="card-body p-3">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td class="text-sm"><strong>Nama</strong></td>
                                        <td class="text-sm">{{ $item->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Email</strong></td>
                                        <td class="text-sm">{{ $item->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Telepon</strong></td>
                                        <td class="text-sm">{{ $item->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Desa</strong></td>
                                        <td class="text-sm">{{ $item->alamat_desa }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Kecamatan</strong></td>
                                        <td class="text-sm">{{ $item->alamat_kecamatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Terdaftar</strong></td>
                                        <td class="text-sm">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Setelah diverifikasi, petani <strong>{{ $item->name }}</strong> akan dapat login ke sistem dan mengakses semua fitur.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <form action="{{ route('petugas.petani.verify', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Ya, Verifikasi Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tolak -->
        <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title text-white" id="rejectModalLabel{{ $item->id }}">
                            <i class="fas fa-times-circle me-2"></i>Konfirmasi Penolakan Pendaftaran
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            @if($item->profile_picture)
                                <img src="{{ asset('storage/' . $item->profile_picture) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Profile">
                            @else
                                <div class="mx-auto rounded-circle bg-gradient-danger d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="text-white" style="font-size: 2rem;">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <h6 class="text-center mb-3 text-danger">Apakah Anda yakin ingin menolak pendaftaran petani ini?</h6>
                        
                        <div class="card border border-danger">
                            <div class="card-body p-3">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td class="text-sm"><strong>Nama</strong></td>
                                        <td class="text-sm">{{ $item->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Email</strong></td>
                                        <td class="text-sm">{{ $item->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm"><strong>Desa</strong></td>
                                        <td class="text-sm">{{ $item->alamat_desa }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <small><strong>PERHATIAN:</strong> Akun petani <strong>{{ $item->name }}</strong> akan dihapus secara permanen dari sistem dan tidak dapat dipulihkan!</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <form action="{{ route('petugas.petani.reject', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Ya, Tolak & Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<style>
.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}
</style>
@endsection
