@extends('layouts.app')

@section('title', 'Dashboard Petani')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Dashboard Petani - {{ Auth::user()->name }}</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-check text-info" aria-hidden="true"></i>
                                <span class="font-weight-bold ms-1">Selamat datang di sistem pertanian</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row">
                        <!-- Statistik Laporan -->
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Laporan</p>
                                                <h5 class="font-weight-bolder">{{ $total_laporan }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Bantuan -->
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Bantuan</p>
                                                <h5 class="font-weight-bolder">{{ $total_bantuan }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="ni ni-delivery-fast text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bantuan Pending -->
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Bantuan Pending</p>
                                                <h5 class="font-weight-bolder text-warning">{{ $bantuan_pending }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Hasil Panen -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Hasil Panen</p>
                                                <h5 class="font-weight-bolder">{{ number_format($total_hasil_panen, 0) }} kg</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="ni ni-spaceship text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Aksi Cepat</h6>
                </div>
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('input.data') }}" class="btn btn-primary mb-2">
                        <i class="fas fa-plus-circle"></i> Input Data Baru
                    </a>
                    <a href="{{ route('daftar.laporan') }}" class="btn btn-success mb-2">
                        <i class="fas fa-file-alt"></i> Lihat Laporan Saya
                    </a>
                    <a href="{{ route('daftar.bantuan') }}" class="btn btn-warning mb-2">
                        <i class="fas fa-hand-holding-heart"></i> Lihat Bantuan Saya
                    </a>
                    <a href="{{ route('profile') }}" class="btn btn-info">
                        <i class="fas fa-user"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <!-- Laporan Terbaru -->
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Laporan Terbaru Saya</h6>
                        <a href="{{ route('daftar.laporan') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    @forelse($laporan_terbaru as $laporan)
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-bell-55 text-success text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $laporan->jenis_tanaman }}</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $laporan->deskripsi_kemajuan }}</p>
                                <p class="text-secondary text-xs mt-1 mb-0">{{ $laporan->tanggal }} - {{ number_format($laporan->hasil_panen) }} kg</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada laporan. <a href="{{ route('input.data') }}">Buat laporan pertama?</a></p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bantuan Terbaru -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Bantuan Terbaru Saya</h6>
                        <a href="{{ route('daftar.bantuan') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    @forelse($bantuan_terbaru as $bantuan)
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-delivery-fast text-warning text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $bantuan->jenis_bantuan }}</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Jumlah: {{ $bantuan->jumlah }}</p>
                                <p class="text-secondary text-xs mt-1 mb-0">
                                    {{ $bantuan->tanggal }} - 
                                    <span class="badge badge-sm bg-{{ $bantuan->status == 'Dikirim' ? 'success' : ($bantuan->status == 'Diproses' ? 'info' : 'warning') }}">
                                        {{ $bantuan->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada bantuan. <a href="{{ route('input.data') }}">Ajukan bantuan?</a></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if($notifications->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Notifikasi Terbaru</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td class="p-4">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if(!$notification->read_at)
                                        <span class="badge badge-sm bg-danger">Baru</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
