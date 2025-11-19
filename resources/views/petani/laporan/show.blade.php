@extends('layouts.app')

@section('title', 'Detail Laporan Panen')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detail Laporan Panen</h3>
                    <div>
                        @if($laporan->status == 'pending')
                        <a href="{{ route('petani.laporan.edit', $laporan->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('petani.laporan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Jenis Tanaman</th>
                                    <td>{{ $laporan->jenis_tanaman }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil Panen</th>
                                    <td>{{ number_format($laporan->hasil_panen, 2) }} kg</td>
                                </tr>
                                <tr>
                                    <th>Luas Panen</th>
                                    <td>{{ $laporan->luas_panen ? number_format($laporan->luas_panen, 2) . ' ha' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Panen</th>
                                    <td>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                @if($laporan->deskripsi_kemajuan)
                                <tr>
                                    <th>Deskripsi Kemajuan</th>
                                    <td>{{ $laporan->deskripsi_kemajuan }}</td>
                                </tr>
                                @endif
                                @if($laporan->catatan)
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $laporan->catatan }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <div class="col-md-4">
                            @if($laporan->foto)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Foto Hasil Panen</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" 
                                         alt="Foto Panen" 
                                         class="img-fluid rounded"
                                         style="max-width: 100%;">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($laporan->status == 'rejected' && $laporan->rejection_reason)
                    <div class="alert alert-danger mt-3">
                        <h5><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan:</h5>
                        <p class="mb-0">{{ $laporan->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
