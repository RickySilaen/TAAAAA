@extends('layouts.app')

@section('title', 'Daftar Petugas - Sistem Bantuan Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-0">
                        <i class="fas fa-users me-2"></i>Manajemen Petugas
                    </h4>
                    <p class="text-white-50 mb-0">Kelola data akun petugas pertanian</p>
                </div>
                <div>
                    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Petugas Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Petugas Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6>Daftar Petugas</h6>
                        <div class="text-muted">
                            <i class="fas fa-users me-1"></i>Total: {{ $petugas->total() }} petugas
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Petugas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telepon</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Desa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kecamatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Terdaftar</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petugas as $index => $item)
                                <tr>
                                    <td>
                                        <div class="px-3 py-1">
                                            <p class="text-xs font-weight-bold mb-0">{{ $petugas->firstItem() + $index }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($item->profile_picture)
                                                    <img src="{{ asset('storage/' . $item->profile_picture) }}" class="avatar avatar-sm me-3" alt="user">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-primary">
                                                        <span class="text-white text-xs">{{ strtoupper(substr($item->name, 0, 2)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->telepon ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->alamat_desa ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->alamat_kecamatan ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-info">{{ $item->created_at->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.petugas.edit', $item->id) }}" class="btn btn-link text-warning text-gradient px-2 mb-0" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-2 mb-0" title="Hapus">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada data petugas</p>
                                            <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Tambah Petugas
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($petugas->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $petugas->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
