@extends('layouts.app')

@section('title', 'Detail Bantuan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Detail Bantuan</h6>
                        <a href="{{ route('petugas.bantuan.index') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Petani Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <img src="{{ $bantuan->user->profile_picture ? asset('storage/' . $bantuan->user->profile_picture) : asset('assets/img/default-avatar.png') }}" class="avatar avatar-lg me-3" alt="user image">
                                <div>
                                    <h6 class="mb-0">{{ $bantuan->user->name }}</h6>
                                    <p class="text-sm text-secondary mb-0">{{ $bantuan->user->alamat_desa }}</p>
                                    <p class="text-sm text-secondary mb-0">Luas Lahan: {{ $bantuan->user->luas_lahan }} hektar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge badge-lg bg-{{ $bantuan->status == 'Dikirim' ? 'success' : ($bantuan->status == 'Diproses' ? 'warning' : 'danger') }}">
                                {{ $bantuan->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Bantuan Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pengajuan</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Bantuan</label>
                                <p class="mb-0"><strong>{{ $bantuan->jenis_bantuan }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <p class="mb-0">{{ $bantuan->jumlah }}</p>
                    </div>

                    @if($bantuan->catatan)
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <p class="mb-0">{{ $bantuan->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Update Status Bantuan</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('petugas.bantuan.update-status', $bantuan->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Bantuan</label>
                            <select name="status" class="form-control" required>
                                <option value="Diproses" {{ $bantuan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Dikirim" {{ $bantuan->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="Ditolak" {{ $bantuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan jika diperlukan...">{{ $bantuan->catatan }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
