@extends('layouts.app')

@section('title', 'Tambah Foto Galeri')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Tambah Foto Galeri</h6>
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul" class="form-control-label">Judul Foto *</label>
                                    <input class="form-control @error('judul') is-invalid @enderror"
                                           type="text" name="judul" id="judul"
                                           value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi" class="form-control-label">Deskripsi Foto</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              name="deskripsi" id="deskripsi" rows="4"
                                              placeholder="Deskripsi singkat tentang foto ini">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kategori" class="form-control-label">Kategori</label>
                                    <select class="form-control @error('kategori') is-invalid @enderror"
                                            name="kategori" id="kategori">
                                        <option value="">Pilih Kategori</option>
                                        <option value="pertanian" {{ old('kategori') == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                                        <option value="bantuan" {{ old('kategori') == 'bantuan' ? 'selected' : '' }}>Bantuan</option>
                                        <option value="panen" {{ old('kategori') == 'panen' ? 'selected' : '' }}>Panen</option>
                                        <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gambar" class="form-control-label">Foto *</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror"
                                           type="file" name="gambar" id="gambar" accept="image/*" required>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 5MB</small>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="form-control-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            name="status" id="status">
                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="urutan" class="form-control-label">Urutan Tampilan</label>
                                    <input class="form-control @error('urutan') is-invalid @enderror"
                                           type="number" name="urutan" id="urutan"
                                           value="{{ old('urutan', 0) }}" min="0">
                                    @error('urutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Urutan untuk sorting (0 = default)</small>
                                </div>

                                <!-- Preview Image -->
                                <div class="form-group">
                                    <label class="form-control-label">Preview</label>
                                    <div id="imagePreview" class="border rounded p-2 text-center" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p>Preview gambar akan muncul di sini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Foto
                                </button>
                                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `
            <div class="text-muted">
                <i class="fas fa-image fa-3x mb-2"></i>
                <p>Preview gambar akan muncul di sini</p>
            </div>
        `;
    }
});
</script>
@endpush
@endsection
