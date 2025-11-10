@extends('layouts.app')

@section('title', 'Edit Foto Galeri')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Edit Foto Galeri</h6>
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul" class="form-control-label">Judul Foto *</label>
                                    <input class="form-control @error('judul') is-invalid @enderror"
                                           type="text" name="judul" id="judul"
                                           value="{{ old('judul', $galeri->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi" class="form-control-label">Deskripsi Foto</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              name="deskripsi" id="deskripsi" rows="4"
                                              placeholder="Deskripsi singkat tentang foto ini">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kategori" class="form-control-label">Kategori</label>
                                    <select class="form-control @error('kategori') is-invalid @enderror"
                                            name="kategori" id="kategori">
                                        <option value="">Pilih Kategori</option>
                                        <option value="pertanian" {{ old('kategori', $galeri->kategori) == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                                        <option value="bantuan" {{ old('kategori', $galeri->kategori) == 'bantuan' ? 'selected' : '' }}>Bantuan</option>
                                        <option value="panen" {{ old('kategori', $galeri->kategori) == 'panen' ? 'selected' : '' }}>Panen</option>
                                        <option value="kegiatan" {{ old('kategori', $galeri->kategori) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        <option value="lainnya" {{ old('kategori', $galeri->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Foto Saat Ini</label>
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="Foto Galeri" class="img-fluid rounded" style="max-width: 200px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="gambar" class="form-control-label">Ganti Foto</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror"
                                           type="file" name="gambar" id="gambar" accept="image/*">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti foto. Format: JPG, PNG, GIF. Maksimal 5MB</small>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="form-control-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            name="status" id="status">
                                        <option value="draft" {{ old('status', $galeri->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $galeri->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="urutan" class="form-control-label">Urutan Tampilan</label>
                                    <input class="form-control @error('urutan') is-invalid @enderror"
                                           type="number" name="urutan" id="urutan"
                                           value="{{ old('urutan', $galeri->urutan) }}" min="0">
                                    @error('urutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Urutan untuk sorting (0 = default)</small>
                                </div>

                                <!-- Preview Image -->
                                <div class="form-group">
                                    <label class="form-control-label">Preview</label>
                                    <div id="imagePreview" class="border rounded p-2 text-center" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('storage/' . $galeri->gambar) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Current image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Foto
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
        preview.innerHTML = `<img src="{{ asset('storage/' . $galeri->gambar) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Current image">`;
    }
});
</script>
@endpush
@endsection
