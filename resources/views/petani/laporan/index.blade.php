@extends('layouts.app')

@section('title', 'Laporan Panen Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Laporan Panen Saya</h3>
                    <a href="{{ route('petani.laporan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Laporan Baru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Jenis Tanaman</th>
                                    <th>Hasil Panen (kg)</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration + ($laporans->currentPage() - 1) * $laporans->perPage() }}</td>
                                    <td>{{ $laporan->jenis_tanaman }}</td>
                                    <td>{{ number_format($laporan->hasil_panen, 2) }}</td>
                                    <td>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($laporan->status == 'pending')
                                            <span class="badge badge-warning">Menunggu Verifikasi</span>
                                        @elseif($laporan->status == 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($laporan->status == 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $laporan->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('petani.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @if($laporan->status == 'pending')
                                        <a href="{{ route('petani.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('petani.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada laporan panen. <a href="{{ route('petani.laporan.create') }}">Buat laporan pertama Anda!</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $laporans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
