@extends('layouts.app')

@section('title', 'Profil - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3 bg-gradient-success text-white">
                    <h6 class="mb-0">👤 Profil Pengguna</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="profileImage" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/bruce-mars.jpg') }}" alt="Profile Picture" class="avatar avatar-lg rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" onclick="document.getElementById('profile_picture').click()" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p class="text-muted">{{ ucfirst($user->role) }}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <strong>Nama:</strong> {{ $user->name }}
                                    </div>
                                    <div class="info-item mb-3">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <strong>Email:</strong> {{ $user->email }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if($user->role == 'petani')
                                        <div class="info-item mb-3">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <strong>Alamat Desa:</strong> {{ $user->alamat_desa ?: 'Belum diisi' }}
                                        </div>
                                        <div class="info-item mb-3">
                                            <i class="fas fa-seedling text-primary me-2"></i>
                                            <strong>Luas Lahan:</strong> {{ $user->luas_lahan ? $user->luas_lahan . ' ha' : 'Belum diisi' }}
                                        </div>
                                    @endif
                                    <div class="info-item mb-3">
                                        <i class="fas fa-user-tag text-primary me-2"></i>
                                        <strong>Role:</strong> {{ ucfirst($user->role) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0 p-3 bg-gradient-success text-white">
                    <h6 class="mb-0">✏️ Edit Profil</h6>
                </div>
                <div class="card-body p-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(request()->routeIs('profile.show'))
                        <form method="POST" action="{{ route('update.user.profile', $user->id) }}" onsubmit="return confirm('Yakin update profil?')" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('update.profile') }}" onsubmit="return confirm('Yakin update profil?')" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label"><i class="fas fa-user text-primary me-1"></i>Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-1"></i>Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Masukkan alamat email" required>
                                    @error('email')
                                        <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="profile_picture" class="form-label"><i class="fas fa-camera text-primary me-1"></i>Foto Profil (Opsional)</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-primary me-2" onclick="document.getElementById('profile_picture').click()">
                                            <i class="fas fa-camera me-1"></i>Pilih Foto
                                        </button>
                                        <small class="text-muted">Pilih file gambar (JPG, PNG, dll.)</small>
                                    </div>
                                    @error('profile_picture')
                                        <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label"><i class="fas fa-lock text-primary me-1"></i>Password Baru (Opsional)</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label"><i class="fas fa-lock text-primary me-1"></i>Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                                    @error('password_confirmation')
                                        <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($user->role == 'petani')
                                    <div class="form-group mb-3">
                                        <label for="alamat_desa" class="form-label"><i class="fas fa-map-marker-alt text-primary me-1"></i>Alamat Desa</label>
                                        <input type="text" class="form-control" id="alamat_desa" name="alamat_desa" value="{{ $user->alamat_desa }}" placeholder="Masukkan alamat desa">
                                        @error('alamat_desa')
                                            <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="luas_lahan" class="form-label"><i class="fas fa-seedling text-primary me-1"></i>Luas Lahan (ha)</label>
                                        <input type="number" step="0.01" class="form-control" id="luas_lahan" name="luas_lahan" value="{{ $user->luas_lahan }}" placeholder="Masukkan luas lahan dalam hektar">
                                        @error('luas_lahan')
                                            <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label"><i class="fas fa-user-tag text-primary me-1"></i>Role</label>
                                    <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            @if(request()->routeIs('profile.show'))
                                <a href="{{ route('petani.list') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Petani
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Profil</button>
                        </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function markAsRead(notificationId) {
        fetch('/notifications/' + notificationId + '/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }

    // Preview image before upload
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
