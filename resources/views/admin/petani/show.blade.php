@extends('layouts.app')

@section('title', 'Detail Petani')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-0">
                        <i class="fas fa-user me-2"></i>Detail Petani
                    </h4>
                    <p class="text-white-50 mb-0">Informasi lengkap petani</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.petani.edit', $petani->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                    <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-circle-large bg-success text-white mx-auto mb-3">
                        {{ strtoupper(substr($petani->name, 0, 2)) }}
                    </div>
                    <h4 class="mb-1">{{ $petani->name }}</h4>
                    <p class="text-muted mb-3">Petani</p>
                    
                    @if($petani->is_verified)
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check-circle"></i> Terverifikasi
                        </span>
                    @else
                        <span class="badge bg-warning text-dark mb-3">
                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                        </span>
                    @endif
                    
                    <hr>
                    
                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <strong>Email:</strong><br>
                            <span class="ms-4">{{ $petani->email }}</span>
                        </p>
                        
                        @if($petani->telepon)
                        <p class="mb-2">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <strong>Telepon:</strong><br>
                            <span class="ms-4">{{ $petani->telepon }}</span>
                        </p>
                        @endif
                        
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <strong>Alamat:</strong><br>
                            <span class="ms-4">{{ $petani->alamat_desa }}</span>
                            @if($petani->alamat_kecamatan)
                                <br><span class="ms-4 text-muted">Kec. {{ $petani->alamat_kecamatan }}</span>
                            @endif
                        </p>
                        
                        <p class="mb-2">
                            <i class="fas fa-calendar text-muted me-2"></i>
                            <strong>Bergabung:</strong><br>
                            <span class="ms-4">{{ $petani->created_at->format('d M Y, H:i') }}</span>
                        </p>
                        
                        @if($petani->is_verified && $petani->verified_at)
                        <p class="mb-0">
                            <i class="fas fa-check-circle text-muted me-2"></i>
                            <strong>Diverifikasi:</strong><br>
                            <span class="ms-4">{{ $petani->verified_at->format('d M Y, H:i') }}</span>
                            @if($petani->verifiedBy)
                                <br><span class="ms-4 text-muted">oleh {{ $petani->verifiedBy->name }}</span>
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics & Activities -->
        <div class="col-lg-8">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Laporan</p>
                                    <h3 class="mb-0">{{ $total_laporan }}</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-file-alt fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Bantuan</p>
                                    <h3 class="mb-0">{{ $total_bantuan }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-hand-holding-heart fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Hasil Panen</p>
                                    <h3 class="mb-0">{{ number_format($total_hasil_panen, 0) }} kg</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-tractor fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>Laporan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    @if($petani->laporans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Tanaman</th>
                                        <th>Hasil Panen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($petani->laporans->take(5) as $laporan)
                                        <tr>
                                            <td>{{ $laporan->tanggal }}</td>
                                            <td>{{ $laporan->jenis_tanaman }}</td>
                                            <td>{{ $laporan->hasil_panen }} kg</td>
                                            <td>
                                                <a href="{{ route('api.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($petani->laporans->count() > 5)
                            <p class="text-muted text-center mb-0 mt-2">
                                <small>Menampilkan 5 dari {{ $petani->laporans->count() }} laporan</small>
                            </p>
                        @endif
                    @else
                        <p class="text-muted text-center mb-0">Belum ada laporan</p>
                    @endif
                </div>
            </div>

            <!-- Recent Bantuan -->
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-hand-holding-heart me-2"></i>Bantuan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    @if($petani->bantuans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Jenis Bantuan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($petani->bantuans->take(5) as $bantuan)
                                        <tr>
                                            <td>{{ $bantuan->jenis_bantuan }}</td>
                                            <td>{{ $bantuan->jumlah }} {{ $bantuan->satuan }}</td>
                                            <td>
                                                @if($bantuan->status == 'dikirim')
                                                    <span class="badge bg-success">Dikirim</span>
                                                @elseif($bantuan->status == 'diproses')
                                                    <span class="badge bg-warning">Diproses</span>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('api.bantuan.show', $bantuan->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($petani->bantuans->count() > 5)
                            <p class="text-muted text-center mb-0 mt-2">
                                <small>Menampilkan 5 dari {{ $petani->bantuans->count() }} bantuan</small>
                            </p>
                        @endif
                    @else
                        <p class="text-muted text-center mb-0">Belum ada bantuan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
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
                    <strong>{{ $petani->name }}</strong><br>
                    <small>{{ $petani->email }}</small>
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
                <form action="{{ route('admin.petani.destroy', $petani->id) }}" method="POST" class="d-inline">
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

<style>
.avatar-circle-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 36px;
}
</style>
@endsection
