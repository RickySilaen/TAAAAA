@extends('layouts.app')

@section('title', 'Buat Laporan Bantuan')

@push('styles')
<style>
    /* Performance Optimizations */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .page-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(27, 94, 32, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h60v60H0z" fill="none"/><path d="M30 0v60M0 30h60" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
        opacity: 0.3;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: rgba(255,255,255,0.95);
        font-size: 1.1rem;
        margin: 0;
    }

    .btn-back {
        background: white;
        color: #1b5e20;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #f1f8e9;
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.2);
        color: #1b5e20;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .form-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        border-left: 4px solid #1b5e20;
    }

    .form-card-header h6 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
    }

    /* Form Elements */
    .form-label {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label .text-danger {
        color: #e74c3c !important;
        font-size: 1.2rem;
    }

    .form-control-custom,
    .form-select-custom {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: #1b5e20;
        box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.1);
        outline: none;
        background: #f9fdf9;
    }

    .form-control-custom.is-invalid,
    .form-select-custom.is-invalid {
        border-color: #e74c3c;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231b5e20' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 3rem;
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-text i {
        color: #00bcd4;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }

    /* File Upload */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #1b5e20;
        border-radius: 12px;
        padding: 1.5rem;
        background: #f9fdf9;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-wrapper:hover {
        border-color: #2e7d32;
        background: #f1f8e9;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-label {
        text-align: center;
        pointer-events: none;
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #1b5e20;
        margin-bottom: 1rem;
    }

    /* Preview Images */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .preview-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .preview-item .preview-name {
        padding: 0.75rem;
        background: white;
        font-size: 0.75rem;
        color: #666;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Checkbox */
    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        border: 2px solid #1b5e20;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #1b5e20;
        border-color: #1b5e20;
    }

    .form-check-label {
        margin-left: 0.5rem;
        cursor: pointer;
    }

    /* Buttons */
    .btn-action {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(27, 94, 32, 0.4);
        color: white;
    }

    .btn-secondary-custom {
        background: white;
        color: #666;
        border: 2px solid #e0e0e0;
    }

    .btn-secondary-custom:hover {
        background: #f5f5f5;
        border-color: #ccc;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: #666;
    }

    /* Sidebar */
    .sidebar-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .sidebar-header {
        background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%);
        padding: 1.5rem;
        color: white;
    }

    .sidebar-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-body {
        padding: 2rem;
    }

    .sidebar-body h6 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .sidebar-body ul {
        padding-left: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .sidebar-body ul li {
        margin-bottom: 0.75rem;
        color: #555;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .alert-custom {
        background: linear-gradient(135deg, #fff3cd 0%, #fff8e1 100%);
        border: 2px solid #ffc107;
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1.5rem;
    }

    .alert-custom i {
        color: #ff9800;
    }

    .alert-custom strong {
        color: #e65100;
    }

    /* Divider */
    hr {
        border: none;
        border-top: 2px solid #e0e0e0;
        margin: 2rem 0;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .sidebar-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .preview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Icon Fix */
    i.fas, i.fa {
        font-style: normal;
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h1 class="page-title">Buat Laporan Bantuan Baru</h1>
                        <p class="page-subtitle">Laporkan bantuan yang telah Anda terima secara transparan</p>
                    </div>
                    <a href="{{ route('petani.laporan-bantuan.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="form-card-header">
                        <h6><i class="fas fa-file-alt me-2"></i>Form Laporan Bantuan</h6>
                    </div>

                    <form action="{{ route('petani.laporan-bantuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Laporan -->
                        <div class="mb-4">
                            <label for="judul" class="form-label">
                                Judul Laporan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control-custom @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul') }}" 
                                   placeholder="Contoh: Penerimaan Pupuk Subsidi Periode Maret 2024"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Bantuan -->
                        <div class="mb-4">
                            <label for="jenis_bantuan" class="form-label">
                                Jenis Bantuan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select-custom @error('jenis_bantuan') is-invalid @enderror" 
                                    id="jenis_bantuan" 
                                    name="jenis_bantuan" 
                                    required>
                                <option value="">Pilih Jenis Bantuan</option>
                                <option value="Pupuk" {{ old('jenis_bantuan') == 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="Bibit" {{ old('jenis_bantuan') == 'Bibit' ? 'selected' : '' }}>Bibit</option>
                                <option value="Alat Pertanian" {{ old('jenis_bantuan') == 'Alat Pertanian' ? 'selected' : '' }}>Alat Pertanian</option>
                                <option value="Bantuan Tunai" {{ old('jenis_bantuan') == 'Bantuan Tunai' ? 'selected' : '' }}>Bantuan Tunai</option>
                                <option value="Pelatihan" {{ old('jenis_bantuan') == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="Lainnya" {{ old('jenis_bantuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_bantuan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Bantuan -->
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <label for="jumlah_bantuan" class="form-label">Jumlah Bantuan</label>
                                <input type="number" 
                                       class="form-control-custom @error('jumlah_bantuan') is-invalid @enderror" 
                                       id="jumlah_bantuan" 
                                       name="jumlah_bantuan" 
                                       value="{{ old('jumlah_bantuan') }}" 
                                       step="0.01"
                                       placeholder="Contoh: 100">
                                @error('jumlah_bantuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select class="form-select-custom @error('satuan') is-invalid @enderror" 
                                        id="satuan" 
                                        name="satuan">
                                    <option value="">Pilih Satuan</option>
                                    <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="ton" {{ old('satuan') == 'ton' ? 'selected' : '' }}>Ton</option>
                                    <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="paket" {{ old('satuan') == 'paket' ? 'selected' : '' }}>Paket</option>
                                    <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">
                                Deskripsi Laporan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control-custom @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="5" 
                                      placeholder="Jelaskan detail bantuan yang diterima, kondisi, dan rencana penggunaan..."
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Penerimaan -->
                        <div class="mb-4">
                            <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan Bantuan</label>
                            <input type="date" 
                                   class="form-control-custom @error('tanggal_penerimaan') is-invalid @enderror" 
                                   id="tanggal_penerimaan" 
                                   name="tanggal_penerimaan" 
                                   value="{{ old('tanggal_penerimaan', date('Y-m-d')) }}">
                            @error('tanggal_penerimaan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Bukti -->
                        <div class="mb-4">
                            <label for="foto_bukti" class="form-label">
                                Foto Bukti <span class="text-danger">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       class="@error('foto_bukti.*') is-invalid @enderror" 
                                       id="foto_bukti" 
                                       name="foto_bukti[]" 
                                       accept="image/jpeg,image/jpg,image/png" 
                                       multiple
                                       required>
                                <div class="file-upload-label">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <p class="mb-1"><strong>Pilih atau Drag & Drop File</strong></p>
                                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Upload minimal 1 foto, maksimal 5 foto</p>
                                </div>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Upload minimal 1 foto, maksimal 5 foto. Format: JPG, JPEG, PNG. Ukuran maksimal 5MB per foto.
                            </div>
                            @error('foto_bukti.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview -->
                            <div id="imagePreview" class="preview-grid" style="display: none;"></div>
                        </div>

                        <!-- Pilihan Bantuan (Optional) -->
                        @if($bantuanList->count() > 0)
                        <div class="mb-4">
                            <label for="bantuan_id" class="form-label">Terkait Pengajuan Bantuan (Opsional)</label>
                            <select class="form-select-custom @error('bantuan_id') is-invalid @enderror" 
                                    id="bantuan_id" 
                                    name="bantuan_id">
                                <option value="">-- Tidak terkait pengajuan --</option>
                                @foreach($bantuanList as $bantuan)
                                    <option value="{{ $bantuan->id }}" {{ old('bantuan_id') == $bantuan->id ? 'selected' : '' }}>
                                        {{ $bantuan->jenis_bantuan }} - {{ $bantuan->created_at->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Pilih jika laporan ini terkait dengan pengajuan bantuan yang pernah Anda buat
                            </div>
                            @error('bantuan_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <!-- Publikasi -->
                        <div class="mb-4">
                            <div class="form-check d-flex align-items-start">
                                <input class="form-check-input mt-1" 
                                       type="checkbox" 
                                       id="is_public" 
                                       name="is_public" 
                                       value="1" 
                                       {{ old('is_public', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    <strong style="color: #2c3e50;">Publikasikan di Dashboard Transparansi</strong>
                                    <div class="form-text mt-1">Laporan akan ditampilkan di halaman publik untuk transparansi</div>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Submit Button -->
                        <div class="d-flex gap-3 flex-wrap justify-content-end">
                            <a href="{{ route('petani.laporan-bantuan.index') }}" class="btn-action btn-secondary-custom">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn-action btn-primary-custom">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h6><i class="fas fa-info-circle"></i> Panduan Laporan</h6>
                    </div>
                    <div class="sidebar-body">
                        <h6><i class="fas fa-lightbulb me-2" style="color: #ffc107;"></i>Tips Membuat Laporan:</h6>
                        <ul>
                            <li>Gunakan judul yang jelas dan deskriptif</li>
                            <li>Sertakan foto bukti yang jelas menunjukkan bantuan yang diterima</li>
                            <li>Jelaskan detail bantuan dengan lengkap</li>
                            <li>Cantumkan jumlah dan satuan bantuan dengan akurat</li>
                            <li>Laporan akan diverifikasi oleh admin sebelum dipublikasikan</li>
                        </ul>

                        <h6><i class="fas fa-camera me-2" style="color: #00bcd4;"></i>Foto yang Baik:</h6>
                        <ul>
                            <li>Pastikan pencahayaan cukup</li>
                            <li>Tampilkan bantuan dengan jelas</li>
                            <li>Hindari foto yang blur atau tidak fokus</li>
                            <li>Bisa sertakan foto proses distribusi/penerimaan</li>
                        </ul>

                        <div class="alert-custom">
                            <div style="font-size: 0.9rem;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Pastikan informasi yang Anda berikan akurat dan sesuai fakta. 
                                Laporan palsu akan ditindak sesuai ketentuan yang berlaku.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('foto_bukti').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (files.length > 0) {
        preview.style.display = 'grid';
        
        Array.from(files).forEach((file, index) => {
            if (index >= 5) return; // Max 5 images
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <div class="preview-name">${file.name}</div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        preview.style.display = 'none';
    }
});

// Form validation enhancement
const form = document.querySelector('form');
const requiredInputs = form.querySelectorAll('[required]');

requiredInputs.forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim() === '') {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    input.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush
@endsection
