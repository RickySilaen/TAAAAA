@extends('layouts.app')

@section('title', 'Input Laporan Hasil Panen - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-success shadow-success border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="text-white mb-2">
                                <i class="fas fa-file-alt me-3"></i>Input Laporan Hasil Panen
                            </h2>
                            <p class="text-white opacity-8 mb-0">
                                Laporkan hasil panen dan kemajuan pertanian Anda hari ini. Data ini akan membantu monitoring produktivitas lahan Anda.
                            </p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <img src="{{ asset('assets/img/illustrations/report.svg') }}" alt="Laporan" class="img-fluid" style="max-height: 120px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                            <i class="fas fa-seedling text-white text-lg opacity-10"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold">Form Laporan Hasil Panen</h5>
                            <p class="text-sm text-muted mb-0">Isi data laporan dengan lengkap dan akurat</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Berhasil!</strong> {{ session('success') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle text-danger me-3"></i>
                                <div>
                                    <strong>Terjadi Kesalahan!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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
                                                        <option value="Padi" {{ old('jenis_tanaman') == 'Padi' ? 'selected' : '' }}>🌾 Padi</option>
                                                        <option value="Jagung" {{ old('jenis_tanaman') == 'Jagung' ? 'selected' : '' }}>🌽 Jagung</option>
                                                        <option value="Kedelai" {{ old('jenis_tanaman') == 'Kedelai' ? 'selected' : '' }}>🫘 Kedelai</option>
                                                        <option value="Ubi" {{ old('jenis_tanaman') == 'Ubi' ? 'selected' : '' }}>🥔 Ubi</option>
                                                        <option value="Cabe" {{ old('jenis_tanaman') == 'Cabe' ? 'selected' : '' }}>🌶️ Cabe</option>
                                                        <option value="Tomat" {{ old('jenis_tanaman') == 'Tomat' ? 'selected' : '' }}>🍅 Tomat</option>
                                                        <option value="Lainnya" {{ old('jenis_tanaman') == 'Lainnya' ? 'selected' : '' }}>🌱 Lainnya</option>
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
                                                    <div class="form-text text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>Masukkan berat panen dalam kilogram
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
                                                        <input type="number" class="form-control border-primary border-opacity-25" id="luas_panen" name="luas_panen" value="{{ old('luas_panen', Auth::check() ? Auth::user()->luas_lahan : '') }}" placeholder="0.00" min="0" step="0.01">
                                                        <span class="input-group-text bg-primary text-white border-primary">
                                                            <i class="fas fa-map-marked-alt"></i> ha
                                                        </span>
                                                    </div>
                                                    <div class="form-text text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>Luas lahan yang dipanen (opsional)
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
                                            <textarea class="form-control border-info border-opacity-25" id="deskripsi_kemajuan" name="deskripsi_kemajuan" rows="5" placeholder="Jelaskan secara detail kemajuan pertanian Anda hari ini...

Contoh:
- Kondisi tanaman saat ini
- Perawatan yang telah dilakukan
- Tantangan yang dihadapi
- Rencana perawatan selanjutnya" required>{{ old('deskripsi_kemajuan') }}</textarea>
                                            <div class="form-text text-muted">
                                                <i class="fas fa-lightbulb me-1"></i>Berikan deskripsi yang detail tentang kondisi tanaman dan aktivitas pertanian Anda
                                            </div>
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
                                            <textarea class="form-control border-warning border-opacity-25" id="catatan" name="catatan" rows="3" placeholder="Tambahkan catatan tambahan jika ada...

Contoh:
- Kondisi cuaca hari ini
- Masalah yang dihadapi
- Saran untuk perbaikan
- Informasi penting lainnya">{{ old('catatan') }}</textarea>
                                            <div class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Catatan ini bersifat opsional dan dapat membantu monitoring lebih detail
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-transparent">
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center gap-3">
                                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="resetForm()">
                                                <i class="fas fa-undo me-2"></i>Reset Form
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-lg px-4" onclick="previewData()">
                                                <i class="fas fa-eye me-2"></i>Preview
                                            </button>
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fas fa-save me-2"></i>Simpan Laporan
                                            </button>
                                        </div>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Pastikan semua data telah diisi dengan benar sebelum menyimpan
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-light shadow-sm">
                <div class="card-body p-4">
                    <h6 class="text-center mb-3 font-weight-bold">
                        <i class="fas fa-chart-bar text-success me-2"></i>Ringkasan Laporan Anda
                    </h6>
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h4 class="text-success mb-1">{{ \App\Models\Laporan::where('user_id', Auth::id())->count() }}</h4>
                                <small class="text-muted">Total Laporan</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h4 class="text-primary mb-1">{{ number_format(\App\Models\Laporan::where('user_id', Auth::id())->sum('hasil_panen'), 1) }} kg</h4>
                                <small class="text-muted">Total Panen</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h4 class="text-info mb-1">{{ Auth::check() ? number_format(Auth::user()->luas_lahan, 1) : '0' }} ha</h4>
                                <small class="text-muted">Luas Lahan</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <h4 class="text-warning mb-1">{{ \App\Models\Bantuan::where('user_id', Auth::id())->count() }}</h4>
                                <small class="text-muted">Bantuan Diterima</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Preview Laporan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="submitForm()">Konfirmasi & Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('laporanForm');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        let isValid = true;

        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            showAlert('Mohon lengkapi semua field yang wajib diisi dengan benar.', 'danger');
            return false;
        }

        if (!confirm('Yakin ingin menyimpan laporan ini?')) {
            e.preventDefault();
            return false;
        }
    });

    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let message = '';

    // Remove existing validation classes
    field.classList.remove('is-valid', 'is-invalid');

    // Check if field is required and empty
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        message = 'Field ini wajib diisi';
    }

    // Specific validations
    if (field.name === 'hasil_panen' && value) {
        const numValue = parseFloat(value);
        if (numValue < 0) {
            isValid = false;
            message = 'Hasil panen tidak boleh negatif';
        }
    }

    if (field.name === 'luas_panen' && value) {
        const numValue = parseFloat(value);
        if (numValue < 0) {
            isValid = false;
            message = 'Luas panen tidak boleh negatif';
        }
    }

    // Show validation feedback
    if (isValid && value) {
        field.classList.add('is-valid');
    } else if (!isValid) {
        field.classList.add('is-invalid');
    }

    // Update or remove error message
    let errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (!isValid && message) {
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    } else if (errorDiv) {
        errorDiv.remove();
    }

    return isValid;
}

function resetForm() {
    if (confirm('Yakin ingin mereset semua data form?')) {
        document.getElementById('laporanForm').reset();
        // Remove validation classes
        const fields = document.querySelectorAll('.form-control, .form-select');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
            const errorDiv = field.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) errorDiv.remove();
        });
        showAlert('Form telah direset.', 'info');
    }
}

function previewData() {
    const formData = new FormData(document.getElementById('laporanForm'));
    let previewHtml = '<div class="row">';

    // Jenis Tanaman & Tanggal
    previewHtml += '<div class="col-md-6"><h6>Jenis Tanaman</h6><p class="text-primary">' + (formData.get('jenis_tanaman') || 'Belum dipilih') + '</p></div>';
    previewHtml += '<div class="col-md-6"><h6>Tanggal Laporan</h6><p class="text-primary">' + (formData.get('tanggal') || 'Belum dipilih') + '</p></div>';

    // Hasil Panen & Luas Panen
    previewHtml += '<div class="col-md-6"><h6>Hasil Panen</h6><p class="text-success font-weight-bold">' + (formData.get('hasil_panen') || '0') + ' kg</p></div>';
    previewHtml += '<div class="col-md-6"><h6>Luas Area Dipanen</h6><p class="text-info">' + (formData.get('luas_panen') || '0') + ' ha</p></div>';

    previewHtml += '</div><hr>';

    // Deskripsi Kemajuan
    previewHtml += '<h6>Deskripsi Kemajuan</h6>';
    previewHtml += '<div class="bg-light p-3 rounded">' + (formData.get('deskripsi_kemajuan') || 'Belum diisi').replace(/\n/g, '<br>') + '</div>';

    // Catatan
    if (formData.get('catatan')) {
        previewHtml += '<hr><h6>Catatan Tambahan</h6>';
        previewHtml += '<div class="bg-light p-3 rounded">' + formData.get('catatan').replace(/\n/g, '<br>') + '</div>';
    }

    document.getElementById('previewContent').innerHTML = previewHtml;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function submitForm() {
    document.getElementById('laporanForm').submit();
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-info-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}

// Auto-calculate productivity if luas_panen is filled
document.getElementById('luas_panen').addEventListener('input', function() {
    const hasilPanen = parseFloat(document.getElementById('hasil_panen').value) || 0;
    const luasPanen = parseFloat(this.value) || 0;

    if (hasilPanen > 0 && luasPanen > 0) {
        const productivity = hasilPanen / luasPanen;
        console.log(`Produktivitas: ${productivity.toFixed(2)} kg/ha`);
        // You can add a display for productivity if needed
    }
});
</script>
@endsection
