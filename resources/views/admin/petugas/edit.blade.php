@extends('layouts.app')

@section('title', 'Edit Petugas - Sistem Bantuan Pertanian')

@push('styles')
    @include('admin.petugas._styles')
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Modern Header -->
    <div class="page-header-edit mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h1 class="mb-2 text-white" style="font-size: 2rem; font-weight: 800;">Edit Data Petugas</h1>
                        <p class="mb-0 text-white-50" style="font-size: 1rem; opacity: 0.95;">Perbarui informasi petugas yang sudah terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('admin.petugas.index') }}" class="btn btn-modern-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="card form-card-modern">
                <div class="card-header">
                    <h6 class="mb-1"><i class="fas fa-edit me-2"></i>Form Edit Petugas</h6>
                    <p class="text-sm mb-0">Update data petugas: <strong>{{ $petugas->name }}</strong></p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-modern alert-modern-danger mb-4">
                            <i class="fas fa-exclamation-circle mt-1"></i>
                            <div>
                                <strong class="d-block mb-1">Oops! Ada kesalahan dalam formulir Anda</strong>
                                <ul class="mb-0 mt-2 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-12 mb-4">
                                <label for="name" class="form-label-modern">
                                    <i class="fas fa-user text-amber-600"></i>
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $petugas->name) }}"
                                           placeholder="Masukkan nama lengkap petugas" required>
                                </div>
                                @error('name')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label-modern">
                                    <i class="fas fa-envelope text-blue-600"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $petugas->email) }}"
                                           placeholder="email@example.com" required>
                                </div>
                                @error('email')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Telepon -->
                            <div class="col-md-6 mb-4">
                                <label for="telepon" class="form-label-modern">
                                    <i class="fas fa-phone text-purple-600"></i>
                                    Nomor Telepon
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control form-control-modern @error('telepon') is-invalid @enderror"
                                           id="telepon" name="telepon" value="{{ old('telepon', $petugas->telepon) }}"
                                           placeholder="08123456789">
                                </div>
                                @error('telepon')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label-modern">
                                    <i class="fas fa-lock text-red-600"></i>
                                    Password Baru
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                    <button class="btn btn-toggle-password" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1"><i class="fas fa-info-circle me-1"></i>Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.</small>
                                @error('password')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label-modern">
                                    <i class="fas fa-lock text-red-600"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control form-control-modern"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Ulangi password baru">
                                    <button class="btn btn-toggle-password" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Alamat Desa -->
                            <div class="col-md-6 mb-4">
                                <label for="alamat_desa" class="form-label-modern">
                                    <i class="fas fa-map-marker-alt text-yellow-600"></i>
                                    Alamat Desa <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control form-control-modern @error('alamat_desa') is-invalid @enderror"
                                           id="alamat_desa" name="alamat_desa" value="{{ old('alamat_desa', $petugas->alamat_desa) }}"
                                           placeholder="Nama desa" required>
                                </div>
                                @error('alamat_desa')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Alamat Kecamatan -->
                            <div class="col-md-6 mb-4">
                                <label for="alamat_kecamatan" class="form-label-modern">
                                    <i class="fas fa-map text-orange-600"></i>
                                    Alamat Kecamatan
                                </label>
                                <div class="input-group input-group-modern">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <input type="text" class="form-control form-control-modern @error('alamat_kecamatan') is-invalid @enderror"
                                           id="alamat_kecamatan" name="alamat_kecamatan" value="{{ old('alamat_kecamatan', $petugas->alamat_kecamatan) }}"
                                           placeholder="Nama kecamatan">
                                </div>
                                @error('alamat_kecamatan')
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- Info Box -->
                        <div class="alert alert-modern alert-modern-warning mb-4">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <div>
                                <strong class="d-block mb-1">Perhatian Penting</strong>
                                <p class="mb-0 text-sm">Jika Anda mengubah password, petugas harus menggunakan password baru untuk login selanjutnya. Pastikan untuk memberitahukan petugas tentang perubahan ini.</p>
                            </div>
                        </div>
                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('admin.petugas.index') }}" class="btn btn-modern-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-modern-primary">
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
