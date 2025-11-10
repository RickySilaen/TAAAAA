@extends('layouts.guest')

@section('title', 'Detail Laporan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-eye me-2"></i>Detail Laporan Hasil Panen</h4>
                    <p class="mb-0 text-muted">Informasi lengkap laporan hasil panen</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Laporan Details -->
                            <div class="card border-agriculture mb-4">
                                <div class="card-header bg-agriculture text-white">
                                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Informasi Laporan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Deskripsi Kemajuan</label>
                                                <p class="mb-0">{{ $laporan->deskripsi_kemajuan }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Jenis Tanaman</label>
                                                <p class="mb-0">
                                                    @if($laporan->jenis_tanaman)
                                                        <i class="fas fa-seedling me-1"></i>{{ $laporan->jenis_tanaman }}
                                                    @else
                                                        <i class="fas fa-question-circle me-1"></i>Tanaman belum ditentukan
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Hasil Panen</label>
                                                <p class="mb-0">
                                                    @if($laporan->hasil_panen > 0)
                                                        <span class="badge-quantity">{{ $laporan->hasil_panen }} kg</span>
                                                    @else
                                                        <span class="badge-agriculture-warning">Belum ada hasil panen</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Luas Lahan</label>
                                                <p class="mb-0">{{ $laporan->luas_lahan }} m²</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Tanggal Laporan</label>
                                                <p class="mb-0">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item mb-3">
                                                <label class="form-label text-sm font-weight-bold">Status</label>
                                                <p class="mb-0">
                                                    @if($laporan->hasil_panen > 0)
                                                        <span class="badge-agriculture-success">Selesai</span>
                                                    @else
                                                        <span class="badge-agriculture-warning">Dalam Proses</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        @if($laporan->catatan)
                                            <div class="col-12">
                                                <div class="detail-item">
                                                    <label class="form-label text-sm font-weight-bold">Catatan Tambahan</label>
                                                    <p class="mb-0">{{ $laporan->catatan }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Card -->
                            @if($laporan->hasil_panen > 0 && $laporan->luas_lahan > 0)
                                <div class="card border-agriculture">
                                    <div class="card-header bg-agriculture text-white">
                                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Produktivitas</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <div class="stat-item">
                                                    <h4 class="text-agriculture mb-1">{{ number_format($laporan->hasil_panen) }}</h4>
                                                    <p class="text-muted mb-0">Hasil Panen (kg)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="stat-item">
                                                    <h4 class="text-agriculture mb-1">{{ number_format($laporan->luas_lahan) }}</h4>
                                                    <p class="text-muted mb-0">Luas Lahan (m²)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="stat-item">
                                                    <h4 class="text-success mb-1">{{ number_format($laporan->hasil_panen / $laporan->luas_lahan, 2) }}</h4>
                                                    <p class="text-muted mb-0">Produktivitas (kg/m²)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Action Panel -->
                            <div class="card border-agriculture mb-4">
                                <div class="card-header bg-agriculture text-white">
                                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-agriculture-view" onclick="printLaporan()">
                                            <i class="fas fa-print me-1"></i>Print Laporan
                                        </button>
                                        <a href="{{ route('guest.laporan.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Panel -->
                            <div class="card border-agriculture">
                                <div class="card-header bg-agriculture text-white">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Petani</h6>
                                </div>
                                <div class="card-body">
                                    @if($laporan->user)
                                        <div class="info-item mb-3">
                                            <strong>Nama:</strong><br>
                                            {{ $laporan->user->name }}
                                        </div>
                                        <div class="info-item mb-3">
                                            <strong>Email:</strong><br>
                                            {{ $laporan->user->email }}
                                        </div>
                                        <div class="info-item mb-3">
                                            <strong>Desa:</strong><br>
                                            {{ $laporan->user->desa ?? 'Belum diisi' }}
                                        </div>
                                        <div class="info-item">
                                            <strong>Luas Lahan Total:</strong><br>
                                            {{ $laporan->user->luas_lahan ?? 0 }} m²
                                        </div>
                                    @else
                                        <div class="info-item mb-3">
                                            <strong>Nama:</strong><br>
                                            {{ $laporan->nama_petani ?? 'Guest' }}
                                        </div>
                                        <div class="info-item mb-3">
                                            <strong>Alamat Desa:</strong><br>
                                            {{ $laporan->alamat_desa ?? 'Belum diisi' }}
                                        </div>
                                        <div class="info-item">
                                            <strong>Status:</strong><br>
                                            Guest (Tidak Terdaftar)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style media="print">
    .no-print {
        display: none !important;
    }
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
    .btn {
        display: none !important;
    }
</style>
@endsection

@section('scripts')
<script>
function printLaporan() {
    window.print();
}
</script>
@endsection
