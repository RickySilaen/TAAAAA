x@extends('layouts.app')

@section('title', '➕ Input Data Bantuan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-hand-holding-heart me-2"></i>Input Data Bantuan</h4>
                    <p class="mb-0 text-muted">Tambahkan data bantuan pertanian baru ke dalam sistem</p>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="badge-agriculture me-3">
                                    <i class="fas fa-plus-circle me-1"></i>Form Input Bantuan
                                </span>
                                <span class="badge-agriculture-success">
                                    <i class="fas fa-info-circle me-1"></i>Isi semua field yang wajib
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('daftar.bantuan') }}" class="btn btn-agriculture-secondary">
                                <i class="fas fa-list me-1"></i>Lihat Daftar Bantuan
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

                    <form method="POST" action="{{ route('store.bantuan') }}" onsubmit="return confirm('Yakin menyimpan data bantuan ini?')">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="jenis_bantuan" class="form-label font-weight-bold">
                                        <i class="fas fa-seedling me-1"></i>Jenis Bantuan
                                    </label>
                                    <select class="form-select form-select-agriculture" id="jenis_bantuan" name="jenis_bantuan" required>
                                        <option value="">🌱 Pilih Jenis Bantuan</option>
                                        <option value="Bibit" {{ old('jenis_bantuan') == 'Bibit' ? 'selected' : '' }}>🌱 Bibit</option>
                                        <option value="Pupuk" {{ old('jenis_bantuan') == 'Pupuk' ? 'selected' : '' }}>🧪 Pupuk</option>
                                        <option value="Pestisida" {{ old('jenis_bantuan') == 'Pestisida' ? 'selected' : '' }}>💧 Pestisida</option>
                                        <option value="Alat" {{ old('jenis_bantuan') == 'Alat' ? 'selected' : '' }}>🔧 Alat</option>
                                        <option value="Lainnya" {{ old('jenis_bantuan') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                    </select>
                                    @error('jenis_bantuan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="jumlah" class="form-label font-weight-bold">
                                        <i class="fas fa-hashtag me-1"></i>Jumlah
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-agriculture" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="0" min="1" required>
                                        <span class="input-group-text">unit</span>
                                    </div>
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
                                        <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                                        <option value="Dikirim" {{ old('status') == 'Dikirim' ? 'selected' : '' }}>✅ Dikirim</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="tanggal" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar me-1"></i>Tanggal
                                    </label>
                                    <input type="date" class="form-control form-control-agriculture" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="catatan" class="form-label font-weight-bold">
                                        <i class="fas fa-sticky-note me-1"></i>Catatan
                                    </label>
                                    <textarea class="form-control form-control-agriculture" id="catatan" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-agriculture-secondary me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-agriculture-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Bantuan
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
    const textarea = document.getElementById('catatan');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});

function resetForm() {
    document.getElementById('jenis_bantuan').value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('status').value = 'Diproses';
    document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
    document.getElementById('catatan').value = '';
    document.getElementById('catatan').style.height = 'auto';
}
</script>
@endsection
