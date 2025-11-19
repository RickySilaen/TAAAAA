@extends('layouts.app')

@section('title', 'Edit Permintaan Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Permintaan Bantuan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('petani.bantuan.update', $bantuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="jenis_bantuan">Jenis Bantuan <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_bantuan') is-invalid @enderror" 
                                    id="jenis_bantuan" name="jenis_bantuan" required>
                                <option value="">-- Pilih Jenis Bantuan --</option>
                                <option value="Pupuk" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="Bibit" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Bibit' ? 'selected' : '' }}>Bibit</option>
                                <option value="Pestisida" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Pestisida' ? 'selected' : '' }}>Pestisida</option>
                                <option value="Alat Pertanian" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Alat Pertanian' ? 'selected' : '' }}>Alat Pertanian</option>
                                <option value="Dana" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Dana' ? 'selected' : '' }}>Dana</option>
                                <option value="Lainnya" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_bantuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   id="jumlah" name="jumlah" 
                                   value="{{ old('jumlah', $bantuan->jumlah) }}" required min="1">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan jumlah yang dibutuhkan (satuan sesuai jenis bantuan)</small>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_permintaan">Tanggal Permintaan</label>
                            <input type="date" class="form-control @error('tanggal_permintaan') is-invalid @enderror" 
                                   id="tanggal_permintaan" name="tanggal_permintaan" 
                                   value="{{ old('tanggal_permintaan', $bantuan->tanggal_permintaan ? $bantuan->tanggal_permintaan->format('Y-m-d') : '') }}">
                            @error('tanggal_permintaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan / Alasan Permintaan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $bantuan->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jelaskan alasan Anda mengajukan bantuan ini</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Bantuan
                            </button>
                            <a href="{{ route('petani.bantuan.index') }}" class="btn btn-secondary">
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
