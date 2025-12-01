@extends('layouts.app')

@section('title', 'Profil - Sistem Pertanian')

@section('content')
<style>
    .profile-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    /* Hero Header */
    .profile-hero {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
        transform: rotate(-15deg);
        pointer-events: none;
    }
    
    .profile-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 40%;
        height: 150%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255,255,255,0.9);
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    
    .profile-avatar:hover {
        transform: scale(1.05);
    }
    
    .avatar-edit-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: 3px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    
    .avatar-edit-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
    }
    
    .profile-name {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin: 20px 0 8px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }
    
    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }
    
    .info-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    
    .info-card-icon.green {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    
    .info-card-icon.blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #2563eb;
    }
    
    .info-card-icon.purple {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #7c3aed;
    }
    
    .info-card-icon.orange {
        background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
        color: #ea580c;
    }
    
    .info-card-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 4px;
        font-weight: 500;
    }
    
    .info-card-value {
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 600;
        word-break: break-word;
    }
    
    /* Edit Form Section */
    .edit-section {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
    }
    
    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f3f4f6;
    }
    
    .section-title-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    
    .section-title h4 {
        margin: 0;
        color: #1f2937;
        font-weight: 700;
        font-size: 1.4rem;
    }
    
    .section-title p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    /* Form Styling */
    .form-group-modern {
        margin-bottom: 24px;
    }
    
    .form-label-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    
    .form-label-modern i {
        color: #22c55e;
        font-size: 1rem;
    }
    
    .form-control-modern {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        color: #1f2937;
        background: #fafafa;
        transition: all 0.3s ease;
    }
    
    .form-control-modern:focus {
        outline: none;
        border-color: #22c55e;
        background: white;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
    }
    
    .form-control-modern:read-only {
        background: #f3f4f6;
        cursor: not-allowed;
    }
    
    .form-control-modern::placeholder {
        color: #9ca3af;
    }
    
    /* File Upload */
    .file-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f9fafb;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .file-upload-wrapper:hover {
        border-color: #22c55e;
        background: #f0fdf4;
    }
    
    .file-upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .file-upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
    }
    
    .file-upload-info {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    /* Submit Button */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 32px;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(34, 197, 94, 0.4);
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: #e5e7eb;
        color: #1f2937;
    }
    
    /* Alert Styling */
    .alert-modern {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    
    .alert-modern.success {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border: 1px solid #86efac;
        color: #166534;
    }
    
    .alert-modern.error {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 1px solid #fca5a5;
        color: #991b1b;
    }
    
    .alert-modern i {
        font-size: 1.25rem;
        margin-top: 2px;
    }
    
    /* Password Section */
    .password-section {
        background: #f9fafb;
        border-radius: 16px;
        padding: 24px;
        margin-top: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .password-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        color: #374151;
        font-weight: 600;
    }
    
    .password-section-title i {
        color: #6b7280;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .profile-hero {
            padding: 24px;
            text-align: center;
        }
        
        .profile-hero .d-flex {
            justify-content: center;
        }
        
        .profile-name {
            font-size: 1.5rem;
        }
        
        .edit-section {
            padding: 20px;
        }
    }
</style>

<div class="profile-page">
    <div class="container-fluid px-4">
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert-modern success">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert-modern error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <!-- Profile Hero Section -->
        <div class="profile-hero">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center flex-wrap gap-4">
                        <div class="profile-avatar-wrapper">
                            <img id="profileImage" 
                                 src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/bruce-mars.jpg') }}" 
                                 alt="Profile Picture" 
                                 class="profile-avatar">
                            <div class="avatar-edit-btn" onclick="document.getElementById('profile_picture').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="profile-name">{{ $user->name }}</h1>
                            <span class="profile-role-badge">
                                @if($user->role == 'admin')
                                    <i class="fas fa-shield-alt"></i>
                                @elseif($user->role == 'petugas')
                                    <i class="fas fa-user-tie"></i>
                                @else
                                    <i class="fas fa-tractor"></i>
                                @endif
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="text-white-50" style="font-size: 0.9rem;">
                        <i class="fas fa-clock me-2"></i>
                        Bergabung: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Info Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-card-icon green">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-card-label">Nama Lengkap</div>
                    <div class="info-card-value">{{ $user->name }}</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-card-icon blue">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-card-label">Email</div>
                    <div class="info-card-value">{{ $user->email }}</div>
                </div>
            </div>
            @if($user->role == 'petani')
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-card-icon purple">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-card-label">Alamat Desa</div>
                        <div class="info-card-value">{{ $user->alamat_desa ?: 'Belum diisi' }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-card-icon orange">
                            <i class="fas fa-ruler-combined"></i>
                        </div>
                        <div class="info-card-label">Luas Lahan</div>
                        <div class="info-card-value">{{ $user->luas_lahan ? $user->luas_lahan . ' Hektar' : 'Belum diisi' }}</div>
                    </div>
                </div>
            @else
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-card-icon purple">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div class="info-card-label">Role Sistem</div>
                        <div class="info-card-value">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-card-icon orange">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="info-card-label">Terakhir Update</div>
                        <div class="info-card-value">{{ $user->updated_at ? $user->updated_at->format('d M Y') : '-' }}</div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Edit Profile Section -->
        <div class="edit-section">
            <div class="section-title">
                <div class="section-title-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h4>Edit Profil</h4>
                    <p>Perbarui informasi profil Anda</p>
                </div>
            </div>
            
            @if(request()->routeIs('profile.show'))
                <form method="POST" action="{{ route('update.user.profile', $user->id) }}" onsubmit="return confirm('Yakin ingin memperbarui profil?')" enctype="multipart/form-data">
            @else
                <form method="POST" action="{{ route('update.profile') }}" onsubmit="return confirm('Yakin ingin memperbarui profil?')" enctype="multipart/form-data">
            @endif
                @csrf
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" class="form-control-modern" name="name" value="{{ $user->name }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-envelope"></i>
                                Alamat Email
                            </label>
                            <input type="email" class="form-control-modern" name="email" value="{{ $user->email }}" placeholder="Masukkan alamat email" required>
                        </div>
                        
                        @if($user->role == 'petani')
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat Desa
                                </label>
                                <input type="text" class="form-control-modern" name="alamat_desa" value="{{ $user->alamat_desa }}" placeholder="Masukkan alamat desa">
                            </div>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-ruler-combined"></i>
                                    Luas Lahan (Hektar)
                                </label>
                                <input type="number" step="0.01" class="form-control-modern" name="luas_lahan" value="{{ $user->luas_lahan }}" placeholder="Contoh: 2.5">
                            </div>
                        @endif
                        
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-id-badge"></i>
                                Role
                            </label>
                            <input type="text" class="form-control-modern" value="{{ ucfirst($user->role) }}" readonly>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-lg-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-camera"></i>
                                Foto Profil
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="d-none" id="profile_picture" name="profile_picture" accept="image/*">
                                <button type="button" class="file-upload-btn" onclick="document.getElementById('profile_picture').click()">
                                    <i class="fas fa-upload"></i>
                                    Pilih Foto
                                </button>
                                <span class="file-upload-info" id="file-name">Format: JPG, PNG (Maks. 2MB)</span>
                            </div>
                        </div>
                        
                        <div class="password-section">
                            <div class="password-section-title">
                                <i class="fas fa-shield-alt"></i>
                                Ubah Password (Opsional)
                            </div>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-lock"></i>
                                    Password Baru
                                </label>
                                <input type="password" class="form-control-modern" name="password" placeholder="Masukkan password baru">
                            </div>
                            
                            <div class="form-group-modern mb-0">
                                <label class="form-label-modern">
                                    <i class="fas fa-lock"></i>
                                    Konfirmasi Password
                                </label>
                                <input type="password" class="form-control-modern" name="password_confirmation" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 2px solid #f3f4f6;">
                    @if(request()->routeIs('profile.show'))
                        <a href="{{ route('petani.list') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    @else
                        <div></div>
                    @endif
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview image before upload
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Update preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            // Update file name display
            document.getElementById('file-name').textContent = file.name;
        }
    });
</script>
@endsection
