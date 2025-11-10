@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Verifikasi Laporan Petani - {{ Auth::user()->alamat_desa }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Petani</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hasil Panen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Verifikasi</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $laporan)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $laporan->user->profile_picture ? asset('storage/' . $laporan->user->profile_picture) : asset('assets/img/default-avatar.png') }}" class="avatar avatar-sm me-3" alt="user image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $laporan->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $laporan->user->alamat_desa }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ Str::limit($laporan->deskripsi_kemajuan, 50) }}</p>
                                        @if($laporan->jenis_tanaman)
                                        <p class="text-xs text-secondary mb-0">Tanaman: {{ $laporan->jenis_tanaman }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-success">{{ number_format($laporan->hasil_panen) }} kg</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        @if($laporan->status_verifikasi == 'disetujui')
                                            <span class="badge badge-sm bg-success">Disetujui</span>
                                        @elseif($laporan->status_verifikasi == 'ditolak')
                                            <span class="badge badge-sm bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-sm bg-warning">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('petugas.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ni ni-folder-17 text-muted" style="font-size: 3rem;"></i>
                                            <h6 class="mt-2 text-muted">Belum ada laporan untuk diverifikasi</h6>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
