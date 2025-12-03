@extends('layouts.app')

@section('title', 'Tambah Foto Galeri')

@push('styles')
<style>
    .galeri-hero {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(236,72,153,0.3);
    }
    .galeri-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 0.2rem rgba(236,72,153,0.15);
    }
    .preview-container {
        border-radius: 16px;
        border: 3px dashed #e0e0e0;
        background: #f8f9fa;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .preview-container:hover {
        border-color: #ec4899;
        background: #fff5f9;
    }
    .preview-container.has-image {
        border-style: solid;
        border-color: #ec4899;
        background: white;
    }
    .preview-placeholder {
        text-align: center;
        color: #999;
    }
    .preview-placeholder i {
        font-size: 4rem;
        color: #ec4899;
        opacity: 0.3;
        margin-bottom: 1rem;
    }
    .preview-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .upload-btn {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        transition: all 0.3s;
        border: none;
    }
    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    .file-input-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
    .file-input-label {
        border-radius: 12px;
        border: 2px dashed #ec4899;
        background: #fff5f9;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        display: block;
    }
    .file-input-label:hover {
        background: white;
        border-color: #db2777;
        transform: translateY(-2px);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="galeri-hero">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0" style="font-weight: 800;">Tambah Foto Galeri</h1>
                <p class="mb-0 mt-2" style="opacity: 0.9;">Unggah foto kegiatan pertanian</p>
            </div>
            <a href="{{ route('admin.galeri.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="galeri-card p-4">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <h6 class="section-title">
                        <i class="fas fa-info-circle me-2 text-pink"></i>Informasi Foto
                    </h6>
                    
                    <div class="mb-4">
                        <label for="judul" class="form-label fw-bold">Judul Foto <span class="text-danger">*</span></label>
                        <input class="form-control @error('judul') is-invalid @enderror"
                               type="text" name="judul" id="judul"
                               value="{{ old('judul') }}" 
                               placeholder="Masukkan judul foto..."
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Foto</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  name="deskripsi" id="deskripsi" rows="4"
                                  placeholder="Deskripsi singkat tentang foto ini">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="form-label fw-bold">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror"
                                name="kategori" id="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="pertanian" {{ old('kategori') == 'pertanian' ? 'selected' : '' }}>🌾 Pertanian</option>
                            <option value="bantuan" {{ old('kategori') == 'bantuan' ? 'selected' : '' }}>🤝 Bantuan</option>
                            <option value="panen" {{ old('kategori') == 'panen' ? 'selected' : '' }}>🌾 Panen</option>
                            <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>📅 Kegiatan</option>
                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>📁 Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="section-title">
                        <i class="fas fa-image me-2 text-pink"></i>Upload Foto
                    </h6>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Foto <span class="text-danger">*</span></label>
                        <div class="file-input-wrapper">
                            <label class="file-input-label" for="gambar">
                                <i class="fas fa-cloud-upload-alt fa-2x text-pink mb-2"></i>
                                <p class="mb-1 fw-bold">Klik untuk upload foto</p>
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB</small>
                            </label>
                            <input class="form-control @error('gambar') is-invalid @enderror"
                                   type="file" name="gambar" id="gambar" accept="image/*" required>
                        </div>
                        @error('gambar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                name="status" id="status">
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>✅ Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input class="form-control @error('urutan') is-invalid @enderror"
                               type="number" name="urutan" id="urutan"
                               value="{{ old('urutan', 0) }}" min="0"
                               placeholder="0">
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Urutan untuk sorting (0 = default)</small>
                    </div>

                    <!-- Preview Image -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Preview</label>
                        <div id="imagePreview" class="preview-container">
                            <div class="preview-placeholder">
                                <i class="fas fa-image"></i>
                                <p class="mb-0">Preview gambar akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="upload-btn btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Foto
                        </button>
                        <a href="{{ route('admin.galeri.index') }}" class="upload-btn btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.classList.add('has-image');
            preview.innerHTML = `<img src="${e.target.result}" class="preview-image">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.remove('has-image');
        preview.innerHTML = `
            <div class="preview-placeholder">
                <i class="fas fa-image"></i>
                <p class="mb-0">Preview gambar akan muncul di sini</p>
            </div>
        `;
    }
});
</script>
@endpush
@endsection
