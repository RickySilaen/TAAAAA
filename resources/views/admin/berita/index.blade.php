@extends('layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Berita</h6>
                        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Berita
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success mx-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Publikasi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beritas as $berita)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                @if($berita->gambar)
                                                    <div>
                                                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="avatar avatar-sm me-3" alt="gambar berita">
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ Str::limit($berita->judul, 50) }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $berita->status === 'published' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $berita->status === 'published' ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') : '-' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.berita.toggle-status', $berita->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $berita->status === 'published' ? 'btn-secondary' : 'btn-success' }}">
                                                        <i class="fas fa-{{ $berita->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-newspaper fa-3x text-secondary mb-3"></i>
                                                <h6 class="text-secondary">Belum ada berita</h6>
                                                <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Tambah Berita Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($beritas->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $beritas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
