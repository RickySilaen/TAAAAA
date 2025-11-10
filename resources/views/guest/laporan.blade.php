@extends('layouts.guest')

@section('title', 'Laporan Hasil Panen - Dinas Pertanian Kabupaten Toba')

@section('content')
<section class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Laporan Hasil Panen</h2>
        <p class="text-muted">Pantau dan kelola laporan hasil panen secara transparan dan akurat.</p>
    </div>

    {{-- Ringkasan --}}
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-success fw-bold">Total Laporan</h5>
                    <h3>{{ $totalLaporan ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-success fw-bold">Total Produksi (Ton)</h5>
                    <h3>{{ $totalProduksi ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-success fw-bold">Jumlah Petani</h5>
                    <h3>{{ $totalPetani ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    @auth
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('guest.laporan.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Laporan
        </a>
    </div>
    @else
    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Informasi:</strong> Silakan <a href="{{ route('login') }}" class="alert-link">login</a> terlebih dahulu untuk menambah laporan.
    </div>
    @endauth

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold text-success mb-3">Data Laporan Panen</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Nama Petani</th>
                            <th>Komoditas</th>
                            <th>Jumlah Produksi (Kg)</th>
                            <th>Tanggal Laporan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporan->nama_petani ?? '-' }}</td>
                            <td>{{ $laporan->komoditas ?? '-' }}</td>
                            <td>{{ $laporan->jumlah ?? 0 }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $laporan->status == 'Disetujui' ? 'success' : ($laporan->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                    {{ $laporan->status ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guest.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @auth
                                    @if(auth()->user()->id == $laporan->user_id || auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                                        <a href="{{ route('guest.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning text-white" title="Edit Laporan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('guest.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Laporan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada laporan panen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
