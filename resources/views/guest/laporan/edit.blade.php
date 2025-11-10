@extends('layouts.guest')

@section('title', 'Edit Laporan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-edit me-2"></i>Edit Laporan Hasil Panen</h4>
                    <p class="mb-0 text-muted">Perbarui informasi laporan hasil panen Anda</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('guest.laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Nama Petani -->
                                <div class="form-group mb-4">
                                    <label for="nama_petani" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-user me-1"></i>Nama Petani *
                                    </label>
                                    <input type="text" class="form-control form-control-agriculture @error('nama_petani') is-invalid @enderror"
                                           name="nama_petani" id="nama_petani" value="{{ old('nama_petani', $laporan->nama_petani) }}"
                                           placeholder="Masukkan nama petani" required>
                                    @error('nama_petani')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alamat Desa -->
                                <div class="form-group mb-4">
                                    <label for="alamat_desa" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i>Alamat Desa *
                                    </label>
                                    <input type="text" class="form-control form-control-agriculture @error('alamat_desa') is-invalid @enderror"
                                           name="alamat_desa" id="alamat_desa" value="{{ old('alamat_desa', $laporan->alamat_desa) }}"
                                           placeholder="Masukkan alamat desa" required>
                                    @error('alamat_desa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Deskripsi Kemajuan -->
                                <div class="form-group mb-4">
                                    <label for="deskripsi_kemajuan" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-file-alt me-1"></i>Deskripsi Kemajuan *
                                    </label>
                                    <textarea class="form-control form-control-agriculture @error('deskripsi_kemajuan') is-invalid @enderror"
                                              name="deskripsi_kemajuan" id="deskripsi_kemajuan" rows="4"
                                              placeholder="Jelaskan kemajuan pertanian Anda..." required>{{ old('deskripsi_kemajuan', $laporan->deskripsi_kemajuan) }}</textarea>
                                    @error('deskripsi_kemajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Deskripsikan aktivitas pertanian yang telah dilakukan</small>
                                </div>

                                <!-- Jenis Tanaman -->
                                <div class="form-group mb-4">
                                    <label for="jenis_tanaman" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-seedling me-1"></i>Jenis Tanaman
                                    </label>
                                    <select class="form-select form-select-agriculture @error('jenis_tanaman') is-invalid @enderror"
                                            name="jenis_tanaman" id="jenis_tanaman">
                                        <option value="">Pilih jenis tanaman</option>
                                        <option value="Padi" {{ old('jenis_tanaman', $laporan->jenis_tanaman) == 'Padi' ? 'selected' : '' }}>🌾 Padi</option>
                                        <option value="Jagung" {{ old('jenis_tanaman', $laporan->jenis_tanaman) == 'Jagung' ? 'selected' : '' }}>🌽 Jagung</option>
                                        <option value="Kedelai" {{ old('jenis_tanaman', $laporan->jenis_tanaman) == 'Kedelai' ? 'selected' : '' }}>🫘 Kedelai</option>
                                        <option value="Singkong" {{ old('jenis_tanaman', $laporan->jenis_tanaman) == 'Singkong' ? 'selected' : '' }}>🥔 Singkong</option>
                                        <option value="Lainnya" {{ old('jenis_tanaman', $laporan->jenis_tanaman) == 'Lainnya' ? 'selected' : '' }}>🌱 Lainnya</option>
                                    </select>
                                    @error('jenis_tanaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Hasil Panen -->
                                <div class="form-group mb-4">
                                    <label for="hasil_panen" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-weight me-1"></i>Hasil Panen (kg) *
                                    </label>
                                    <input type="number" class="form-control form-control-agriculture @error('hasil_panen') is-invalid @enderror"
                                           name="hasil_panen" id="hasil_panen" step="0.01" min="0"
                                           value="{{ old('hasil_panen', $laporan->hasil_panen) }}" placeholder="0.00" required>
                                    @error('hasil_panen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Luas Lahan -->
                                <div class="form-group mb-4">
                                    <label for="luas_lahan" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-ruler-combined me-1"></i>Luas Lahan (m²) *
                                    </label>
                                    <input type="number" class="form-control form-control-agriculture @error('luas_lahan') is-invalid @enderror"
                                           name="luas_lahan" id="luas_lahan" step="0.01" min="0.01"
                                           value="{{ old('luas_lahan', $laporan->luas_lahan) }}" placeholder="0.00" required>
                                    @error('luas_lahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Laporan -->
                                <div class="form-group mb-4">
                                    <label for="tanggal" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-calendar me-1"></i>Tanggal Laporan *
                                    </label>
                                    <input type="date" class="form-control form-control-agriculture @error('tanggal') is-invalid @enderror"
                                           name="tanggal" id="tanggal" value="{{ old('tanggal', $laporan->tanggal) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div class="form-group mb-4">
                                    <label for="catatan" class="form-label text-sm font-weight-bold">
                                        <i class="fas fa-sticky-note me-1"></i>Catatan Tambahan
                                    </label>
                                    <textarea class="form-control form-control-agriculture @error('catatan') is-invalid @enderror"
                                              name="catatan" id="catatan" rows="3"
                                              placeholder="Catatan tambahan jika diperlukan...">{{ old('catatan', $laporan->catatan) }}</textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opsional: Masalah yang dihadapi, rencana selanjutnya, dll.</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Info Panel -->
                                <div class="card border-agriculture mb-4">
                                    <div class="card-header bg-agriculture text-white">
                                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item mb-3">
                                            <strong>Status:</strong><br>
                                            Guest (Tidak Terdaftar)
                                        </div>
                                        <div class="info-item">
                                            <strong>Catatan:</strong><br>
                                            Laporan ini akan diperbarui sebagai laporan dari guest
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Panel -->
                                <div class="card border-agriculture">
                                    <div class="card-header bg-agriculture text-white">
                                        <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="previewContent">
                                            <p class="text-muted">Preview akan muncul di sini...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('guest.laporan.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-outline-agriculture me-2" onclick="previewLaporan()">
                                            <i class="fas fa-eye me-1"></i>Preview
                                        </button>
                                        <button type="submit" class="btn btn-agriculture-primary">
                                            <i class="fas fa-save me-1"></i>Update Laporan
                                        </button>
                                    </div>
                                </div>
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
    // Auto-update preview on input change
    const inputs = ['nama_petani', 'alamat_desa', 'deskripsi_kemajuan', 'jenis_tanaman', 'hasil_panen', 'luas_lahan', 'tanggal', 'catatan'];
    inputs.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    updatePreview();
});

function updatePreview() {
    const nama = document.getElementById('nama_petani').value;
    const alamat = document.getElementById('alamat_desa').value;
    const deskripsi = document.getElementById('deskripsi_kemajuan').value;
    const jenis = document.getElementById('jenis_tanaman').value;
    const hasil = document.getElementById('hasil_panen').value;
    const luas = document.getElementById('luas_lahan').value;
    const tanggal = document.getElementById('tanggal').value;
    const catatan = document.getElementById('catatan').value;

    let previewHtml = '';

    if (nama || alamat || deskripsi || jenis || hasil || luas || tanggal) {
        if (nama) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Nama Petani:</strong> ' + nama;
            previewHtml += '</div>';
        }

        if (alamat) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Alamat Desa:</strong> ' + alamat;
            previewHtml += '</div>';
        }

        if (deskripsi) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Deskripsi:</strong> ' + deskripsi;
            previewHtml += '</div>';
        }

        if (jenis) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Jenis Tanaman:</strong> ' + jenis;
            previewHtml += '</div>';
        }

        if (hasil && hasil > 0) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Hasil Panen:</strong> ' + hasil + ' kg';
            previewHtml += '</div>';
        }

        if (luas) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Luas Lahan:</strong> ' + luas + ' m²';
            previewHtml += '</div>';
        }

        if (tanggal) {
            previewHtml += '<div class="preview-item mb-2">';
            previewHtml += '<strong>Tanggal:</strong> ' + formatDate(tanggal);
            previewHtml += '</div>';
        }

        if (catatan) {
            previewHtml += '<div class="preview-item">';
            previewHtml += '<strong>Catatan:</strong> ' + catatan;
            previewHtml += '</div>';
        }
    } else {
        previewHtml = '<p class="text-muted">Preview akan muncul di sini...</p>';
    }

    document.getElementById('previewContent').innerHTML = previewHtml;
}

function previewLaporan() {
    updatePreview();
    // Scroll to preview
    document.getElementById('previewContent').scrollIntoView({ behavior: 'smooth' });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>
@endsection
