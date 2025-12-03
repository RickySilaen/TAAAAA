@extends('layouts.app')

@section('title', 'Dashboard Alat Bantu Keputusan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Dashboard Alat Bantu Keputusan</h1>
            <p class="text-muted mb-0">Analisis dan wawasan untuk pengambilan keputusan strategis</p>
        </div>
        <div>
            <select class="form-select" onchange="window.location.href='?period=' + this.value">
                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="all" {{ $period == 'all' ? 'selected' : '' }}>Semua</option>
            </select>
        </div>
    </div>

    <!-- Insights Cards -->
    @if(count($insights) > 0)
    <div class="row mb-4">
        @foreach($insights as $insight)
        <div class="col-lg-6 mb-3">
            <div class="alert alert-{{ $insight['type'] == 'info' ? 'info' : ($insight['type'] == 'warning' ? 'warning' : ($insight['type'] == 'danger' ? 'danger' : 'success')) }} border-left-{{ $insight['type'] == 'info' ? 'info' : ($insight['type'] == 'warning' ? 'warning' : ($insight['type'] == 'danger' ? 'danger' : 'success')) }}">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="fas fa-{{ $insight['icon'] }} fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1">{{ $insight['title'] }}</h6>
                        <p class="mb-0">{{ $insight['message'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['summary']['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['summary']['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['summary']['verified'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dipublikasikan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['summary']['published'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-globe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Laporan by Jenis Bantuan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan per Jenis Bantuan</h6>
                    <i class="fas fa-chart-pie text-gray-300"></i>
                </div>
                <div class="card-body">
                    @if($statistics['by_jenis']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Bantuan</th>
                                    <th class="text-end">Jumlah Laporan</th>
                                    <th class="text-end">Total Bantuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics['by_jenis'] as $jenis)
                                <tr>
                                    <td><strong>{{ $jenis->jenis_bantuan }}</strong></td>
                                    <td class="text-end">{{ $jenis->total }}</td>
                                    <td class="text-end">{{ number_format($jenis->total_jumlah ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Laporan by Lokasi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Top 10 Desa Paling Aktif</h6>
                    <i class="fas fa-map-marker-alt text-gray-300"></i>
                </div>
                <div class="card-body">
                    @if($statistics['by_desa']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Desa</th>
                                    <th class="text-end">Jumlah Laporan</th>
                                    <th class="text-end">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics['by_desa'] as $desa)
                                <tr>
                                    <td><strong>{{ $desa->alamat_desa }}</strong></td>
                                    <td class="text-end">{{ $desa->total }}</td>
                                    <td class="text-end">
                                        {{ $statistics['summary']['total'] > 0 ? number_format(($desa->total / $statistics['summary']['total']) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Terbaru</h6>
        </div>
        <div class="card-body">
            @if($statistics['recent_reports']->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Jenis Bantuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistics['recent_reports'] as $laporan)
                        <tr>
                            <td>{{ $laporan->tanggal_pelaporan->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($laporan->judul, 40) }}</td>
                            <td>{{ $laporan->user->name }}</td>
                            <td><span class="badge bg-primary">{{ $laporan->jenis_bantuan }}</span></td>
                            <td>{!! $laporan->status_badge !!}</td>
                            <td>
                                <a href="{{ route('admin.laporan-bantuan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted text-center py-4">Belum ada laporan</p>
            @endif
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Metrik Kinerja</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h5 class="text-success">{{ number_format(($statistics['summary']['verified'] / max($statistics['summary']['total'], 1)) * 100, 1) }}%</h5>
                            <p class="text-muted mb-0">Tingkat Verifikasi</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-info">{{ number_format(($statistics['summary']['published'] / max($statistics['summary']['total'], 1)) * 100, 1) }}%</h5>
                            <p class="text-muted mb-0">Tingkat Publikasi</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-warning">{{ number_format($statistics['summary']['rejection_rate'], 1) }}%</h5>
                            <p class="text-muted mb-0">Tingkat Penolakan</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-primary">{{ $statistics['by_jenis']->count() }}</h5>
                            <p class="text-muted mb-0">Jenis Bantuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.laporan-bantuan.index', ['status' => 'pending']) }}" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-clock fa-2x mb-2 d-block"></i>
                                <span class="d-block">Verifikasi Laporan</span>
                                <small class="d-block mt-1">({{ $statistics['summary']['pending'] }} menunggu)</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.laporan-bantuan.index', ['status' => 'verified']) }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                                <span class="d-block">Publikasikan</span>
                                <small class="d-block mt-1">({{ $statistics['summary']['verified'] }} terverifikasi)</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.laporan-bantuan.index') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-list fa-2x mb-2 d-block"></i>
                                <span class="d-block">Semua Laporan</span>
                                <small class="d-block mt-1">({{ $statistics['summary']['total'] }} total)</small>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transparansi.bantuan') }}" target="_blank" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-globe fa-2x mb-2 d-block"></i>
                                <span class="d-block">Dashboard Publik</span>
                                <small class="d-block mt-1">({{ $statistics['summary']['published'] }} dipublikasi)</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@endsection
