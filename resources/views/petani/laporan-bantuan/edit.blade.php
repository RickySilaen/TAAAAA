@extends('layouts.app')

@section('title', 'Edit Laporan Bantuan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Edit Laporan Bantuan</h1>
            <p class="text-muted mb-0">{{ $laporan->judul }}</p>
        </div>
        <a href="{{ route('petani.laporan-bantuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if($laporan->status === 'rejected' && $laporan->catatan_verifikasi)
    <div class="alert alert-warning">
        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Laporan Ditolak</h6>
        <p class="mb-0"><strong>Alasan:</strong> {{ $laporan->catatan_verifikasi }}</p>
        <small class="text-muted">Silakan perbaiki laporan Anda sesuai catatan di atas.</small>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Laporan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('petani.laporan-bantuan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul', $laporan->judul) }}" 
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Bantuan -->
                        <div class="mb-3">
                            <label for="jenis_bantuan" class="form-label">Jenis Bantuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_bantuan') is-invalid @enderror" 
                                    id="jenis_bantuan" 
                                    name="jenis_bantuan" 
                                    required>
                                <option value="">Pilih Jenis Bantuan</option>
                                <option value="Pupuk" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="Bibit" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Bibit' ? 'selected' : '' }}>Bibit</option>
                                <option value="Alat Pertanian" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Alat Pertanian' ? 'selected' : '' }}>Alat Pertanian</option>
                                <option value="Bantuan Tunai" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Bantuan Tunai' ? 'selected' : '' }}>Bantuan Tunai</option>
                                <option value="Pelatihan" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="Lainnya" {{ old('jenis_bantuan', $laporan->jenis_bantuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_bantuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah & Satuan -->
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="jumlah_bantuan" class="form-label">Jumlah Bantuan</label>
                                <input type="number" 
                                       class="form-control @error('jumlah_bantuan') is-invalid @enderror" 
                                       id="jumlah_bantuan" 
                                       name="jumlah_bantuan" 
                                       value="{{ old('jumlah_bantuan', $laporan->jumlah_bantuan) }}" 
                                       step="0.01">
                                @error('jumlah_bantuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select class="form-select @error('satuan') is-invalid @enderror" 
                                        id="satuan" 
                                        name="satuan">
                                    <option value="">Pilih Satuan</option>
                                    <option value="kg" {{ old('satuan', $laporan->satuan) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="ton" {{ old('satuan', $laporan->satuan) == 'ton' ? 'selected' : '' }}>Ton</option>
                                    <option value="unit" {{ old('satuan', $laporan->satuan) == 'unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="paket" {{ old('satuan', $laporan->satuan) == 'paket' ? 'selected' : '' }}>Paket</option>
                                    <option value="liter" {{ old('satuan', $laporan->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Penerimaan -->
                        <div class="mb-3">
                            <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                            <input type="date" 
                                   class="form-control @error('tanggal_penerimaan') is-invalid @enderror" 
                                   id="tanggal_penerimaan" 
                                   name="tanggal_penerimaan" 
                                   value="{{ old('tanggal_penerimaan', $laporan->tanggal_penerimaan ? $laporan->tanggal_penerimaan->format('Y-m-d') : '') }}">
                            @error('tanggal_penerimaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Bukti Existing -->
                        @if(!empty($laporan->foto_bukti_urls))
                        <div class="mb-3">
                            <label class="form-label">Foto Bukti Saat Ini</label>
                            <div class="row" id="existingPhotos">
                                @foreach($laporan->foto_bukti_urls as $index => $photo)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ $photo }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2 text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="foto_bukti_delete[]" 
                                                       value="{{ $laporan->foto_bukti[$index] }}" 
                                                       id="delete{{ $index }}">
                                                <label class="form-check-label text-danger" for="delete{{ $index }}">
                                                    Hapus foto ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Upload Foto Baru -->
                        <div class="mb-3">
                            <label for="foto_bukti_new" class="form-label">Tambah Foto Baru (Opsional)</label>
                            <input type="file" 
                                   class="form-control @error('foto_bukti_new.*') is-invalid @enderror" 
                                   id="foto_bukti_new" 
                                   name="foto_bukti_new[]" 
                                   accept="image/jpeg,image/jpg,image/png" 
                                   multiple>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> Upload maksimal 5 foto. Format: JPG, JPEG, PNG. Max 5MB per foto.
                            </div>
                            @error('foto_bukti_new.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div id="newImagePreview" class="row mt-3" style="display: none;"></div>
                        </div>

                        <hr class="my-4">

                        <!-- Submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('petani.laporan-bantuan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Status Laporan</h6>
                </div>
                <div class="card-body">
                    <p><strong>Status Saat Ini:</strong> {!! $laporan->status_badge !!}</p>
                    
                    @if($laporan->status === 'pending')
                    <div class="alert alert-warning">
                        <small><i class="fas fa-clock me-2"></i>Menunggu verifikasi dari admin</small>
                    </div>
                    @endif

                    @if($laporan->status === 'rejected')
                    <div class="alert alert-danger">
                        <small><i class="fas fa-times-circle me-2"></i>Laporan ditolak. Perbaiki sesuai catatan dan submit ulang.</small>
                    </div>
                    @endif

                    <p class="small text-muted mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda hanya dapat mengedit laporan dengan status Pending atau Rejected.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('foto_bukti_new').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('newImagePreview');
    preview.innerHTML = '';
    
    if (files.length > 0) {
        preview.style.display = 'flex';
        
        Array.from(files).forEach((file, index) => {
            if (index >= 5) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" alt="Preview" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2 text-center">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
@endsection
