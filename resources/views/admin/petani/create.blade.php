@extends('layouts.app')

@section('title', 'Tambah Petani')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-0">
                        <i class="fas fa-user-plus me-2"></i>Tambah Petani Baru
                    </h4>
                    <p class="text-white-50 mb-0">Daftarkan petani baru ke dalam sistem (langsung terverifikasi)</p>
                </div>
                <div>
                    <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Form Pendaftaran Petani</h6>
                    <p class="text-sm mb-0">Lengkapi data petani di bawah ini. Petani yang didaftarkan admin akan langsung terverifikasi.</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Oops!</strong> Ada kesalahan dalam formulir Anda.
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.petani.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="Masukkan nama lengkap petani" required>
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                           placeholder="email@example.com" required>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" value="{{ old('telepon') }}" 
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                @error('telepon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Minimal 8 karakter" required>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Ketik ulang password" required>
                                </div>
                            </div>

                            <!-- Alamat Desa -->
                            <div class="col-md-6 mb-3">
                                <label for="alamat_desa" class="form-label">Alamat Desa <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" class="form-control @error('alamat_desa') is-invalid @enderror" 
                                           id="alamat_desa" name="alamat_desa" value="{{ old('alamat_desa') }}" 
                                           placeholder="Nama desa" required>
                                </div>
                                @error('alamat_desa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Kecamatan -->
                            <div class="col-md-6 mb-3">
                                <label for="alamat_kecamatan" class="form-label">Kecamatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select class="form-select @error('alamat_kecamatan') is-invalid @enderror" 
                                            id="alamat_kecamatan" name="alamat_kecamatan">
                                        <option value="">Pilih Kecamatan</option>
                                        <option value="Balige" {{ old('alamat_kecamatan') == 'Balige' ? 'selected' : '' }}>Balige</option>
                                        <option value="Laguboti" {{ old('alamat_kecamatan') == 'Laguboti' ? 'selected' : '' }}>Laguboti</option>
                                        <option value="Habinsaran" {{ old('alamat_kecamatan') == 'Habinsaran' ? 'selected' : '' }}>Habinsaran</option>
                                        <option value="Ajibata" {{ old('alamat_kecamatan') == 'Ajibata' ? 'selected' : '' }}>Ajibata</option>
                                        <option value="Lumban Julu" {{ old('alamat_kecamatan') == 'Lumban Julu' ? 'selected' : '' }}>Lumban Julu</option>
                                        <option value="Porsea" {{ old('alamat_kecamatan') == 'Porsea' ? 'selected' : '' }}>Porsea</option>
                                        <option value="Silaen" {{ old('alamat_kecamatan') == 'Silaen' ? 'selected' : '' }}>Silaen</option>
                                        <option value="Pintu Pohan Meranti" {{ old('alamat_kecamatan') == 'Pintu Pohan Meranti' ? 'selected' : '' }}>Pintu Pohan Meranti</option>
                                        <option value="Nassau" {{ old('alamat_kecamatan') == 'Nassau' ? 'selected' : '' }}>Nassau</option>
                                        <option value="Siantar Narumonda" {{ old('alamat_kecamatan') == 'Siantar Narumonda' ? 'selected' : '' }}>Siantar Narumonda</option>
                                        <option value="Bonatua Lunasi" {{ old('alamat_kecamatan') == 'Bonatua Lunasi' ? 'selected' : '' }}>Bonatua Lunasi</option>
                                        <option value="Tampahan" {{ old('alamat_kecamatan') == 'Tampahan' ? 'selected' : '' }}>Tampahan</option>
                                        <option value="Sigumpar" {{ old('alamat_kecamatan') == 'Sigumpar' ? 'selected' : '' }}>Sigumpar</option>
                                        <option value="Harian" {{ old('alamat_kecamatan') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="Bor-Bor" {{ old('alamat_kecamatan') == 'Bor-Bor' ? 'selected' : '' }}>Bor-Bor</option>
                                        <option value="Uluan" {{ old('alamat_kecamatan') == 'Uluan' ? 'selected' : '' }}>Uluan</option>
                                    </select>
                                </div>
                                @error('alamat_kecamatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong> Petani yang didaftarkan oleh admin akan langsung terverifikasi dan bisa login ke sistem.
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Simpan Petani
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
