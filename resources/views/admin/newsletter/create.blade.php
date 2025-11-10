@extends('layouts.app')

@section('title', 'Buat Newsletter')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Buat Newsletter Baru</h6>
                        <a href="{{ route('admin.newsletter.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.newsletter.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul" class="form-control-label">Judul Newsletter *</label>
                                    <input class="form-control @error('judul') is-invalid @enderror"
                                           type="text" name="judul" id="judul"
                                           value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="konten" class="form-control-label">Konten Newsletter *</label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror"
                                              name="konten" id="konten" rows="15" required>{{ old('konten') }}</textarea>
                                    @error('konten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_kirim" class="form-control-label">Tanggal Kirim</label>
                                    <input class="form-control @error('tanggal_kirim') is-invalid @enderror"
                                           type="datetime-local" name="tanggal_kirim" id="tanggal_kirim"
                                           value="{{ old('tanggal_kirim') }}">
                                    @error('tanggal_kirim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Biarkan kosong untuk kirim manual</small>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="form-control-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            name="status" id="status">
                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="target_audience" class="form-control-label">Target Audience</label>
                                    <select class="form-control @error('target_audience') is-invalid @enderror"
                                            name="target_audience" id="target_audience">
                                        <option value="all" {{ old('target_audience', 'all') == 'all' ? 'selected' : '' }}>Semua Subscriber</option>
                                        <option value="active" {{ old('target_audience') == 'active' ? 'selected' : '' }}>Subscriber Aktif</option>
                                        <option value="petani" {{ old('target_audience') == 'petani' ? 'selected' : '' }}>Petani</option>
                                        <option value="admin" {{ old('target_audience') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('target_audience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Preview Section -->
                                <div class="form-group">
                                    <label class="form-control-label">Preview</label>
                                    <div class="border rounded p-3 bg-light">
                                        <div class="preview-content">
                                            <h5 id="preview-judul">Judul Newsletter</h5>
                                            <div id="preview-konten" class="mt-3">Konten newsletter akan muncul di sini...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Newsletter
                                </button>
                                <a href="{{ route('admin.newsletter.index') }}" class="btn btn-secondary">
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

    // Live preview
    document.getElementById('judul').addEventListener('input', updatePreview);
    document.getElementById('konten').addEventListener('input', updatePreview);

    function updatePreview() {
        const judul = document.getElementById('judul').value || 'Judul Newsletter';
        const konten = document.getElementById('konten').value || 'Konten newsletter akan muncul di sini...';

        document.getElementById('preview-judul').textContent = judul;
        document.getElementById('preview-konten').innerHTML = konten;
    }

    // Initial preview update
    updatePreview();
</script>
@endpush
@endsection
