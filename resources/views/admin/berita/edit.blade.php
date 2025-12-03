@extends('layouts.app')

@section('title', 'Edit Berita')

@push('styles')
<style>
    .edit-hero {
        background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(245,124,0,0.3);
    }
    .edit-card {
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
        border-color: #f57c00;
        box-shadow: 0 0 0 0.2rem rgba(245,124,0,0.15);
    }
    .preview-image {
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .submit-btn {
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 700;
        transition: all 0.3s;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="edit-hero">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0" style="font-weight: 800;">Edit Berita</h1>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    
    <div class="edit-card p-4">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul" class="form-control-label">Judul Berita *</label>
                                    <input class="form-control @error('judul') is-invalid @enderror"
                                           type="text" name="judul" id="judul"
                                           value="{{ old('judul', $berita->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="konten" class="form-control-label">Konten Berita *</label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror"
                                              name="konten" id="konten" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
                                    @error('konten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="ringkasan" class="form-control-label">Ringkasan</label>
                                    <textarea class="form-control @error('ringkasan') is-invalid @enderror"
                                              name="ringkasan" id="ringkasan" rows="3"
                                              placeholder="Ringkasan singkat berita (opsional)">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                                    @error('ringkasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                @if($berita->gambar)
                                    <div class="form-group">
                                        <label class="form-control-label">Gambar Saat Ini</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-fluid rounded" style="max-width: 200px;">
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="gambar" class="form-control-label">Ganti Gambar Berita</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror"
                                           type="file" name="gambar" id="gambar" accept="image/*">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_publikasi" class="form-control-label">Tanggal Publikasi</label>
                                    <input class="form-control @error('tanggal_publikasi') is-invalid @enderror"
                                           type="datetime-local" name="tanggal_publikasi" id="tanggal_publikasi"
                                           value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                                    @error('tanggal_publikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status" class="form-control-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            name="status" id="status">
                                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="penulis" class="form-control-label">Penulis</label>
                                    <input class="form-control @error('penulis') is-invalid @enderror"
                                           type="text" name="penulis" id="penulis"
                                           value="{{ old('penulis', $berita->penulis) }}">
                                    @error('penulis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Berita
                                </button>
                                <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
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
    // Initialize CKEditor for rich text editing
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection
