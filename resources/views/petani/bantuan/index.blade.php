@extends('layouts.app')

@section('title', 'Permintaan Bantuan Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Permintaan Bantuan Saya</h3>
                    <a href="{{ route('petani.bantuan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajukan Bantuan Baru
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
                                    <th>Jenis Bantuan</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bantuans as $bantuan)
                                <tr>
                                    <td>{{ $loop->iteration + ($bantuans->currentPage() - 1) * $bantuans->perPage() }}</td>
                                    <td>{{ $bantuan->jenis_bantuan }}</td>
                                    <td>{{ $bantuan->jumlah }}</td>
                                    <td>{{ $bantuan->tanggal_permintaan ? \Carbon\Carbon::parse($bantuan->tanggal_permintaan)->format('d/m/Y') : ($bantuan->created_at ? $bantuan->created_at->format('d/m/Y') : '-') }}</td>
                                    <td>
                                        @if($bantuan->status == 'pending')
                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                        @elseif($bantuan->status == 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($bantuan->status == 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($bantuan->status == 'delivered')
                                            <span class="badge badge-info">Telah Dikirim</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $bantuan->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('petani.bantuan.show', $bantuan->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @if($bantuan->status == 'pending')
                                        <a href="{{ route('petani.bantuan.edit', $bantuan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('petani.bantuan.destroy', $bantuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus permintaan bantuan ini?')">
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
                                    <td colspan="6" class="text-center">Belum ada permintaan bantuan. <a href="{{ route('petani.bantuan.create') }}">Ajukan bantuan pertama Anda!</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $bantuans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
