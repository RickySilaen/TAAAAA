@extends('layouts.app')

@section('title', 'Tambah Berita')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Tambah Berita Baru</h6>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul" class="form-control-label">Judul Berita *</label>
                                    <input class="form-control @error('judul') is-invalid @enderror"
                                           type="text" name="judul" id="judul"
                                           value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="konten" class="form-control-label">Konten Berita *</label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror"
                                              name="konten" id="konten" rows="10" required>{{ old('konten') }}</textarea>
                                    @error('konten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="ringkasan" class="form-control-label">Ringkasan</label>
                                    <textarea class="form-control @error('ringkasan') is-invalid @enderror"
                                              name="ringkasan" id="ringkasan" rows="3"
                                              placeholder="Ringkasan singkat berita (opsional)">{{ old('ringkasan') }}</textarea>
                                    @error('ringkasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gambar" class="form-control-label">Gambar Berita</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror"
                                           type="file" name="gambar" id="gambar" accept="image/*">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_publikasi" class="form-control-label">Tanggal Publikasi</label>
                                    <input class="form-control @error('tanggal_publikasi') is-invalid @enderror"
                                           type="datetime-local" name="tanggal_publikasi" id="tanggal_publikasi"
                                           value="{{ old('tanggal_publikasi', now()->format('Y-m-d\TH:i')) }}">
                                    @error('tanggal_publikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <label for="penulis" class="form-control-label">Penulis</label>
                                    <input class="form-control @error('penulis') is-invalid @enderror"
                                           type="text" name="penulis" id="penulis"
                                           value="{{ old('penulis', auth()->user()->name) }}">
                                    @error('penulis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Berita
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
