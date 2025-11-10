@extends('layouts.app')

@section('title', '✏️ Edit Bantuan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-edit me-2"></i>Edit Bantuan</h4>
                    <p class="mb-0 text-muted">Perbarui informasi bantuan pertanian</p>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="badge-agriculture me-3">
                                    <i class="fas fa-seedling me-1"></i>Jenis: {{ $bantuan->jenis_bantuan }}
                                </span>
                                <span class="badge-quantity">
                                    <i class="fas fa-hashtag me-1"></i>{{ $bantuan->jumlah }} unit
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('daftar.bantuan') }}" class="btn btn-agriculture-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-agriculture">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-agriculture">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('update.bantuan', $bantuan->id) }}" onsubmit="return confirm('Yakin memperbarui data bantuan ini?')">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="jenis_bantuan" class="form-label font-weight-bold">
                                        <i class="fas fa-seedling me-1"></i>Jenis Bantuan
                                    </label>
                                    <select class="form-select form-select-agriculture" id="jenis_bantuan" name="jenis_bantuan" required>
                                        <option value="">🌱 Pilih Jenis Bantuan</option>
                                        <option value="Bibit" {{ $bantuan->jenis_bantuan == 'Bibit' ? 'selected' : '' }}>🌱 Bibit</option>
                                        <option value="Pupuk" {{ $bantuan->jenis_bantuan == 'Pupuk' ? 'selected' : '' }}>🧪 Pupuk</option>
                                        <option value="Pestisida" {{ $bantuan->jenis_bantuan == 'Pestisida' ? 'selected' : '' }}>💧 Pestisida</option>
                                        <option value="Alat" {{ $bantuan->jenis_bantuan == 'Alat' ? 'selected' : '' }}>🔧 Alat</option>
                                        <option value="Lainnya" {{ $bantuan->jenis_bantuan == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                    </select>
                                    @error('jenis_bantuan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="jumlah" class="form-label font-weight-bold">
                                        <i class="fas fa-hashtag me-1"></i>Jumlah
                                    </label>
                                    <input type="number" class="form-control form-control-agriculture" id="jumlah" name="jumlah" value="{{ $bantuan->jumlah }}" min="1" required>
                                    @error('jumlah')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="status" class="form-label font-weight-bold">
                                        <i class="fas fa-info-circle me-1"></i>Status
                                    </label>
                                    <select class="form-select form-select-agriculture" id="status" name="status" required>
                                        <option value="Diproses" {{ $bantuan->status == 'Diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                                        <option value="Dikirim" {{ $bantuan->status == 'Dikirim' ? 'selected' : '' }}>✅ Dikirim</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="tanggal" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar me-1"></i>Tanggal
                                    </label>
                                    <input type="date" class="form-control form-control-agriculture" id="tanggal" name="tanggal" value="{{ $bantuan->tanggal }}" required>
                                    @error('tanggal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="catatan" class="form-label font-weight-bold">
                                        <i class="fas fa-sticky-note me-1"></i>Catatan
                                    </label>
                                    <textarea class="form-control form-control-agriculture" id="catatan" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ $bantuan->catatan }}</textarea>
                                    @error('catatan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('daftar.bantuan') }}" class="btn btn-agriculture-secondary me-2">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-agriculture-primary">
                                    <i class="fas fa-save me-1"></i>Perbarui Bantuan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
