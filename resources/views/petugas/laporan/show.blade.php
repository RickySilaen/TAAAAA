@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Detail Laporan</h6>
                        <a href="{{ route('petugas.laporan.index') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Petani Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <img src="{{ $laporan->user->profile_picture ? asset('storage/' . $laporan->user->profile_picture) : asset('assets/img/default-avatar.png') }}" class="avatar avatar-lg me-3" alt="user image">
                                <div>
                                    <h6 class="mb-0">{{ $laporan->user->name }}</h6>
                                    <p class="text-sm text-secondary mb-0">{{ $laporan->user->alamat_desa }}</p>
                                    <p class="text-sm text-secondary mb-0">Luas Lahan: {{ $laporan->user->luas_lahan }} hektar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge badge-lg bg-{{ $laporan->status_verifikasi == 'disetujui' ? 'success' : ($laporan->status_verifikasi == 'ditolak' ? 'danger' : 'warning') }}">
                                {{ $laporan->status_verifikasi ? ucfirst($laporan->status_verifikasi) : 'Belum Diverifikasi' }}
                            </span>
                        </div>
                    </div>

                    <!-- Laporan Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Laporan</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hasil Panen</label>
                                <p class="mb-0"><strong>{{ number_format($laporan->hasil_panen) }} kg</strong></p>
                            </div>
                        </div>
                    </div>

                    @if($laporan->jenis_tanaman)
                    <div class="mb-3">
                        <label class="form-label">Jenis Tanaman</label>
                        <p class="mb-0">{{ $laporan->jenis_tanaman }}</p>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Kemajuan</label>
                        <p class="mb-0">{{ $laporan->deskripsi_kemajuan }}</p>
                    </div>

                    @if($laporan->catatan_laporan)
                    <div class="mb-3">
                        <label class="form-label">Catatan Laporan</label>
                        <p class="mb-0">{{ $laporan->catatan_laporan }}</p>
                    </div>
                    @endif

                    @if($laporan->status_verifikasi)
                    <div class="mb-3">
                        <label class="form-label">Catatan Petugas</label>
                        <p class="mb-0">{{ $laporan->catatan_petugas }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Verification Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Verifikasi Laporan</h6>
                </div>
                <div class="card-body p-3">
                    @if(!$laporan->status_verifikasi)
                    <form action="{{ route('petugas.laporan.verify', $laporan->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Petugas</label>
                            <textarea name="catatan_petugas" class="form-control" rows="4" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check"></i> Verifikasi Laporan
                        </button>
                    </form>
                    @else
                    <div class="text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        <h6 class="mt-2">Laporan Sudah Diverifikasi</h6>
                        <p class="text-sm text-muted">Status: {{ ucfirst($laporan->status_verifikasi) }}</p>
                        @if($laporan->verified_at)
                        <p class="text-xs text-muted">Diverifikasi pada: {{ $laporan->verified_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
