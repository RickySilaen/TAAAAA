@extends('layouts.app')

@section('title', 'Edit Laporan Panen')

@section('content')
<style>
    .frm-container { padding: 24px; max-width: 900px; margin: 0 auto; }
    
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
    
    .frm-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    @media (max-width: 768px) { .frm-row { grid-template-columns: 1fr; } }
    
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
    
    .frm-textarea {
        width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 12px;
        font-size: 15px; color: #1e293b; background: #fff; transition: all 0.3s;
        resize: vertical; min-height: 100px;
    }
    .frm-textarea:focus {
        outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    .frm-file-upload {
        border: 2px dashed #e2e8f0; border-radius: 12px; padding: 24px;
        text-align: center; background: #fafafa; cursor: pointer; transition: all 0.3s;
    }
    .frm-file-upload:hover { border-color: #f59e0b; background: #fffbeb; }
    .frm-file-upload input[type="file"] { display: none; }
    .frm-file-upload .icon { font-size: 36px; margin-bottom: 12px; display: block; }
    .frm-file-upload .text { color: #64748b; font-size: 14px; }
    .frm-file-upload .text span { color: #f59e0b; font-weight: 600; }
    .frm-file-name { margin-top: 8px; font-size: 13px; color: #10b981; font-weight: 500; }
    
    .frm-current-photo {
        margin-bottom: 16px; padding: 16px; background: #f8fafc; border-radius: 12px;
        display: flex; align-items: center; gap: 16px;
    }
    .frm-current-photo img { max-width: 150px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .frm-current-photo .info { color: #64748b; font-size: 13px; }
    .frm-current-photo .info strong { color: #374151; display: block; margin-bottom: 4px; }
    
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
                <h1>Edit Laporan Panen</h1>
                <p>Perbarui informasi laporan hasil panen Anda</p>
            </div>
        </div>
    </div>

    <div class="frm-card">
        <div class="frm-card-header">
            <span class="icon">📝</span>
            <h5>Formulir Edit Laporan</h5>
        </div>
        <div class="frm-card-body">
            <form action="{{ route('petani.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="frm-group">
                    <label>🌾 Jenis Tanaman <span class="required">*</span></label>
                    <input type="text" class="frm-control @error('jenis_tanaman') is-invalid @enderror" 
                           name="jenis_tanaman" value="{{ old('jenis_tanaman', $laporan->jenis_tanaman) }}" 
                           required placeholder="Contoh: Padi, Jagung, Kedelai...">
                    @error('jenis_tanaman')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-row">
                    <div class="frm-group">
                        <label>⚖️ Hasil Panen (kg) <span class="required">*</span></label>
                        <input type="number" step="0.01" class="frm-control @error('hasil_panen') is-invalid @enderror" 
                               name="hasil_panen" value="{{ old('hasil_panen', $laporan->hasil_panen) }}" 
                               required placeholder="0.00">
                        @error('hasil_panen')
                            <div class="frm-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="frm-group">
                        <label>📐 Luas Panen (ha)</label>
                        <input type="number" step="0.01" class="frm-control @error('luas_panen') is-invalid @enderror" 
                               name="luas_panen" value="{{ old('luas_panen', $laporan->luas_panen) }}" 
                               placeholder="0.00">
                        @error('luas_panen')
                            <div class="frm-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="frm-group">
                    <label>📅 Tanggal Panen</label>
                    <input type="date" class="frm-control @error('tanggal') is-invalid @enderror" 
                           name="tanggal" value="{{ old('tanggal', $laporan->tanggal ? $laporan->tanggal->format('Y-m-d') : '') }}">
                    @error('tanggal')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group">
                    <label>📈 Deskripsi Kemajuan</label>
                    <textarea class="frm-textarea @error('deskripsi_kemajuan') is-invalid @enderror" 
                              name="deskripsi_kemajuan" placeholder="Jelaskan perkembangan dan kondisi tanaman...">{{ old('deskripsi_kemajuan', $laporan->deskripsi_kemajuan) }}</textarea>
                    @error('deskripsi_kemajuan')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group">
                    <label>📝 Catatan Tambahan</label>
                    <textarea class="frm-textarea @error('catatan') is-invalid @enderror" 
                              name="catatan" placeholder="Catatan lain yang perlu dilaporkan..." style="min-height: 80px;">{{ old('catatan', $laporan->catatan) }}</textarea>
                    @error('catatan')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group">
                    <label>📷 Foto Hasil Panen (Opsional)</label>
                    
                    @if($laporan->foto)
                        <div class="frm-current-photo">
                            <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" alt="Foto Panen">
                            <div class="info">
                                <strong>Foto Saat Ini</strong>
                                Upload foto baru untuk mengganti
                            </div>
                        </div>
                    @endif
                    
                    <label class="frm-file-upload" for="fotoInput">
                        <span class="icon">📸</span>
                        <div class="text">Klik untuk <span>pilih foto</span> atau drag & drop</div>
                        <div class="frm-help">Format: JPG, JPEG, PNG. Maksimal 2MB</div>
                        <input type="file" id="fotoInput" name="foto" accept="image/*">
                        <div class="frm-file-name" id="fileName"></div>
                    </label>
                    @error('foto')
                        <div class="frm-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-actions">
                    <button type="submit" class="frm-btn frm-btn-primary">
                        💾 Update Laporan
                    </button>
                    <a href="{{ route('petani.laporan.index') }}" class="frm-btn frm-btn-secondary">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    document.getElementById('fileName').textContent = fileName ? '📄 ' + fileName : '';
});
</script>
@endsection
