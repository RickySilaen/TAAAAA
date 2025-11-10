@extends('layouts.app')

@section('title', 'Kelola Bantuan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Kelola Bantuan Petani - {{ Auth::user()->alamat_desa }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Petani</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Bantuan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bantuans as $bantuan)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $bantuan->user->profile_picture ? asset('storage/' . $bantuan->user->profile_picture) : asset('assets/img/default-avatar.png') }}" class="avatar avatar-sm me-3" alt="user image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $bantuan->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $bantuan->user->alamat_desa }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $bantuan->jenis_bantuan }}</p>
                                        @if($bantuan->catatan)
                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($bantuan->catatan, 30) }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-info">{{ $bantuan->jumlah }}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        @if($bantuan->status == 'Dikirim')
                                            <span class="badge badge-sm bg-success">Dikirim</span>
                                        @elseif($bantuan->status == 'Diproses')
                                            <span class="badge badge-sm bg-warning">Diproses</span>
                                        @elseif($bantuan->status == 'Ditolak')
                                            <span class="badge badge-sm bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-sm bg-secondary">{{ $bantuan->status }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('petugas.bantuan.show', $bantuan->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ni ni-delivery-fast text-muted" style="font-size: 3rem;"></i>
                                            <h6 class="mt-2 text-muted">Belum ada bantuan untuk dikelola</h6>
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
