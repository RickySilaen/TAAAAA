@extends('layouts.app')

@section('title', 'Edit Petugas - Sistem Bantuan Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-0">
                        <i class="fas fa-user-edit me-2"></i>Edit Data Petugas
                    </h4>
                    <p class="text-white-50 mb-0">Perbarui informasi petugas</p>
                </div>
                <div>
                    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">
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
                    <h6>Form Edit Petugas</h6>
                    <p class="text-sm mb-0">Update data petugas: <strong>{{ $petugas->name }}</strong></p>
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

                    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $petugas->name) }}" 
                                           placeholder="Masukkan nama lengkap petugas" required>
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
                                           id="email" name="email" value="{{ old('email', $petugas->email) }}" 
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
                                           id="telepon" name="telepon" value="{{ old('telepon', $petugas->telepon) }}" 
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                @error('telepon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</small>
                                @error('password')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Alamat Desa -->
                            <div class="col-md-6 mb-3">
                                <label for="alamat_desa" class="form-label">Alamat Desa <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control @error('alamat_desa') is-invalid @enderror" 
                                           id="alamat_desa" name="alamat_desa" value="{{ old('alamat_desa', $petugas->alamat_desa) }}" 
                                           placeholder="Nama desa" required>
                                </div>
                                @error('alamat_desa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Alamat Kecamatan -->
                            <div class="col-md-6 mb-3">
                                <label for="alamat_kecamatan" class="form-label">Alamat Kecamatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <input type="text" class="form-control @error('alamat_kecamatan') is-invalid @enderror" 
                                           id="alamat_kecamatan" name="alamat_kecamatan" value="{{ old('alamat_kecamatan', $petugas->alamat_kecamatan) }}" 
                                           placeholder="Nama kecamatan">
                                </div>
                                @error('alamat_kecamatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Jika Anda mengubah password, petugas harus menggunakan password baru untuk login selanjutnya.
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Petugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById('toggle' + inputId.charAt(0).toUpperCase() + inputId.slice(1) + 'Icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
