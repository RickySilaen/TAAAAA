@extends('layouts.app')

@section('title', 'Edit Permintaan Bantuan')

@section('content')
<style>
    .frm-container { padding: 24px; max-width: 800px; margin: 0 auto; }
    
    .frm-header-card {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(245, 158, 11, 0.3);
    }
    
    .frm-header-card h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .frm-header-card p { color: rgba(255,255,255,0.85); margin: 0; font-size: 14px; }
    
    .frm-header-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px; font-size: 28px;
    }
    
    .frm-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .frm-card-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
    }
    .frm-card-header h5 { margin: 0; font-weight: 600; color: #92400e; }
    .frm-card-header .icon { font-size: 20px; }
    
    .frm-card-body { padding: 32px; }
    
    .frm-group { margin-bottom: 24px; }
    .frm-group label {
        display: block; font-weight: 600; color: #374151; margin-bottom: 8px;
        font-size: 14px;
    }
    .frm-group label .required { color: #ef4444; }
    
    .frm-control {
        width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 15px; color: #1e293b; background: #fff; transition: all 0.3s;
    }
    .frm-control:focus {
        outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    .frm-control.is-invalid { border-color: #ef4444; }
    
    .frm-help { font-size: 13px; color: #64748b; margin-top: 6px; }
    .frm-error { font-size: 13px; color: #ef4444; margin-top: 6px; }
    
    .frm-select {
        width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 15px; color: #1e293b; background: #fff; transition: all 0.3s;
        cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
    }
    .frm-select:focus {
        outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    .frm-textarea {
        width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 15px; color: #1e293b; background: #fff; transition: all 0.3s;
        resize: vertical; min-height: 120px;
    }
    .frm-textarea:focus {
        outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    .frm-actions {
        display: flex; gap: 12px; margin-top: 32px; padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }
    
    .frm-btn {
        padding: 14px 28px; border-radius: 12px; font-size: 15px; font-weight: 600;
        cursor: pointer; transition: all 0.3s; border: none;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .frm-btn-primary {
        background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff;
    }
    .frm-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3); }
    .frm-btn-secondary {
        background: #f1f5f9; color: #475569; text-decoration: none;
    }
    .frm-btn-secondary:hover { background: #e2e8f0; color: #334155; }
</style>

<div class="frm-container">
    <div class="frm-header-card">
        <div class="d-flex align-items-center">
            <div class="frm-header-icon">✏️</div>
            <div>
                <h1>Edit Permintaan Bantuan</h1>
                <p>Perbarui informasi permintaan bantuan Anda</p>
            </div>
        </div>
    </div>

    <div class="frm-card">
        <div class="frm-card-header">
            <span class="icon">📝</span>
            <h5>Formulir Edit Bantuan</h5>
        </div>
        <div class="frm-card-body">
            <form action="{{ route('petani.bantuan.update', $bantuan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="frm-group">
                    <label>📦 Jenis Bantuan <span class="required">*</span></label>
                    <select class="frm-select @error('jenis_bantuan') is-invalid @enderror" name="jenis_bantuan" required>
                        <option value="">-- Pilih Jenis Bantuan --</option>
                        <option value="Pupuk" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Pupuk' ? 'selected' : '' }}>🧪 Pupuk</option>
                        <option value="Bibit" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Bibit' ? 'selected' : '' }}>🌱 Bibit</option>
                        <option value="Pestisida" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Pestisida' ? 'selected' : '' }}>🧴 Pestisida</option>
                        <option value="Alat Pertanian" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Alat Pertanian' ? 'selected' : '' }}>🔧 Alat Pertanian</option>
                        <option value="Dana" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Dana' ? 'selected' : '' }}>💰 Dana</option>
                        <option value="Lainnya" {{ old('jenis_bantuan', $bantuan->jenis_bantuan) == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>
                    @error('jenis_bantuan')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group">
                    <label>🔢 Jumlah <span class="required">*</span></label>
                    <input type="number" class="frm-control @error('jumlah') is-invalid @enderror" 
                           name="jumlah" value="{{ old('jumlah', $bantuan->jumlah) }}" required min="1" placeholder="Masukkan jumlah...">
                    @error('jumlah')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                    <div class="frm-help">Masukkan jumlah yang dibutuhkan (satuan sesuai jenis bantuan)</div>
                </div>

                <div class="frm-group">
                    <label>📅 Tanggal Permintaan</label>
                    <input type="date" class="frm-control @error('tanggal_permintaan') is-invalid @enderror" 
                           name="tanggal_permintaan" value="{{ old('tanggal_permintaan', $bantuan->tanggal_permintaan ? $bantuan->tanggal_permintaan->format('Y-m-d') : '') }}">
                    @error('tanggal_permintaan')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group">
                    <label>📝 Keterangan / Alasan Permintaan</label>
                    <textarea class="frm-textarea @error('keterangan') is-invalid @enderror" 
                              name="keterangan" placeholder="Jelaskan alasan Anda mengajukan bantuan ini...">{{ old('keterangan', $bantuan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                    <div class="frm-help">Jelaskan alasan Anda mengajukan bantuan ini</div>
                </div>

                <div class="frm-actions">
                    <button type="submit" class="frm-btn frm-btn-primary">
                        💾 Update Bantuan
                    </button>
                    <a href="{{ route('petani.bantuan.index') }}" class="frm-btn frm-btn-secondary">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
