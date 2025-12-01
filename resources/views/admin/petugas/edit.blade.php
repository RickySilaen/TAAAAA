@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
<style>
    .ptgs-container { padding: 24px; max-width: 900px; margin: 0 auto; }
    
    /* Header Card */
    .ptgs-header-card {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(245, 158, 11, 0.3);
    }
    .ptgs-header-card h1 {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .ptgs-header-card p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 14px;
    }
    .ptgs-header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    .ptgs-header-icon i {
        font-size: 24px;
        color: #fff;
    }
    .ptgs-btn-back {
        background: #fff;
        color: #f59e0b;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
    }
    .ptgs-btn-back:hover {
        background: #fffbeb;
        color: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Form Card */
    .ptgs-form-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .ptgs-form-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
    }
    .ptgs-form-header h5 {
        color: #1e293b;
        margin: 0 0 4px 0;
        font-weight: 600;
        font-size: 18px;
    }
    .ptgs-form-header p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }
    .ptgs-form-body {
        padding: 32px;
    }

    /* Form Elements */
    .ptgs-form-group {
        margin-bottom: 24px;
    }
    .ptgs-form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
        font-size: 14px;
    }
    .ptgs-form-label .required {
        color: #ef4444;
    }
    .ptgs-input-wrapper {
        position: relative;
    }
    .ptgs-input-wrapper .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }
    .ptgs-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        transition: all 0.3s;
        background: #fff;
    }
    .ptgs-input:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }
    .ptgs-input::placeholder {
        color: #94a3b8;
    }
    .ptgs-input.is-invalid {
        border-color: #ef4444;
    }
    .ptgs-toggle-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px;
    }
    .ptgs-toggle-btn:hover {
        color: #f59e0b;
    }
    .ptgs-error {
        color: #ef4444;
        font-size: 13px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ptgs-hint {
        color: #64748b;
        font-size: 13px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Alert */
    .ptgs-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .ptgs-alert.warning {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .ptgs-alert.danger {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .ptgs-alert i {
        font-size: 20px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .ptgs-alert-content strong {
        display: block;
        margin-bottom: 4px;
    }

    /* Buttons */
    .ptgs-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
    }
    .ptgs-btn {
        padding: 14px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .ptgs-btn.secondary {
        background: #f1f5f9;
        color: #475569;
    }
    .ptgs-btn.secondary:hover {
        background: #e2e8f0;
    }
    .ptgs-btn.primary {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
    }
    .ptgs-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    /* Row Grid */
    .ptgs-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    @media (max-width: 768px) {
        .ptgs-row { grid-template-columns: 1fr; }
    }
</style>

<div class="ptgs-container">
    <!-- Header Card -->
    <div class="ptgs-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 16px;">
            <div class="d-flex align-items-center">
                <div class="ptgs-header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h1>Edit Data Petugas</h1>
                    <p>Perbarui informasi petugas: {{ $petugas->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.petugas.index') }}" class="ptgs-btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="ptgs-form-card">
        <div class="ptgs-form-header">
            <h5><i class="fas fa-edit me-2"></i>Form Edit Petugas</h5>
            <p>Update data petugas. Field dengan tanda <span style="color: #ef4444;">*</span> wajib diisi</p>
        </div>
        <div class="ptgs-form-body">
            @if ($errors->any())
            <div class="ptgs-alert danger">
                <i class="fas fa-exclamation-circle"></i>
                <div class="ptgs-alert-content">
                    <strong>Terjadi kesalahan!</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="ptgs-alert warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="ptgs-alert-content">
                    <strong>Perhatian</strong>
                    <span>Jika Anda mengubah password, petugas harus menggunakan password baru untuk login. Kosongkan field password jika tidak ingin mengubah.</span>
                </div>
            </div>

            <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Lengkap -->
                <div class="ptgs-form-group">
                    <label class="ptgs-form-label">
                        <i class="fas fa-user" style="color: #667eea;"></i>
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <div class="ptgs-input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" class="ptgs-input @error('name') is-invalid @enderror" 
                               value="{{ old('name', $petugas->name) }}" placeholder="Masukkan nama lengkap petugas" required>
                    </div>
                    @error('name')
                    <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ptgs-row">
                    <!-- Email -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-envelope" style="color: #3b82f6;"></i>
                            Email <span class="required">*</span>
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="ptgs-input @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $petugas->email) }}" placeholder="email@example.com" required>
                        </div>
                        @error('email')
                        <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-phone" style="color: #10b981;"></i>
                            Nomor Telepon
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="text" name="telepon" class="ptgs-input @error('telepon') is-invalid @enderror" 
                                   value="{{ old('telepon', $petugas->telepon) }}" placeholder="08123456789">
                        </div>
                        @error('telepon')
                        <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="ptgs-row">
                    <!-- Password -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-lock" style="color: #ef4444;"></i>
                            Password Baru
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="ptgs-input @error('password') is-invalid @enderror" 
                                   placeholder="Kosongkan jika tidak mengubah">
                            <button type="button" class="ptgs-toggle-btn" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <div class="ptgs-hint"><i class="fas fa-info-circle"></i> Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.</div>
                        @error('password')
                        <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-lock" style="color: #ef4444;"></i>
                            Konfirmasi Password Baru
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="ptgs-input" 
                                   placeholder="Ulangi password baru">
                            <button type="button" class="ptgs-toggle-btn" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="togglePassword_confirmationIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="ptgs-row">
                    <!-- Alamat Desa -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-map-marker-alt" style="color: #f59e0b;"></i>
                            Alamat Desa <span class="required">*</span>
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                            <input type="text" name="alamat_desa" class="ptgs-input @error('alamat_desa') is-invalid @enderror" 
                                   value="{{ old('alamat_desa', $petugas->alamat_desa) }}" placeholder="Nama desa" required>
                        </div>
                        @error('alamat_desa')
                        <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Kecamatan -->
                    <div class="ptgs-form-group">
                        <label class="ptgs-form-label">
                            <i class="fas fa-map" style="color: #64748b;"></i>
                            Alamat Kecamatan
                        </label>
                        <div class="ptgs-input-wrapper">
                            <i class="fas fa-map input-icon"></i>
                            <input type="text" name="alamat_kecamatan" class="ptgs-input @error('alamat_kecamatan') is-invalid @enderror" 
                                   value="{{ old('alamat_kecamatan', $petugas->alamat_kecamatan) }}" placeholder="Nama kecamatan">
                        </div>
                        @error('alamat_kecamatan')
                        <div class="ptgs-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="ptgs-form-actions">
                    <a href="{{ route('admin.petugas.index') }}" class="ptgs-btn secondary">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="ptgs-btn primary">
                        <i class="fas fa-save"></i>
                        <span>Update Petugas</span>
                    </button>
                </div>
            </form>
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
