@extends('layouts.app')

@section('title', 'Detail Permintaan Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detail Permintaan Bantuan</h3>
                    <div>
                        @if($bantuan->status == 'pending')
                        <a href="{{ route('petani.bantuan.edit', $bantuan->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('petani.bantuan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Jenis Bantuan</th>
                                    <td>{{ $bantuan->jenis_bantuan }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $bantuan->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Permintaan</th>
                                    <td>{{ $bantuan->tanggal_permintaan ? \Carbon\Carbon::parse($bantuan->tanggal_permintaan)->format('d F Y') : ($bantuan->created_at ? $bantuan->created_at->format('d F Y') : '-') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                @if($bantuan->tanggal)
                                <tr>
                                    <th>Tanggal Dikirim</th>
                                    <td>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $bantuan->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                @if($bantuan->keterangan)
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $bantuan->keterangan }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($bantuan->status == 'rejected' && $bantuan->rejection_reason)
                    <div class="alert alert-danger mt-3">
                        <h5><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan:</h5>
                        <p class="mb-0">{{ $bantuan->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($bantuan->status == 'approved')
                    <div class="alert alert-success mt-3">
                        <h5><i class="fas fa-check-circle"></i> Bantuan Disetujui</h5>
                        <p class="mb-0">Permintaan bantuan Anda telah disetujui. Silakan tunggu informasi selanjutnya untuk pengambilan bantuan.</p>
                    </div>
                    @endif

                    @if($bantuan->status == 'delivered')
                    <div class="alert alert-info mt-3">
                        <h5><i class="fas fa-truck"></i> Bantuan Telah Dikirim</h5>
                        <p class="mb-0">Bantuan telah dikirim pada tanggal {{ $bantuan->tanggal ? \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') : '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
