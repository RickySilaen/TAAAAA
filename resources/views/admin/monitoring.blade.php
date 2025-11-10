@extends('layouts.app')

@section('title', '📊 Monitoring Bantuan - Sistem Pertanian')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background-color: #E8F5E8; border: 1px solid #4CAF50;">
                <div class="card-header pb-0" style="background-color: #C8E6C9;">
                    <h6 class="mb-0" style="color: #2E7D32;"><i class="fas fa-filter me-2"></i>Filter Data</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('monitoring') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="jenis_bantuan">Jenis Bantuan</label>
                                <select name="jenis_bantuan" id="jenis_bantuan" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach($statsByType as $stat)
                                        <option value="{{ $stat->jenis_bantuan }}" {{ request('jenis_bantuan') == $stat->jenis_bantuan ? 'selected' : '' }}>{{ $stat->jenis_bantuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="desa">Desa</label>
                                <select name="desa" id="desa" class="form-control">
                                    <option value="">Semua Desa</option>
                                    @foreach($statsByDesa as $stat)
                                        <option value="{{ $stat->alamat_desa }}" {{ request('desa') == $stat->alamat_desa ? 'selected' : '' }}>{{ $stat->alamat_desa }} ({{ $stat->total }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('monitoring') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center mt-1">
                        <i class="fas fa-archive opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Bantuan</p>
                        <h4 class="mb-0">{{ $statsByType->sum('total') ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center mt-1">
                        <i class="fas fa-truck opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Dikirim</p>
                        <h4 class="mb-0">{{ $statsByStatus->where('status', 'Dikirim')->first()->total ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center mt-1">
                        <i class="fas fa-clock opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Diproses</p>
                        <h4 class="mb-0">{{ $statsByStatus->where('status', 'Diproses')->first()->total ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center mt-1">
                        <i class="fas fa-map-marker-alt opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Desa Tercakup</p>
                        <h4 class="mb-0">{{ $statsByDesa->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Integration -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6><i class="fas fa-map-marked-alt me-2"></i>Peta Distribusi Bantuan per Desa</h6>
                </div>
                <div class="card-body p-3">
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Distribusi Bantuan per Jenis</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="typeChart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Status Distribusi</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="statusChart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Distribusi Historis per Bulan</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="historicalChart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Daftar Bantuan</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group" id="bantuanList">
                        @forelse ($bantuans as $bantuan)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-{{ $bantuan->status == 'Dikirim' ? 'success' : 'warning' }} shadow text-center">
                                        <i class="fas fa-{{ $bantuan->status == 'Dikirim' ? 'check' : 'clock' }} text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">{{ $bantuan->jenis_bantuan }}</h6>
                                        <span class="text-xs">Jumlah: {{ $bantuan->jumlah }}, Petani: {{ $bantuan->user->name ?? 'N/A' }} ({{ $bantuan->user->alamat_desa ?? 'N/A' }}), Status: <span class="badge bg-{{ $bantuan->status == 'Dikirim' ? 'success' : 'warning' }}">{{ $bantuan->status }}</span>, Tanggal: {{ $bantuan->tanggal }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </li>
                        @empty
                            <li class="list-group-item border-0 text-center">Tidak ada data bantuan.</li>
                        @endforelse
                    </ul>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bantuans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer pt-3">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © {{ date('Y') }}, dibuat dengan <i class="fa fa-heart"></i> oleh
                        <a href="https://yourwebsite.com" class="font-weight-bold" target="_blank">Tim Anda</a>
                        untuk sistem pertanian yang lebih baik.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-muted">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-muted">Bantuan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Initialize Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Type Chart (Pie) - Agricultural Colors
        const typeCtx = document.getElementById('typeChart').getContext('2d');
        new Chart(typeCtx, {
            type: 'pie',
            data: {
                labels: @json(array_column($statsByType->toArray(), 'jenis_bantuan')),
                datasets: [{
                    data: @json(array_column($statsByType->toArray(), 'total')),
                    backgroundColor: ['#28a745', '#8B4513', '#FFD700', '#228B22', '#32CD32']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Status Chart (Doughnut) - Agricultural Colors
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($statsByStatus->toArray(), 'status')),
                datasets: [{
                    data: @json(array_column($statsByStatus->toArray(), 'total')),
                    backgroundColor: ['#FFD700', '#28a745']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Historical Chart (Line) - Agricultural Colors
        const historicalCtx = document.getElementById('historicalChart').getContext('2d');
        new Chart(historicalCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($historicalData->toArray(), 'month')),
                datasets: [{
                    label: 'Total Bantuan',
                    data: @json(array_column($historicalData->toArray(), 'total')),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Initialize Map
        const map = L.map('map').setView([-6.2, 106.816666], 10); // Default to Jakarta area, adjust as needed

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add markers for each desa
        @foreach($statsByDesa as $desa)
            L.marker([{{ $desa->latitude ?? -6.2 }}, {{ $desa->longitude ?? 106.816666 }}]).addTo(map)
                .bindPopup('<b>{{ $desa->alamat_desa }}</b><br>Total Bantuan: {{ $desa->total }}');
        @endforeach

        // Real-time update every 30 seconds
        setInterval(function() {
            fetch('{{ route("latest.bantuan") }}')
                .then(response => response.json())
                .then(data => {
                    // Update table or show notification if new data
                    console.log('Latest bantuan:', data);
                    // For simplicity, just log; in real app, update DOM
                })
                .catch(error => console.error('Error fetching latest bantuan:', error));
        }, 30000);
    });
</script>
@endsection
