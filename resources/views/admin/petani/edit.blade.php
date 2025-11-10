@extends('layouts.app')@extends('layouts.app')



@section('title', 'Edit Petani')@section('title', 'Edit Petani')



@section('content')@section('content')

<div class="container-fluid py-4"><div class="container-fluid py-4">

    <!-- Header -->    <!-- Header -->

    <div class="row mb-4">    <div class="row mb-4">

        <div class="col-12">        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">            <div class="d-flex justify-content-between align-items-center">

                <div>                <div>

                    <h4 class="text-white mb-0">                    <h4 class="text-white mb-0">

                        <i class="fas fa-user-edit me-2"></i>Edit Data Petani                        <i class="fas fa-user-edit me-2"></i>Edit Data Petani

                    </h4>                    </h4>

                    <p class="text-white-50 mb-0">Perbarui data petani: <strong>{{ $petani->name }}</strong></p>                    <p class="text-white-50 mb-0">Perbarui data petani dalam sistem</p>

                </div>                </div>

                <div>                <div>

                    <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">                    <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">

                        <i class="fas fa-arrow-left me-2"></i>Kembali                        <i class="fas fa-arrow-left me-2"></i>Kembali

                    </a>                    </a>

                </div>                </div>

            </div>            </div>

        </div>        </div>

    </div>    </div>



    <!-- Form -->    <!-- Form -->

    <div class="row">    <div class="row">

        <div class="col-lg-8 mx-auto">        <div class="col-lg-8 mx-auto">

            <div class="card">            <div class="card">

                <div class="card-header pb-0">                <div class="card-header pb-0">

                    <h6>Form Edit Petani</h6>                    <h6>Form Edit Petani</h6>

                    <p class="text-sm mb-0">Ubah data yang diperlukan</p>                    <p class="text-sm mb-0">Ubah data yang diperlukan</p>

                </div>                </div>

                <div class="card-body">                <div class="card-body">

                    @if ($errors->any())                    @if ($errors->any())

                        <div class="alert alert-danger">                        <div class="alert alert-danger">

                            <i class="fas fa-exclamation-circle me-2"></i>                            <i class="fas fa-exclamation-circle me-2"></i>

                            <strong>Oops!</strong> Ada kesalahan dalam formulir Anda.                            <strong>Oops!</strong> Ada kesalahan dalam formulir Anda.

                            <ul class="mb-0 mt-2">                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>                                    <li>{{ $error }}</li>

                                @endforeach                                @endforeach

                            </ul>                            </ul>

                        </div>                        </div>

                    @endif                    @endif



                    <form action="{{ route('admin.petani.update', $petani->id) }}" method="POST">                    <form action="{{ route('admin.petani.update', $petani->id) }}" method="POST">

                        @csrf                        @csrf

                        @method('PUT')                        @method('PUT')



                        <div class="row">                        <div class="row">

                            <!-- Nama Lengkap -->                            <!-- Nama Lengkap -->

                            <div class="col-md-12 mb-3">                            <div class="col-md-12 mb-3">

                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>

                                <div class="input-group">                                <div class="input-group">

                                    <span class="input-group-text"><i class="fas fa-user"></i></span>                                    <span class="input-group-text"><i class="fas fa-user"></i></span>

                                    <input type="text" class="form-control @error('name') is-invalid @enderror"                                     <input type="text" class="form-control @error('name') is-invalid @enderror" 

                                           id="name" name="name" value="{{ old('name', $petani->name) }}"                                            id="name" name="name" value="{{ old('name') }}" 

                                           placeholder="Masukkan nama lengkap petani" required>                                           placeholder="Masukkan nama lengkap petani" required>

                                </div>                                </div>

                                @error('name')                                @error('name')

                                    <small class="text-danger">{{ $message }}</small>                                    <small class="text-danger">{{ $message }}</small>

                                @enderror                                @enderror

                            </div>                            </div>



                            <!-- Email -->                            <!-- Email -->

                            <div class="col-md-6 mb-3">                            <div class="col-md-6 mb-3">

                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>

                                <div class="input-group">                                <div class="input-group">

                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>

                                    <input type="email" class="form-control @error('email') is-invalid @enderror"                                     <input type="email" class="form-control @error('email') is-invalid @enderror" 

                                           id="email" name="email" value="{{ old('email', $petani->email) }}"                                            id="email" name="email" value="{{ old('email') }}" 

                                           placeholder="email@example.com" required>                                           placeholder="email@example.com" required>

                                </div>                                </div>

                                @error('email')                                @error('email')

                                    <small class="text-danger">{{ $message }}</small>                                    <small class="text-danger">{{ $message }}</small>

                                @enderror                                @enderror

                            </div>                            </div>



                            <!-- Telepon -->                            <!-- Telepon -->

                            <div class="col-md-6 mb-3">                            <div class="col-md-6 mb-3">

                                <label for="telepon" class="form-label">Nomor Telepon</label>                                <label for="telepon" class="form-label">Nomor Telepon</label>

                                <div class="input-group">                                <div class="input-group">

                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>

                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"                                     <input type="text" class="form-control @error('telepon') is-invalid @enderror" 

                                           id="telepon" name="telepon" value="{{ old('telepon', $petani->telepon) }}"                                            id="telepon" name="telepon" value="{{ old('telepon') }}" 

                                           placeholder="08xxxxxxxxxx">                                           placeholder="08xxxxxxxxxx">

                                </div>                                </div>

                                @error('telepon')                                @error('telepon')

                                    <small class="text-danger">{{ $message }}</small>                                    <small class="text-danger">{{ $message }}</small>

                                @enderror                                @enderror

                            </div>                            </div>



                            <!-- Password -->                            <!-- Password -->

                            <div class="col-md-6 mb-3">                            <div class="col-md-6 mb-3">

                                <label for="password" class="form-label">Password Baru (Opsional)</label>                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>

                                <div class="input-group">                                <div class="input-group">

                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>

                                    <input type="password" class="form-control @error('password') is-invalid @enderror"                                     <input type="password" class="form-control @error('password') is-invalid @enderror" 

                                           id="password" name="password"                                            id="password" name="password" 

                                           placeholder="Kosongkan jika tidak ingin mengubah">                                           placeholder="Minimal 8 karakter" required>

                                </div>                                </div>

                                <small class="text-muted">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</small>                                @error('password')

                                @error('password')                                    <small class="text-danger">{{ $message }}</small>

                                    <small class="text-danger d-block">{{ $message }}</small>                                @enderror

                                @enderror                            </div>

                            </div>

                            <!-- Konfirmasi Password -->

                            <!-- Konfirmasi Password -->                            <div class="col-md-6 mb-3">

                            <div class="col-md-6 mb-3">                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>

                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>                                <div class="input-group">

                                <div class="input-group">                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>

                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>                                    <input type="password" class="form-control" 

                                    <input type="password" class="form-control"                                            id="password_confirmation" name="password_confirmation" 

                                           id="password_confirmation" name="password_confirmation"                                            placeholder="Ketik ulang password" required>

                                           placeholder="Ketik ulang password baru">                                </div>

                                </div>                            </div>

                            </div>

                            <!-- Alamat Desa -->

                            <!-- Alamat Desa -->                            <div class="col-md-6 mb-3">

                            <div class="col-md-6 mb-3">                                <label for="alamat_desa" class="form-label">Alamat Desa <span class="text-danger">*</span></label>

                                <label for="alamat_desa" class="form-label">Alamat Desa <span class="text-danger">*</span></label>                                <div class="input-group">

                                <div class="input-group">                                    <span class="input-group-text"><i class="fas fa-home"></i></span>

                                    <span class="input-group-text"><i class="fas fa-home"></i></span>                                    <input type="text" class="form-control @error('alamat_desa') is-invalid @enderror" 

                                    <input type="text" class="form-control @error('alamat_desa') is-invalid @enderror"                                            id="alamat_desa" name="alamat_desa" value="{{ old('alamat_desa') }}" 

                                           id="alamat_desa" name="alamat_desa" value="{{ old('alamat_desa', $petani->alamat_desa) }}"                                            placeholder="Nama desa" required>

                                           placeholder="Nama desa" required>                                </div>

                                </div>                                @error('alamat_desa')

                                @error('alamat_desa')                                    <small class="text-danger">{{ $message }}</small>

                                    <small class="text-danger">{{ $message }}</small>                                @enderror

                                @enderror                            </div>

                            </div>

                            <!-- Kecamatan -->

                            <!-- Kecamatan -->                            <div class="col-md-6 mb-3">

                            <div class="col-md-6 mb-3">                                <label for="alamat_kecamatan" class="form-label">Kecamatan</label>

                                <label for="alamat_kecamatan" class="form-label">Kecamatan</label>                                <div class="input-group">

                                <div class="input-group">                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>

                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>                                    <select class="form-select @error('alamat_kecamatan') is-invalid @enderror" 

                                    <select class="form-select @error('alamat_kecamatan') is-invalid @enderror"                                             id="alamat_kecamatan" name="alamat_kecamatan">

                                            id="alamat_kecamatan" name="alamat_kecamatan">                                        <option value="">Pilih Kecamatan</option>

                                        <option value="">Pilih Kecamatan</option>                                        <option value="Balige" {{ old('alamat_kecamatan') == 'Balige' ? 'selected' : '' }}>Balige</option>

                                        @php                                        <option value="Laguboti" {{ old('alamat_kecamatan') == 'Laguboti' ? 'selected' : '' }}>Laguboti</option>

                                            $kecamatans = ['Balige', 'Laguboti', 'Habinsaran', 'Ajibata', 'Lumban Julu', 'Porsea', 'Silaen', 'Pintu Pohan Meranti', 'Nassau', 'Siantar Narumonda', 'Bonatua Lunasi', 'Tampahan', 'Sigumpar', 'Harian', 'Bor-Bor', 'Uluan'];                                        <option value="Habinsaran" {{ old('alamat_kecamatan') == 'Habinsaran' ? 'selected' : '' }}>Habinsaran</option>

                                        @endphp                                        <option value="Ajibata" {{ old('alamat_kecamatan') == 'Ajibata' ? 'selected' : '' }}>Ajibata</option>

                                        @foreach($kecamatans as $kec)                                        <option value="Lumban Julu" {{ old('alamat_kecamatan') == 'Lumban Julu' ? 'selected' : '' }}>Lumban Julu</option>

                                            <option value="{{ $kec }}" {{ old('alamat_kecamatan', $petani->alamat_kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>                                        <option value="Porsea" {{ old('alamat_kecamatan') == 'Porsea' ? 'selected' : '' }}>Porsea</option>

                                        @endforeach                                        <option value="Silaen" {{ old('alamat_kecamatan') == 'Silaen' ? 'selected' : '' }}>Silaen</option>

                                    </select>                                        <option value="Pintu Pohan Meranti" {{ old('alamat_kecamatan') == 'Pintu Pohan Meranti' ? 'selected' : '' }}>Pintu Pohan Meranti</option>

                                </div>                                        <option value="Nassau" {{ old('alamat_kecamatan') == 'Nassau' ? 'selected' : '' }}>Nassau</option>

                                @error('alamat_kecamatan')                                        <option value="Siantar Narumonda" {{ old('alamat_kecamatan') == 'Siantar Narumonda' ? 'selected' : '' }}>Siantar Narumonda</option>

                                    <small class="text-danger">{{ $message }}</small>                                        <option value="Bonatua Lunasi" {{ old('alamat_kecamatan') == 'Bonatua Lunasi' ? 'selected' : '' }}>Bonatua Lunasi</option>

                                @enderror                                        <option value="Tampahan" {{ old('alamat_kecamatan') == 'Tampahan' ? 'selected' : '' }}>Tampahan</option>

                            </div>                                        <option value="Sigumpar" {{ old('alamat_kecamatan') == 'Sigumpar' ? 'selected' : '' }}>Sigumpar</option>

                                                                    <option value="Harian" {{ old('alamat_kecamatan') == 'Harian' ? 'selected' : '' }}>Harian</option>

                            <!-- Status Verifikasi -->                                        <option value="Bor-Bor" {{ old('alamat_kecamatan') == 'Bor-Bor' ? 'selected' : '' }}>Bor-Bor</option>

                            <div class="col-md-12 mb-3">                                        <option value="Uluan" {{ old('alamat_kecamatan') == 'Uluan' ? 'selected' : '' }}>Uluan</option>

                                <label class="form-label">Status Verifikasi</label>                                    </select>

                                <div class="form-check form-switch">                                </div>

                                    <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified"                                 @error('alamat_kecamatan')

                                           value="1" {{ old('is_verified', $petani->is_verified) ? 'checked' : '' }}>                                    <small class="text-danger">{{ $message }}</small>

                                    <label class="form-check-label" for="is_verified">                                @enderror

                                        Terverifikasi                            </div>

                                        @if($petani->is_verified)                        </div>

                                            <span class="badge bg-success ms-2">Aktif</span>

                                        @else                        <!-- Info Box -->

                                            <span class="badge bg-warning text-dark ms-2">Pending</span>                        <div class="alert alert-info mt-3">

                                        @endif                            <i class="fas fa-info-circle me-2"></i>

                                    </label>                            <strong>Informasi:</strong> Petani yang didaftarkan oleh admin akan langsung terverifikasi dan bisa login ke sistem.

                                </div>                        </div>

                                <small class="text-muted">

                                    Centang untuk memverifikasi petani. Petani yang terverifikasi bisa login ke sistem.                        <!-- Buttons -->

                                </small>                        <div class="d-flex justify-content-end gap-2 mt-4">

                            </div>                            <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">

                        </div>                                <i class="fas fa-times me-2"></i>Batal

                            </a>

                        <!-- Buttons -->                            <button type="submit" class="btn btn-success">

                        <div class="d-flex justify-content-end gap-2 mt-4">                                <i class="fas fa-save me-2"></i>Simpan Petani

                            <a href="{{ route('admin.petani.index') }}" class="btn btn-secondary">                            </button>

                                <i class="fas fa-times me-2"></i>Batal                        </div>

                            </a>                    </form>

                            <button type="submit" class="btn btn-success">                </div>

                                <i class="fas fa-save me-2"></i>Update Petani            </div>

                            </button>        </div>

                        </div>    </div>

                    </form></div>

                </div>@endsection

            </div>
        </div>
    </div>
</div>
@endsection
