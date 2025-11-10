@extends('layouts.app')

@section('title', 'Input Data - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary shadow-primary border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="text-white mb-2">
                                <i class="fas fa-database me-3"></i>Input Data Terpadu
                            </h2>
                            <p class="text-white opacity-8 mb-0">
                                Kelola data bantuan dan laporan pertanian dalam satu tempat. Pilih jenis data yang ingin Anda input.
                            </p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <i class="fas fa-chart-pie fa-5x text-white opacity-7"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                <i class="fas fa-plus-circle text-white text-lg opacity-10"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">Form Input Data</h5>
                                <p class="text-sm text-muted mb-0">Pilih jenis data yang akan diinput</p>
                            </div>
                        </div>
                        <div class="btn-group btn-group-lg" role="group">
                            <button type="button" class="btn btn-outline-primary tab-button active px-4 py-2" id="tabBantuan" data-tab="bantuan">
                                <i class="fas fa-hand-holding-heart me-2"></i>
                                <span class="d-none d-md-inline">Bantuan</span>
                            </button>
                            <button type="button" class="btn btn-outline-success tab-button px-4 py-2" id="tabLaporan" data-tab="laporan">
                                <i class="fas fa-file-alt me-2"></i>
                                <span class="d-none d-md-inline">Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form Input Bantuan -->
                    <div id="formBantuan" class="form-section">
                        <form action="{{ route('store.bantuan') }}" method="POST" id="bantuanForm" novalidate>
                            @csrf
                            <!-- Informasi Bantuan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-primary border-opacity-25 bg-light">
                                        <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
                                            <h6 class="mb-0 text-primary font-weight-bold">
                                                <i class="fas fa-hand-holding-heart me-2"></i>Informasi Bantuan
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="jenis_bantuan" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-seedling text-primary me-1"></i>Jenis Bantuan <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select form-select-lg border-primary border-opacity-25" id="jenis_bantuan" name="jenis_bantuan" required>
                                                            <option value="">Pilih Jenis Bantuan</option>
                                                            <option value="Bibit" {{ old('jenis_bantuan') == 'Bibit' ? 'selected' : '' }}>Bibit</option>
                                                            <option value="Pupuk" {{ old('jenis_bantuan') == 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                                                            <option value="Pestisida" {{ old('jenis_bantuan') == 'Pestisida' ? 'selected' : '' }}>Pestisida</option>
                                                            <option value="Alat" {{ old('jenis_bantuan') == 'Alat' ? 'selected' : '' }}>Alat</option>
                                                        </select>
                                                        @error('jenis_bantuan')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="jumlah" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-hashtag text-primary me-1"></i>Jumlah <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="number" class="form-control border-primary border-opacity-25" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="0" min="1" required>
                                                            <span class="input-group-text bg-primary text-white border-primary">
                                                                <i class="fas fa-boxes"></i> unit
                                                            </span>
                                                        </div>
                                                        @error('jumlah')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status dan Tanggal -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-info border-opacity-25 bg-light">
                                        <div class="card-header bg-info bg-opacity-10 border-bottom border-info border-opacity-25">
                                            <h6 class="mb-0 text-info font-weight-bold">
                                                <i class="fas fa-info-circle me-2"></i>Status dan Tanggal
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="status" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-tasks text-info me-1"></i>Status <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select form-select-lg border-info border-opacity-25" id="status" name="status" required>
                                                            <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                            <option value="Dikirim" {{ old('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="tanggal_bantuan" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-calendar text-info me-1"></i>Tanggal <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="date" class="form-control form-control-lg border-info border-opacity-25" id="tanggal_bantuan" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                        @error('tanggal')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-warning border-opacity-25 bg-light">
                                        <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning border-opacity-25">
                                            <h6 class="mb-0 text-warning font-weight-bold">
                                                <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan (Opsional)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="catatan_laporan" class="form-label font-weight-bold text-dark">
                                                    <i class="fas fa-comment text-warning me-1"></i>Catatan Tambahan
                                                </label>
                                                <textarea class="form-control border-warning border-opacity-25" id="catatan_laporan" name="catatan_laporan" rows="3" placeholder="Tambahkan catatan tambahan jika ada...">{{ old('catatan_laporan') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-secondary btn-lg px-4" onclick="resetForm('bantuanForm')">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-lg px-4" onclick="previewBantuan()">
                                        <i class="fas fa-eye me-2"></i>Preview
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-save me-2"></i>Simpan Bantuan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Form Input Laporan -->
                    <div id="formLaporan" class="form-section" style="display: none;">
                        <form action="{{ route('store.laporan') }}" method="POST" id="laporanForm" novalidate>
                            @csrf
                            <!-- Informasi Dasar -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-success border-opacity-25 bg-light">
                                        <div class="card-header bg-success bg-opacity-10 border-bottom border-success border-opacity-25">
                                            <h6 class="mb-0 text-success font-weight-bold">
                                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="jenis_tanaman" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-leaf text-success me-1"></i>Jenis Tanaman <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select form-select-lg border-success border-opacity-25" id="jenis_tanaman" name="jenis_tanaman" required>
                                                            <option value="">Pilih Jenis Tanaman</option>
                                                            <option value="Padi" {{ old('jenis_tanaman') == 'Padi' ? 'selected' : '' }}>Padi</option>
                                                            <option value="Jagung" {{ old('jenis_tanaman') == 'Jagung' ? 'selected' : '' }}>Jagung</option>
                                                            <option value="Kedelai" {{ old('jenis_tanaman') == 'Kedelai' ? 'selected' : '' }}>Kedelai</option>
                                                            <option value="Ubi" {{ old('jenis_tanaman') == 'Ubi' ? 'selected' : '' }}>Ubi</option>
                                                            <option value="Cabe" {{ old('jenis_tanaman') == 'Cabe' ? 'selected' : '' }}>Cabe</option>
                                                            <option value="Tomat" {{ old('jenis_tanaman') == 'Tomat' ? 'selected' : '' }}>Tomat</option>
                                                            <option value="Lainnya" {{ old('jenis_tanaman') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                        </select>
                                                        @error('jenis_tanaman')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="tanggal" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-calendar text-success me-1"></i>Tanggal Laporan <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="date" class="form-control form-control-lg border-success border-opacity-25" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                        @error('tanggal')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Panen -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-primary border-opacity-25 bg-light">
                                        <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
                                            <h6 class="mb-0 text-primary font-weight-bold">
                                                <i class="fas fa-chart-line me-2"></i>Data Hasil Panen
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="hasil_panen" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-weight text-primary me-1"></i>Hasil Panen (kg) <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="number" class="form-control border-primary border-opacity-25" id="hasil_panen" name="hasil_panen" value="{{ old('hasil_panen') }}" placeholder="0.00" min="0" step="0.01" required>
                                                            <span class="input-group-text bg-primary text-white border-primary">
                                                                <i class="fas fa-weight-hanging"></i> kg
                                                            </span>
                                                        </div>
                                                        @error('hasil_panen')
                                                            <div class="text-danger small mt-1">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="luas_panen" class="form-label font-weight-bold text-dark">
                                                            <i class="fas fa-ruler-combined text-primary me-1"></i>Luas Area Dipanen (ha)
                                                        </label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="number" class="form-control border-primary border-opacity-25" id="luas_panen" name="luas_panen" value="{{ old('luas_panen') }}" placeholder="0.00" min="0" step="0.01">
                                                            <span class="input-group-text bg-primary text-white border-primary">
                                                                <i class="fas fa-map-marked-alt"></i> ha
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi Kemajuan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-info border-opacity-25 bg-light">
                                        <div class="card-header bg-info bg-opacity-10 border-bottom border-info border-opacity-25">
                                            <h6 class="mb-0 text-info font-weight-bold">
                                                <i class="fas fa-tasks me-2"></i>Deskripsi Kemajuan Pertanian
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="deskripsi_kemajuan" class="form-label font-weight-bold text-dark">
                                                    <i class="fas fa-edit text-info me-1"></i>Deskripsi Kemajuan <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control border-info border-opacity-25" id="deskripsi_kemajuan" name="deskripsi_kemajuan" rows="5" placeholder="Jelaskan kondisi tanaman, perawatan, dan rencana..." required>{{ old('deskripsi_kemajuan') }}</textarea>
                                                @error('deskripsi_kemajuan')
                                                    <div class="text-danger small mt-1">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border border-warning border-opacity-25 bg-light">
                                        <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning border-opacity-25">
                                            <h6 class="mb-0 text-warning font-weight-bold">
                                                <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan (Opsional)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="catatan" class="form-label font-weight-bold text-dark">
                                                    <i class="fas fa-comment text-warning me-1"></i>Catatan Tambahan
                                                </label>
                                                <textarea class="form-control border-warning border-opacity-25" id="catatan" name="catatan" rows="3" placeholder="Cuaca, masalah, saran...">{{ old('catatan') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-secondary btn-lg px-4" onclick="resetForm('laporanForm')">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-lg px-4" onclick="previewLaporan()">
                                        <i class="fas fa-eye me-2"></i>Preview
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg px-5">
                                        <i class="fas fa-save me-2"></i>Simpan Laporan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // === TAB SWITCHING DENGAN DISABLED FIELD ===
    function switchTab(type) {
        const bantuanForm = document.getElementById('formBantuan');
        const laporanForm = document.getElementById('formLaporan');
        const activeForm = type === 'bantuan' ? bantuanForm : laporanForm;
        const inactiveForm = type === 'bantuan' ? laporanForm : bantuanForm;

        activeForm.querySelectorAll('input, select, textarea').forEach(f => f.disabled = false);
        inactiveForm.querySelectorAll('input, select, textarea').forEach(f => f.disabled = true);

        bantuanForm.style.display = type === 'bantuan' ? 'block' : 'none';
        laporanForm.style.display = type === 'laporan' ? 'block' : 'none';

        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === type);
        });
    }

    // === RESET FORM ===
    function resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            showAlert('Form berhasil direset', 'success');
        }
    }

    // === PREVIEW BANTUAN ===
    function previewBantuan() {
        const jenis = document.getElementById('jenis_bantuan').value;
        const jumlah = document.getElementById('jumlah').value;
        const status = document.getElementById('status').value;
        const tanggal = document.getElementById('tanggal_bantuan').value;
        const catatan = document.getElementById('catatan_laporan').value;

        if (!jenis || !jumlah || !status || !tanggal) {
            showAlert('Lengkapi field wajib untuk preview!', 'warning');
            return;
        }

        const content = `
            <div class="text-center mb-4">
                <i class="fas fa-hand-holding-heart text-primary" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Preview Bantuan</h4>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Jenis:</strong> ${jenis}</div>
                <div class="col-md-6"><strong>Jumlah:</strong> ${jumlah} unit</div>
                <div class="col-md-6"><strong>Status:</strong> ${status}</div>
                <div class="col-md-6"><strong>Tanggal:</strong> ${new Date(tanggal).toLocaleDateString('id-ID')}</div>
                ${catatan ? `<div class="col-12"><strong>Catatan:</strong> ${catatan}</div>` : ''}
            </div>
        `;
        showModal('Preview Bantuan', content);
    }

    // === PREVIEW LAPORAN ===
    function previewLaporan() {
        const jenis = document.getElementById('jenis_tanaman').value;
        const hasil = document.getElementById('hasil_panen').value;
        const luas = document.getElementById('luas_panen').value;
        const tanggal = document.getElementById('tanggal').value;
        const deskripsi = document.getElementById('deskripsi_kemajuan').value;
        const catatan = document.getElementById('catatan').value;

        if (!jenis || !hasil || !tanggal || !deskripsi) {
            showAlert('Lengkapi field wajib untuk preview!', 'warning');
            return;
        }

        const content = `
            <div class="text-center mb-4">
                <i class="fas fa-file-alt text-success" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Preview Laporan</h4>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Tanaman:</strong> ${jenis}</div>
                <div class="col-md-6"><strong>Hasil:</strong> ${hasil} kg</div>
                ${luas ? `<div class="col-md-6"><strong>Luas:</strong> ${luas} ha</div>` : ''}
                <div class="col-md-6"><strong>Tanggal:</strong> ${new Date(tanggal).toLocaleDateString('id-ID')}</div>
                <div class="col-12"><strong>Deskripsi:</strong> <p>${deskripsi}</p></div>
                ${catatan ? `<div class="col-12"><strong>Catatan:</strong> ${catatan}</div>` : ''}
            </div>
        `;
        showModal('Preview Laporan', content);
    }

    // === MODAL & ALERT ===
    function showModal(title, content) {
        const modalHtml = `
            <div class="modal fade" id="previewModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title"><i class="fas fa-eye me-2"></i>${title}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">${content}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
        document.getElementById('previewModal').addEventListener('hidden.bs.modal', () => this.remove());
    }

    function showAlert(message, type = 'info') {
        const alert = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top:20px; right:20px; z-index:9999;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alert);
        setTimeout(() => document.querySelector('.alert.position-fixed')?.remove(), 5000);
    }

    // === LOG ERROR KE LARAVEL.LOG ===
    function logFormError(formId, errors, inputData) {
        // Remove the route call since it's not defined
        console.error('Form Validation Error:', {
            form: formId,
            errors: errors,
            input: inputData,
            url: window.location.href,
            user_agent: navigator.userAgent
        });
    }

    // === DOM LOADED ===
    document.addEventListener('DOMContentLoaded', function () {
        // Tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', () => switchTab(btn.dataset.tab));
        });

        // Submit handler + logging
        ['bantuanForm', 'laporanForm'].forEach(id => {
            const form = document.getElementById(id);
            if (form) {
                form.addEventListener('submit', function (e) {
                    // Re-enable all fields
                    this.querySelectorAll('input, select, textarea').forEach(f => f.disabled = false);

                    // Log validation errors
                    const errors = Array.from(this.querySelectorAll('.text-danger')).map(el => el.textContent.trim());
                    if (errors.length > 0) {
                        const formData = new FormData(this);
                        const input = Object.fromEntries(formData);
                        logFormError(id, errors, input);
                    }
                });
            }
        });

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection