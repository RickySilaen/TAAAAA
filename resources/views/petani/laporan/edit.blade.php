@extends('layouts.app')

@section('title', 'Edit Laporan Panen')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Laporan Panen</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('petani.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="jenis_tanaman">Jenis Tanaman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jenis_tanaman') is-invalid @enderror" 
                                   id="jenis_tanaman" name="jenis_tanaman" 
                                   value="{{ old('jenis_tanaman', $laporan->jenis_tanaman) }}" required>
                            @error('jenis_tanaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hasil_panen">Hasil Panen (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('hasil_panen') is-invalid @enderror" 
                                           id="hasil_panen" name="hasil_panen" 
                                           value="{{ old('hasil_panen', $laporan->hasil_panen) }}" required>
                                    @error('hasil_panen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="luas_panen">Luas Panen (ha)</label>
                                    <input type="number" step="0.01" class="form-control @error('luas_panen') is-invalid @enderror" 
                                           id="luas_panen" name="luas_panen" 
                                           value="{{ old('luas_panen', $laporan->luas_panen) }}">
                                    @error('luas_panen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal Panen</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" 
                                   value="{{ old('tanggal', $laporan->tanggal ? $laporan->tanggal->format('Y-m-d') : '') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_kemajuan">Deskripsi Kemajuan</label>
                            <textarea class="form-control @error('deskripsi_kemajuan') is-invalid @enderror" 
                                      id="deskripsi_kemajuan" name="deskripsi_kemajuan" rows="4">{{ old('deskripsi_kemajuan', $laporan->deskripsi_kemajuan) }}</textarea>
                            @error('deskripsi_kemajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan Tambahan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="3">{{ old('catatan', $laporan->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto Hasil Panen (Opsional)</label>
                            @if($laporan->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" alt="Foto Panen" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Laporan
                            </button>
                            <a href="{{ route('petani.laporan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
