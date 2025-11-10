@extends('layouts.app')

@section('title', '✏️ Edit Laporan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-edit me-2"></i>Edit Laporan Pertanian</h4>
                    <p class="mb-0 text-muted">Perbarui informasi laporan hasil panen dan kemajuan pertanian</p>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="badge-agriculture me-3">
                                    <i class="fas fa-seedling me-1"></i>Jenis: {{ $laporan->jenis_tanaman ?? 'Belum ditentukan' }}
                                </span>
                                <span class="badge-quantity">
                                    <i class="fas fa-weight me-1"></i>{{ $laporan->hasil_panen }} kg
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('daftar.laporan') }}" class="btn btn-agriculture-secondary">
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

                    <form method="POST" action="{{ route('update.laporan', $laporan->id) }}" onsubmit="return confirm('Yakin memperbarui data laporan ini?')">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="deskripsi_kemajuan" class="form-label font-weight-bold">
                                        <i class="fas fa-file-alt me-1"></i>Deskripsi Kemajuan
                                    </label>
                                    <textarea class="form-control form-control-agriculture" id="deskripsi_kemajuan" name="deskripsi_kemajuan" rows="4" placeholder="Jelaskan kemajuan pertanian yang telah dicapai..." required>{{ $laporan->deskripsi_kemajuan }}</textarea>
                                    @error('deskripsi_kemajuan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="hasil_panen" class="form-label font-weight-bold">
                                        <i class="fas fa-weight me-1"></i>Hasil Panen (kg)
                                    </label>
                                    <input type="number" class="form-control form-control-agriculture" id="hasil_panen" name="hasil_panen" value="{{ $laporan->hasil_panen }}" min="0" step="0.01" placeholder="0.00" required>
                                    @error('hasil_panen')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="tanggal" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar me-1"></i>Tanggal Laporan
                                    </label>
                                    <input type="date" class="form-control form-control-agriculture" id="tanggal" name="tanggal" value="{{ $laporan->tanggal }}" required>
                                    @error('tanggal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="jenis_tanaman" class="form-label font-weight-bold">
                                        <i class="fas fa-seedling me-1"></i>Jenis Tanaman
                                    </label>
                                    <select class="form-select form-select-agriculture" id="jenis_tanaman" name="jenis_tanaman">
                                        <option value="">🌱 Pilih Jenis Tanaman</option>
                                        <option value="Padi" {{ $laporan->jenis_tanaman == 'Padi' ? 'selected' : '' }}>🌾 Padi</option>
                                        <option value="Jagung" {{ $laporan->jenis_tanaman == 'Jagung' ? 'selected' : '' }}>🌽 Jagung</option>
                                        <option value="Kedelai" {{ $laporan->jenis_tanaman == 'Kedelai' ? 'selected' : '' }}>🫘 Kedelai</option>
                                        <option value="Ubi" {{ $laporan->jenis_tanaman == 'Ubi' ? 'selected' : '' }}>🥔 Ubi</option>
                                        <option value="Lainnya" {{ $laporan->jenis_tanaman == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                    </select>
                                    @error('jenis_tanaman')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="catatan_laporan" class="form-label font-weight-bold">
                                        <i class="fas fa-sticky-note me-1"></i>Catatan Laporan
                                    </label>
                                    <textarea class="form-control form-control-agriculture" id="catatan_laporan" name="catatan_laporan" rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ $laporan->catatan_laporan }}</textarea>
                                    @error('catatan_laporan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('daftar.laporan') }}" class="btn btn-agriculture-secondary me-2">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-agriculture-primary">
                                    <i class="fas fa-save me-1"></i>Perbarui Laporan
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

    // Auto-resize textarea
    const textarea = document.getElementById('deskripsi_kemajuan');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});
</script>
@endsection
