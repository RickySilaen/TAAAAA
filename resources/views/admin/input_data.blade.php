@extends('layouts.app')

@section('title', 'Input Data - Sistem Pertanian')

@section('content')
<style>
    /* Modern Card Styles */
    .input-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .input-card:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }
    
    /* Header Gradient - Unified Green Theme */
    .header-gradient {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .header-gradient::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(30deg);
        pointer-events: none;
    }
    
    .header-icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    /* Tab Switcher */
    .tab-switcher {
        background: #f8fafc;
        border-radius: 16px;
        padding: 6px;
        display: inline-flex;
        gap: 4px;
    }
    
    .tab-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .tab-btn.tab-bantuan {
        background: transparent;
        color: #64748b;
    }
    
    .tab-btn.tab-bantuan.active {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    
    .tab-btn.tab-laporan {
        background: transparent;
        color: #64748b;
    }
    
    .tab-btn.tab-laporan.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    /* Section Cards */
    .section-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .section-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .section-header {
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .section-header.primary {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .section-header.success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .section-header.info {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%);
        border-color: rgba(6, 182, 212, 0.2);
    }
    
    .section-header.warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
        border-color: rgba(245, 158, 11, 0.2);
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    .section-icon.primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }
    
    .section-icon.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .section-icon.info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }
    
    .section-icon.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .section-title {
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
    }
    
    .section-title.primary { color: #1d4ed8; }
    .section-title.success { color: #059669; }
    .section-title.info { color: #0891b2; }
    .section-title.warning { color: #d97706; }
    
    .section-body {
        padding: 24px;
    }
    
    /* Form Controls */
    .form-label-modern {
        font-weight: 600;
        color: #334155;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label-modern i {
        font-size: 0.85rem;
    }
    
    .form-label-modern .required {
        color: #ef4444;
        font-weight: 700;
    }
    
    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }
    
    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .form-control-modern::placeholder {
        color: #94a3b8;
    }
    
    /* Input Group Modern */
    .input-group-modern {
        display: flex;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .input-group-modern:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    .input-group-modern .form-control {
        border: none;
        padding: 14px 18px;
        font-size: 1rem;
    }
    
    .input-group-modern .form-control:focus {
        box-shadow: none;
    }
    
    .input-group-modern .input-suffix {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-reset {
        background: #f1f5f9;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }
    
    .btn-reset:hover {
        background: #e2e8f0;
        color: #475569;
    }
    
    .btn-preview {
        background: white;
        border: 2px solid #3b82f6;
        color: #3b82f6;
    }
    
    .btn-preview:hover {
        background: rgba(59, 130, 246, 0.1);
    }
    
    .btn-submit-bantuan {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    
    .btn-submit-bantuan:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
        color: white;
    }
    
    .btn-submit-laporan {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-submit-laporan:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        color: white;
    }
    
    /* Error Message */
    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Animations */
    .form-section {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .tab-switcher {
            width: 100%;
        }
        
        .tab-btn {
            flex: 1;
            justify-content: center;
            padding: 10px 16px;
        }
        
        .section-body {
            padding: 16px;
        }
        
        .btn-action {
            padding: 12px 20px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="header-gradient p-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-3">
                            <div class="header-icon-wrapper me-3">
                                <i class="fas fa-database fa-2x text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-white mb-1 fw-bold">Input Data Terpadu</h2>
                                <p class="text-white-50 mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kelola data bantuan dan laporan pertanian dalam satu tempat
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <i class="fas fa-clipboard-list fa-4x text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="input-card">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">
                                <i class="fas fa-edit text-primary me-2"></i>Form Input Data
                            </h5>
                            <p class="text-muted mb-0 small">Pilih jenis data yang akan diinput</p>
                        </div>
                        <div class="tab-switcher">
                            <button type="button" class="tab-btn tab-bantuan tab-button active" id="tabBantuan" data-tab="bantuan">
                                <i class="fas fa-hand-holding-heart"></i>
                                <span>Bantuan</span>
                            </button>
                            <button type="button" class="tab-btn tab-laporan tab-button" id="tabLaporan" data-tab="laporan">
                                <i class="fas fa-file-alt"></i>
                                <span>Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle fa-lg me-3"></i>
                                </div>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                                </div>
                                <div>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form Input Bantuan -->
                    <div id="formBantuan" class="form-section">
                        <form action="{{ route('store.bantuan') }}" method="POST" id="bantuanForm" novalidate>
                            @csrf
                            
                            <!-- Informasi Bantuan Section -->
                            <div class="section-card">
                                <div class="section-header primary">
                                    <div class="section-icon primary">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </div>
                                    <h6 class="section-title primary">Informasi Bantuan</h6>
                                </div>
                                <div class="section-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-seedling text-primary"></i>
                                                Jenis Bantuan
                                                <span class="required">*</span>
                                            </label>
                                            <select class="form-select form-select-modern" id="jenis_bantuan" name="jenis_bantuan" required>
                                                <option value="">Pilih Jenis Bantuan</option>
                                                <option value="Bibit" {{ old('jenis_bantuan') == 'Bibit' ? 'selected' : '' }}>🌱 Bibit</option>
                                                <option value="Pupuk" {{ old('jenis_bantuan') == 'Pupuk' ? 'selected' : '' }}>🧪 Pupuk</option>
                                                <option value="Pestisida" {{ old('jenis_bantuan') == 'Pestisida' ? 'selected' : '' }}>🧴 Pestisida</option>
                                                <option value="Alat" {{ old('jenis_bantuan') == 'Alat' ? 'selected' : '' }}>🔧 Alat</option>
                                            </select>
                                            @error('jenis_bantuan')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-hashtag text-primary"></i>
                                                Jumlah
                                                <span class="required">*</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" min="1" required>
                                                <span class="input-suffix">
                                                    <i class="fas fa-boxes"></i> unit
                                                </span>
                                            </div>
                                            @error('jumlah')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status dan Tanggal Section -->
                            <div class="section-card">
                                <div class="section-header info">
                                    <div class="section-icon info">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h6 class="section-title info">Status dan Tanggal</h6>
                                </div>
                                <div class="section-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-tasks text-info"></i>
                                                Status
                                                <span class="required">*</span>
                                            </label>
                                            <select class="form-select form-select-modern" id="status" name="status" required>
                                                <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>⏳ Diproses</option>
                                                <option value="Dikirim" {{ old('status') == 'Dikirim' ? 'selected' : '' }}>🚚 Dikirim</option>
                                            </select>
                                            @error('status')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-calendar text-info"></i>
                                                Tanggal
                                                <span class="required">*</span>
                                            </label>
                                            <input type="date" class="form-control form-control-modern" id="tanggal_bantuan" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                            @error('tanggal')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Section -->
                            <div class="section-card">
                                <div class="section-header warning">
                                    <div class="section-icon warning">
                                        <i class="fas fa-sticky-note"></i>
                                    </div>
                                    <h6 class="section-title warning">Catatan Tambahan (Opsional)</h6>
                                </div>
                                <div class="section-body">
                                    <label class="form-label-modern">
                                        <i class="fas fa-comment text-warning"></i>
                                        Catatan
                                    </label>
                                    <textarea class="form-control form-control-modern" id="catatan_laporan" name="catatan_laporan" rows="3" placeholder="Tambahkan catatan tambahan jika ada...">{{ old('catatan_laporan') }}</textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4 pt-3">
                                <button type="button" class="btn btn-action btn-reset" onclick="resetForm('bantuanForm')">
                                    <i class="fas fa-undo"></i>Reset
                                </button>
                                <button type="button" class="btn btn-action btn-preview" onclick="previewBantuan()">
                                    <i class="fas fa-eye"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-action btn-submit-bantuan">
                                    <i class="fas fa-paper-plane"></i>Simpan Bantuan
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Form Input Laporan -->
                    <div id="formLaporan" class="form-section" style="display: none;">
                        <form action="{{ route('store.laporan') }}" method="POST" id="laporanForm" novalidate>
                            @csrf
                            
                            <!-- Informasi Dasar Section -->
                            <div class="section-card">
                                <div class="section-header success">
                                    <div class="section-icon success">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                    <h6 class="section-title success">Informasi Dasar</h6>
                                </div>
                                <div class="section-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-leaf text-success"></i>
                                                Jenis Tanaman
                                                <span class="required">*</span>
                                            </label>
                                            <select class="form-select form-select-modern" id="jenis_tanaman" name="jenis_tanaman" required>
                                                <option value="">Pilih Jenis Tanaman</option>
                                                <option value="Padi" {{ old('jenis_tanaman') == 'Padi' ? 'selected' : '' }}>🌾 Padi</option>
                                                <option value="Jagung" {{ old('jenis_tanaman') == 'Jagung' ? 'selected' : '' }}>🌽 Jagung</option>
                                                <option value="Kedelai" {{ old('jenis_tanaman') == 'Kedelai' ? 'selected' : '' }}>🫘 Kedelai</option>
                                                <option value="Ubi" {{ old('jenis_tanaman') == 'Ubi' ? 'selected' : '' }}>🍠 Ubi</option>
                                                <option value="Cabe" {{ old('jenis_tanaman') == 'Cabe' ? 'selected' : '' }}>🌶️ Cabe</option>
                                                <option value="Tomat" {{ old('jenis_tanaman') == 'Tomat' ? 'selected' : '' }}>🍅 Tomat</option>
                                                <option value="Lainnya" {{ old('jenis_tanaman') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                            </select>
                                            @error('jenis_tanaman')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-calendar text-success"></i>
                                                Tanggal Laporan
                                                <span class="required">*</span>
                                            </label>
                                            <input type="date" class="form-control form-control-modern" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                            @error('tanggal')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Panen Section -->
                            <div class="section-card">
                                <div class="section-header primary">
                                    <div class="section-icon primary">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h6 class="section-title primary">Data Hasil Panen</h6>
                                </div>
                                <div class="section-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-weight text-primary"></i>
                                                Hasil Panen (kg)
                                                <span class="required">*</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <input type="number" class="form-control" id="hasil_panen" name="hasil_panen" value="{{ old('hasil_panen') }}" placeholder="Masukkan hasil panen" min="0" step="0.01" required>
                                                <span class="input-suffix">
                                                    <i class="fas fa-weight-hanging"></i> kg
                                                </span>
                                            </div>
                                            @error('hasil_panen')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-modern">
                                                <i class="fas fa-ruler-combined text-primary"></i>
                                                Luas Area Dipanen (ha)
                                            </label>
                                            <div class="input-group-modern">
                                                <input type="number" class="form-control" id="luas_panen" name="luas_panen" value="{{ old('luas_panen') }}" placeholder="Masukkan luas area" min="0" step="0.01">
                                                <span class="input-suffix">
                                                    <i class="fas fa-map-marked-alt"></i> ha
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi Kemajuan Section -->
                            <div class="section-card">
                                <div class="section-header info">
                                    <div class="section-icon info">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <h6 class="section-title info">Deskripsi Kemajuan Pertanian</h6>
                                </div>
                                <div class="section-body">
                                    <label class="form-label-modern">
                                        <i class="fas fa-edit text-info"></i>
                                        Deskripsi Kemajuan
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control form-control-modern" id="deskripsi_kemajuan" name="deskripsi_kemajuan" rows="5" placeholder="Jelaskan kondisi tanaman, perawatan, dan rencana..." required>{{ old('deskripsi_kemajuan') }}</textarea>
                                    @error('deskripsi_kemajuan')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan Section -->
                            <div class="section-card">
                                <div class="section-header warning">
                                    <div class="section-icon warning">
                                        <i class="fas fa-sticky-note"></i>
                                    </div>
                                    <h6 class="section-title warning">Catatan Tambahan (Opsional)</h6>
                                </div>
                                <div class="section-body">
                                    <label class="form-label-modern">
                                        <i class="fas fa-comment text-warning"></i>
                                        Catatan
                                    </label>
                                    <textarea class="form-control form-control-modern" id="catatan" name="catatan" rows="3" placeholder="Cuaca, masalah, saran...">{{ old('catatan') }}</textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4 pt-3">
                                <button type="button" class="btn btn-action btn-reset" onclick="resetForm('laporanForm')">
                                    <i class="fas fa-undo"></i>Reset
                                </button>
                                <button type="button" class="btn btn-action btn-preview" onclick="previewLaporan()">
                                    <i class="fas fa-eye"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-action btn-submit-laporan">
                                    <i class="fas fa-paper-plane"></i>Simpan Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // === TAB SWITCHING ===
    function switchTab(type) {
        const bantuanForm = document.getElementById('formBantuan');
        const laporanForm = document.getElementById('formLaporan');
        const activeForm = type === 'bantuan' ? bantuanForm : laporanForm;
        const inactiveForm = type === 'bantuan' ? laporanForm : bantuanForm;

        activeForm.querySelectorAll('input, select, textarea').forEach(f => f.disabled = false);
        inactiveForm.querySelectorAll('input, select, textarea').forEach(f => f.disabled = true);

        bantuanForm.style.display = type === 'bantuan' ? 'block' : 'none';
        laporanForm.style.display = type === 'laporan' ? 'block' : 'none';

        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === type);
        });
    }

    // === RESET FORM ===
    function resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            showAlert('Form berhasil direset', 'success');
        }
    }

    // === PREVIEW BANTUAN ===
    function previewBantuan() {
        const jenis = document.getElementById('jenis_bantuan').value;
        const jumlah = document.getElementById('jumlah').value;
        const status = document.getElementById('status').value;
        const tanggal = document.getElementById('tanggal_bantuan').value;
        const catatan = document.getElementById('catatan_laporan').value;

        if (!jenis || !jumlah || !status || !tanggal) {
            showAlert('Lengkapi field wajib untuk preview!', 'warning');
            return;
        }

        const content = `
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 p-4 mb-3">
                    <i class="fas fa-hand-holding-heart text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold">Preview Data Bantuan</h4>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Jenis Bantuan</small>
                        <strong class="text-dark">${jenis}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Jumlah</small>
                        <strong class="text-dark">${jumlah} unit</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Status</small>
                        <strong class="text-dark">${status}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Tanggal</small>
                        <strong class="text-dark">${new Date(tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</strong>
                    </div>
                </div>
                ${catatan ? `<div class="col-12"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block mb-1">Catatan</small><p class="mb-0 text-dark">${catatan}</p></div></div>` : ''}
            </div>
        `;
        showModal('Preview Bantuan', content, 'primary');
    }

    // === PREVIEW LAPORAN ===
    function previewLaporan() {
        const jenis = document.getElementById('jenis_tanaman').value;
        const hasil = document.getElementById('hasil_panen').value;
        const luas = document.getElementById('luas_panen').value;
        const tanggal = document.getElementById('tanggal').value;
        const deskripsi = document.getElementById('deskripsi_kemajuan').value;
        const catatan = document.getElementById('catatan').value;

        if (!jenis || !hasil || !tanggal || !deskripsi) {
            showAlert('Lengkapi field wajib untuk preview!', 'warning');
            return;
        }

        const content = `
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 p-4 mb-3">
                    <i class="fas fa-file-alt text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold">Preview Data Laporan</h4>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Jenis Tanaman</small>
                        <strong class="text-dark">${jenis}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Hasil Panen</small>
                        <strong class="text-dark">${hasil} kg</strong>
                    </div>
                </div>
                ${luas ? `<div class="col-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block mb-1">Luas Area</small><strong class="text-dark">${luas} ha</strong></div></div>` : ''}
                <div class="col-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Tanggal</small>
                        <strong class="text-dark">${new Date(tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block mb-1">Deskripsi Kemajuan</small>
                        <p class="mb-0 text-dark">${deskripsi}</p>
                    </div>
                </div>
                ${catatan ? `<div class="col-12"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block mb-1">Catatan</small><p class="mb-0 text-dark">${catatan}</p></div></div>` : ''}
            </div>
        `;
        showModal('Preview Laporan', content, 'success');
    }

    // === MODAL ===
    function showModal(title, content, color = 'primary') {
        const existingModal = document.getElementById('previewModal');
        if (existingModal) existingModal.remove();
        
        const gradientClass = color === 'success' 
            ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);'
            : 'background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);';
            
        const modalHtml = `
            <div class="modal fade" id="previewModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                        <div class="modal-header border-0 text-white py-3" style="${gradientClass}">
                            <h5 class="modal-title fw-bold"><i class="fas fa-eye me-2"></i>${title}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">${content}</div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
        document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // === ALERT ===
    function showAlert(message, type = 'info') {
        const iconMap = {
            success: 'check-circle',
            warning: 'exclamation-triangle',
            danger: 'times-circle',
            info: 'info-circle'
        };
        const colorMap = {
            success: 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
            warning: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
            danger: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
            info: 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)'
        };
        
        const alertHtml = `
            <div class="toast-alert position-fixed d-flex align-items-center text-white px-4 py-3 rounded-pill shadow-lg" 
                 style="top: 20px; right: 20px; z-index: 9999; background: ${colorMap[type]}; animation: slideIn 0.3s ease;">
                <i class="fas fa-${iconMap[type]} me-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        setTimeout(() => document.querySelector('.toast-alert')?.remove(), 3000);
    }

    // === DOM LOADED ===
    document.addEventListener('DOMContentLoaded', function () {
        // Tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', () => switchTab(btn.dataset.tab));
        });

        // Submit handler
        ['bantuanForm', 'laporanForm'].forEach(id => {
            const form = document.getElementById(id);
            if (form) {
                form.addEventListener('submit', function (e) {
                    this.querySelectorAll('input, select, textarea').forEach(f => f.disabled = false);
                });
            }
        });

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                if (bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    });
</script>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endsection