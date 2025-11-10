@extends('layouts.app')

@section('title', 'Detail Petani - Petugas')

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
                <div>
                    <a href="{{ route('petugas.petani.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($petani->profile_picture)
                        <img src="{{ asset('storage/' . $petani->profile_picture) }}" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;" alt="Profile">
                    @else
                        <div class="mx-auto rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                            <span class="text-white" style="font-size: 4rem;">{{ strtoupper(substr($petani->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    
                    <h5 class="mt-3 mb-1">{{ $petani->name }}</h5>
                    <p class="text-muted mb-3">{{ $petani->email }}</p>
                    
                    @if($petani->is_verified)
                        <span class="badge badge-lg bg-gradient-success">
                            <i class="fas fa-check-circle me-1"></i>Terverifikasi
                        </span>
                        <p class="text-xs text-muted mt-2">
                            Diverifikasi pada {{ $petani->verified_at->format('d/m/Y H:i') }}
                            @if($petani->verifiedBy)
                                <br>oleh {{ $petani->verifiedBy->name }}
                            @endif
                        </p>
                    @else
                        <span class="badge badge-lg bg-gradient-warning">
                            <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                        </span>
                        <p class="text-xs text-muted mt-2">
                            Mendaftar {{ $petani->created_at->diffForHumans() }}
                        </p>
                        
                        <div class="mt-3 d-grid gap-2">
                            <!-- Tombol Verifikasi -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi Akun
                            </button>
                            
                            <!-- Tombol Tolak -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times-circle me-2"></i>Tolak Pendaftaran
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Informasi Petani</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Nama Lengkap</label>
                            <p class="text-sm">{{ $petani->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Email</label>
                            <p class="text-sm">{{ $petani->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Nomor Telepon</label>
                            <p class="text-sm">{{ $petani->telepon ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Role</label>
                            <p class="text-sm">
                                <span class="badge bg-gradient-info">{{ ucfirst($petani->role) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Alamat Desa</label>
                            <p class="text-sm">{{ $petani->alamat_desa ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Alamat Kecamatan</label>
                            <p class="text-sm">{{ $petani->alamat_kecamatan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Pendaftaran</label>
                            <p class="text-sm">{{ $petani->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Luas Lahan</label>
                            <p class="text-sm">{{ $petani->luas_lahan ?? '-' }} Ha</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity History -->
            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6>Riwayat Aktivitas</h6>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-success">
                                <i class="fas fa-user-plus text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Pendaftaran Akun</h6>
                                <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">
                                    {{ $petani->created_at->format('d F Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        @if($petani->is_verified)
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-info">
                                <i class="fas fa-check-circle text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Akun Diverifikasi</h6>
                                <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">
                                    {{ $petani->verified_at->format('d F Y, H:i') }}
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
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success">
                <h5 class="modal-title text-white" id="verifyModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Konfirmasi Verifikasi Akun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    @if($petani->profile_picture)
                        <img src="{{ asset('storage/' . $petani->profile_picture) }}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;" alt="Profile">
                    @else
                        <div class="mx-auto rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-white" style="font-size: 2.5rem;">{{ strtoupper(substr($petani->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $petani->name }}</h5>
                    <p class="text-muted mb-0">{{ $petani->email }}</p>
                </div>
                
                <h6 class="text-center mb-3">Apakah Anda yakin ingin memverifikasi akun petani ini?</h6>
                
                <div class="card border">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <small class="text-muted">Desa</small>
                                <p class="mb-0 fw-bold">{{ $petani->alamat_desa }}</p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">Kecamatan</small>
                                <p class="mb-0 fw-bold">{{ $petani->alamat_kecamatan ?? '-' }}</p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">Telepon</small>
                                <p class="mb-0 fw-bold">{{ $petani->telepon ?? '-' }}</p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">Terdaftar</small>
                                <p class="mb-0 fw-bold">{{ $petani->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-success mt-3 mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Setelah diverifikasi, <strong>{{ $petani->name }}</strong> akan mendapat notifikasi dan dapat login untuk mengakses sistem.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form action="{{ route('petugas.petani.verify', $petani->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Ya, Verifikasi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white" id="rejectModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Penolakan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    @if($petani->profile_picture)
                        <img src="{{ asset('storage/' . $petani->profile_picture) }}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;" alt="Profile">
                    @else
                        <div class="mx-auto rounded-circle bg-gradient-danger d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-white" style="font-size: 2.5rem;">{{ strtoupper(substr($petani->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h5 class="mb-1 text-danger">{{ $petani->name }}</h5>
                    <p class="text-muted mb-0">{{ $petani->email }}</p>
                </div>
                
                <h6 class="text-center mb-3 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Yakin ingin menolak pendaftaran ini?
                </h6>
                
                <div class="alert alert-danger mb-0">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle me-3 mt-1" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong class="d-block mb-2">PERHATIAN!</strong>
                            <ul class="mb-0 ps-3">
                                <li>Akun <strong>{{ $petani->name }}</strong> akan dihapus secara permanen</li>
                                <li>Data tidak dapat dipulihkan kembali</li>
                                <li>Petani harus mendaftar ulang jika ingin masuk sistem</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-2"></i>Batal, Kembali
                </button>
                <form action="{{ route('petugas.petani.reject', $petani->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Ya, Tolak & Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
