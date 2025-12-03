@extends('layouts.app')

@section('title', 'Edit Bantuan - Sistem Pertanian')

@push('styles')
<style>
    /* Performance Optimizations */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .page-content {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, #f57c00 0%, #ef6c00 50%, #e65100 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(245, 124, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h60v60H0z" fill="none"/><path d="M30 0v60M0 30h60" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
        opacity: 0.3;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .page-title i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        margin-right: 1rem;
        font-size: 1.5rem;
    }

    .page-subtitle {
        color: rgba(255,255,255,0.95);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .header-badges {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .info-badge {
        background: rgba(255,255,255,0.95);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #f57c00;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .info-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .info-badge i {
        font-size: 1.2rem;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .form-card:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
    }

    /* Alert Messages */
    .alert-custom {
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-custom i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-label {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #f57c00;
        font-size: 1.1rem;
    }

    /* Form Controls */
    .form-control-custom,
    .form-select-custom {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: #f57c00;
        box-shadow: 0 0 0 4px rgba(245, 124, 0, 0.1);
        outline: none;
        background: #fff9f5;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23f57c00' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 3rem;
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 120px;
    }

    /* Error Messages */
    .text-danger {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }

    /* Action Buttons */
    .btn-action {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 124, 0, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(245, 124, 0, 0.4);
        background: linear-gradient(135deg, #ff8f00 0%, #f57c00 100%);
    }

    .btn-secondary-custom {
        background: white;
        color: #666;
        border: 2px solid #e0e0e0;
    }

    .btn-secondary-custom:hover {
        background: #f5f5f5;
        border-color: #ccc;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-back {
        background: white;
        color: #f57c00;
        border: 2px solid rgba(255,255,255,0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.95);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        color: #f57c00;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f0f0f0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-title i {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .header-badges {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column-reverse;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    /* Icon Fix - Ensure all icons are visible */
    i.fas, i.fa {
        font-style: normal;
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-edit"></i>
                            Edit Bantuan
                        </h1>
                        <p class="page-subtitle mb-3">Perbarui informasi bantuan pertanian</p>
                        <div class="header-badges">
                            <div class="info-badge">
                                <i class="fas fa-seedling"></i>
                                <span>{{ $bantuan->jenis_bantuan }}</span>
                            </div>
                            <div class="info-badge">
                                <i class="fas fa-hashtag"></i>
                                <span>{{ $bantuan->jumlah }} unit</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('daftar.bantuan') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>


        <!-- Form Section -->
        <div class="form-card">
            @if (session('success'))
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('update.bantuan', $bantuan->id) }}" onsubmit="return confirm('Yakin memperbarui data bantuan ini?')">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_bantuan" class="form-label">
                                <i class="fas fa-seedling"></i>
                                Jenis Bantuan
                            </label>
                            <select class="form-select-custom" id="jenis_bantuan" name="jenis_bantuan" required>
                                <option value="">Pilih Jenis Bantuan</option>
                                <option value="Bibit" {{ $bantuan->jenis_bantuan == 'Bibit' ? 'selected' : '' }}>Bibit</option>
                                <option value="Pupuk" {{ $bantuan->jenis_bantuan == 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="Pestisida" {{ $bantuan->jenis_bantuan == 'Pestisida' ? 'selected' : '' }}>Pestisida</option>
                                <option value="Alat" {{ $bantuan->jenis_bantuan == 'Alat' ? 'selected' : '' }}>Alat</option>
                                <option value="Lainnya" {{ $bantuan->jenis_bantuan == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_bantuan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah" class="form-label">
                                <i class="fas fa-hashtag"></i>
                                Jumlah
                            </label>
                            <input type="number" class="form-control-custom" id="jumlah" name="jumlah" value="{{ $bantuan->jumlah }}" min="1" required placeholder="Masukkan jumlah">
                            @error('jumlah')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle"></i>
                                Status
                            </label>
                            <select class="form-select-custom" id="status" name="status" required>
                                <option value="Diproses" {{ $bantuan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Dikirim" {{ $bantuan->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal" class="form-label">
                                <i class="fas fa-calendar"></i>
                                Tanggal
                            </label>
                            <input type="date" class="form-control-custom" id="tanggal" name="tanggal" value="{{ $bantuan->tanggal }}" required>
                            @error('tanggal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="catatan" class="form-label">
                                <i class="fas fa-sticky-note"></i>
                                Catatan
                            </label>
                            <textarea class="form-control-custom" id="catatan" name="catatan" rows="4" placeholder="Tambahkan catatan jika diperlukan">{{ $bantuan->catatan }}</textarea>
                            @error('catatan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('daftar.bantuan') }}" class="btn-action btn-secondary-custom">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-action btn-primary-custom">
                        <i class="fas fa-save"></i>
                        Perbarui Bantuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    // Add real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#4caf50';
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.borderColor = '#f57c00';
        });
    });
    
    // Auto-save draft (optional feature)
    let autoSaveTimeout;
    const formInputs = form.querySelectorAll('input, select, textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveDraft();
            }, 2000);
        });
    });
    
    function saveDraft() {
        const formData = {
            jenis_bantuan: document.getElementById('jenis_bantuan').value,
            jumlah: document.getElementById('jumlah').value,
            status: document.getElementById('status').value,
            tanggal: document.getElementById('tanggal').value,
            catatan: document.getElementById('catatan').value
        };
        localStorage.setItem('bantuan_draft_{{ $bantuan->id }}', JSON.stringify(formData));
    }
    
    // Load draft if exists
    const savedDraft = localStorage.getItem('bantuan_draft_{{ $bantuan->id }}');
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        const confirmLoad = confirm('Ada perubahan yang belum tersimpan. Muat data terakhir?');
        if (confirmLoad) {
            Object.keys(draft).forEach(key => {
                const element = document.getElementById(key);
                if (element && draft[key]) {
                    element.value = draft[key];
                }
            });
        }
    }
    
    // Clear draft on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('bantuan_draft_{{ $bantuan->id }}');
    });
    
    // Number input validation
    const jumlahInput = document.getElementById('jumlah');
    jumlahInput.addEventListener('input', function() {
        if (this.value < 1) {
            this.value = 1;
        }
    });
    
    // Date validation
    const tanggalInput = document.getElementById('tanggal');
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.setAttribute('max', today);
});
</script>
@endpush
