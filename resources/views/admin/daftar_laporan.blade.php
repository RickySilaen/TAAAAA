@extends('layouts.app')

@section('title', '📋 Daftar Laporan - Sistem Pertanian')

@section('content')
<style>
    /* Modern Page Styles - Unified Green Theme */
    .page-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: visible;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 50%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(30deg);
        pointer-events: none;
        z-index: 0;
    }
    
    .page-header .row {
        position: relative;
        z-index: 1;
    }
    
    .page-header h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }
    
    /* Stats Badges */
    .stats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 1rem;
    }
    
    .stat-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    /* Action Buttons */
    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .btn-export {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        z-index: 10;
        cursor: pointer;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        color: white;
    }
    
    .btn-add {
        background: white;
        color: #047857;
        border: 2px solid white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        z-index: 10;
        cursor: pointer;
    }
    
    .btn-add:hover {
        background: rgba(255, 255, 255, 0.9);
        color: #047857;
    }
    
    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .filter-header {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(4, 120, 87, 0.05) 100%);
        padding: 16px 24px;
        border-bottom: 1px solid rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-header h5 {
        margin: 0;
        font-weight: 700;
        color: #047857;
    }
    
    .filter-header .filter-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .filter-body {
        padding: 24px;
    }
    
    .filter-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        margin-bottom: 8px;
        display: block;
    }
    
    .filter-select,
    .filter-input {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .filter-select:focus,
    .filter-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }
    
    /* Table Card */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern thead {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .table-modern thead th {
        color: white;
        font-weight: 600;
        padding: 16px 20px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #ecfdf5;
    }
    
    .table-modern tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    /* Item Display */
    .item-display {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    
    .item-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .item-icon.padi {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }
    
    .item-icon.jagung {
        background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%);
        color: #ca8a04;
    }
    
    .item-icon.kedelai {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    
    .item-icon.default {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #2563eb;
    }
    
    .item-info h6 {
        margin: 0 0 4px 0;
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
        line-height: 1.4;
    }
    
    .item-info .item-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .item-info .meta-tag {
        background: #f3f4f6;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .item-info .meta-tag i {
        font-size: 0.7rem;
    }
    
    /* Harvest Badge */
    .harvest-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .harvest-badge.with-result {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
    }
    
    .harvest-badge.pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    /* Date Badge */
    .date-badge {
        background: #f3f4f6;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #4b5563;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    /* Farmer Display */
    .farmer-display {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .farmer-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4338ca;
        font-size: 1rem;
    }
    
    .farmer-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 0.9rem;
    }
    
    .farmer-info span {
        color: #6b7280;
        font-size: 0.8rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    
    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-action-icon.edit {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    .btn-action-icon.edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-action-icon.view {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    
    .btn-action-icon.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-action-icon.delete {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }
    
    .btn-action-icon.delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-state-icon i {
        font-size: 2.5rem;
        color: #9ca3af;
    }
    
    .empty-state h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #6b7280;
        margin-bottom: 20px;
    }
    
    .btn-empty-add {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-empty-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    /* Modal Styles */
    .modal-modern .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        padding: 20px 24px;
    }
    
    .modal-modern .modal-title {
        color: white;
        font-weight: 700;
    }
    
    .modal-modern .modal-body {
        padding: 24px;
    }
    
    .detail-item {
        background: #f9fafb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
    }
    
    .detail-item label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        margin-bottom: 4px;
        display: block;
    }
    
    .detail-item p {
        font-weight: 600;
        color: #1f2937;
        margin: 0;
        font-size: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .header-actions {
            margin-top: 1rem;
        }
        
        .stats-container {
            margin-top: 1rem;
        }
        
        .filter-body .row > div {
            margin-bottom: 1rem;
        }
        
        .table-modern thead {
            display: none;
        }
        
        .table-modern tbody tr {
            display: block;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }
        
        .table-modern tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
        }
        
        .table-modern tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2><i class="fas fa-file-alt me-2"></i>Daftar Laporan Pertanian</h2>
                <p>Pantau laporan hasil panen dan kemajuan pertanian</p>
                
                <div class="stats-container">
                    <span class="stat-badge">
                        <i class="fas fa-file-lines"></i>
                        {{ $laporans->count() }} Total Laporan
                    </span>
                    <span class="stat-badge">
                        <i class="fas fa-chart-line"></i>
                        {{ $laporans->where('hasil_panen', '>', 0)->count() }} Dengan Hasil
                    </span>
                    <span class="stat-badge">
                        <i class="fas fa-clock"></i>
                        {{ $laporans->where('hasil_panen', 0)->count() }} Dalam Proses
                    </span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="header-actions justify-content-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('export.laporan.pdf') }}" class="btn-export" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </a>
                    <a href="{{ route('input.data') }}" class="btn-add">
                        <i class="fas fa-plus"></i>
                        Tambah Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="filter-header">
            <div class="filter-icon">
                <i class="fas fa-filter"></i>
            </div>
            <h5>Filter & Pencarian</h5>
        </div>
        <div class="filter-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="filter-label">Jenis Tanaman</label>
                    <select class="filter-select" id="jenisTanamanFilter">
                        <option value="">🌱 Semua Tanaman</option>
                        <option value="Padi">🌾 Padi</option>
                        <option value="Jagung">🌽 Jagung</option>
                        <option value="Kedelai">🫘 Kedelai</option>
                        <option value="Ubi">🍠 Ubi</option>
                        <option value="Cabe">🌶️ Cabe</option>
                        <option value="Tomat">🍅 Tomat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Hasil Panen</label>
                    <select class="filter-select" id="hasilFilter">
                        <option value="">📊 Semua Hasil</option>
                        <option value="dengan_hasil">✅ Dengan Hasil</option>
                        <option value="tanpa_hasil">⏳ Belum Panen</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Tanggal Mulai</label>
                    <input type="date" class="filter-input" id="startDateFilter">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Tanggal Akhir</label>
                    <input type="date" class="filter-input" id="endDateFilter">
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table-modern" id="laporanTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-file-alt me-2"></i>Deskripsi Kemajuan</th>
                        <th><i class="fas fa-weight me-2"></i>Hasil Panen</th>
                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                        <th><i class="fas fa-user me-2"></i>Petani</th>
                        <th class="text-center"><i class="fas fa-cogs me-2"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $laporan)
                        @php
                            $iconClass = 'default';
                            $iconName = 'leaf';
                            if($laporan->jenis_tanaman == 'Padi') {
                                $iconClass = 'padi';
                                $iconName = 'wheat-awn';
                            } elseif($laporan->jenis_tanaman == 'Jagung') {
                                $iconClass = 'jagung';
                                $iconName = 'seedling';
                            } elseif($laporan->jenis_tanaman == 'Kedelai') {
                                $iconClass = 'kedelai';
                                $iconName = 'leaf';
                            }
                        @endphp
                        <tr>
                            <td data-label="Deskripsi">
                                <div class="item-display">
                                    <div class="item-icon {{ $iconClass }}">
                                        <i class="fas fa-{{ $iconName }}"></i>
                                    </div>
                                    <div class="item-info">
                                        <h6>{{ Str::limit($laporan->deskripsi_kemajuan, 50) }}</h6>
                                        <div class="item-meta">
                                            @if($laporan->jenis_tanaman)
                                                <span class="meta-tag">
                                                    <i class="fas fa-seedling"></i>
                                                    {{ $laporan->jenis_tanaman }}
                                                </span>
                                            @endif
                                            @if($laporan->luas_panen)
                                                <span class="meta-tag">
                                                    <i class="fas fa-ruler-combined"></i>
                                                    {{ $laporan->luas_panen }} ha
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Hasil Panen">
                                @if($laporan->hasil_panen > 0)
                                    <span class="harvest-badge with-result">
                                        <i class="fas fa-check-circle"></i>
                                        {{ number_format($laporan->hasil_panen, 0, ',', '.') }} kg
                                    </span>
                                @else
                                    <span class="harvest-badge pending">
                                        <i class="fas fa-clock"></i>
                                        Belum Panen
                                    </span>
                                @endif
                            </td>
                            <td data-label="Tanggal">
                                <span class="date-badge">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                </span>
                            </td>
                            <td data-label="Petani">
                                <div class="farmer-display">
                                    <div class="farmer-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="farmer-info">
                                        <h6>{{ $laporan->user->name ?? 'N/A' }}</h6>
                                        <span>{{ $laporan->user->email ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Aksi">
                                <div class="action-buttons">
                                    <a href="{{ route('edit.laporan', $laporan->id) }}" class="btn-action-icon edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn-action-icon view" title="Detail" onclick="showDetail({{ $laporan->id }}, '{{ addslashes($laporan->deskripsi_kemajuan) }}', {{ $laporan->hasil_panen }}, '{{ $laporan->tanggal }}', '{{ $laporan->jenis_tanaman ?? '' }}', '{{ $laporan->user->name ?? 'N/A' }}', '{{ addslashes($laporan->catatan ?? '') }}', {{ $laporan->luas_panen ?? 0 }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('delete.laporan', $laporan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <h5>Tidak ada data laporan</h5>
                                    <p>Belum ada laporan yang tercatat dalam sistem</p>
                                    <a href="{{ route('input.data') }}" class="btn-empty-add">
                                        <i class="fas fa-plus"></i>
                                        Tambah Laporan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade modal-modern" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    document.getElementById('jenisTanamanFilter').addEventListener('change', filterTable);
    document.getElementById('hasilFilter').addEventListener('change', filterTable);
    document.getElementById('startDateFilter').addEventListener('change', filterTable);
    document.getElementById('endDateFilter').addEventListener('change', filterTable);
});

function filterTable() {
    const jenisValue = document.getElementById('jenisTanamanFilter').value;
    const hasilValue = document.getElementById('hasilFilter').value;
    const startDate = document.getElementById('startDateFilter').value;
    const endDate = document.getElementById('endDateFilter').value;

    const rows = document.querySelectorAll('#laporanTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 5) return;

        const deskripsi = row.cells[0].textContent.toLowerCase();
        const hasil = row.cells[1].textContent.toLowerCase();
        const tanggal = row.cells[2].textContent;

        let show = true;

        // Jenis tanaman filter
        if (jenisValue && !deskripsi.includes(jenisValue.toLowerCase())) {
            show = false;
        }

        // Hasil filter
        if (hasilValue) {
            if (hasilValue === 'dengan_hasil' && hasil.includes('belum panen')) {
                show = false;
            } else if (hasilValue === 'tanpa_hasil' && !hasil.includes('belum panen')) {
                show = false;
            }
        }

        // Date filter
        if (startDate || endDate) {
            const dateMatch = tanggal.match(/(\d{1,2})\s+(\w+)\s+(\d{4})/);
            if (dateMatch) {
                const months = {
                    'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04',
                    'Mei': '05', 'Jun': '06', 'Jul': '07', 'Agu': '08',
                    'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
                };
                const day = dateMatch[1].padStart(2, '0');
                const month = months[dateMatch[2]] || '01';
                const year = dateMatch[3];
                const rowDate = new Date(`${year}-${month}-${day}`);
                
                if (startDate && rowDate < new Date(startDate)) show = false;
                if (endDate && rowDate > new Date(endDate)) show = false;
            }
        }

        row.style.display = show ? '' : 'none';
    });
}

function showDetail(id, deskripsi, hasilPanen, tanggal, jenisTanaman, petani, catatan, luasPanen) {
    const formattedDate = new Date(tanggal).toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
    });
    
    const hasilClass = hasilPanen > 0 ? 'with-result' : 'pending';
    const hasilText = hasilPanen > 0 ? `${hasilPanen.toLocaleString('id-ID')} kg` : 'Belum Panen';
    const hasilIcon = hasilPanen > 0 ? 'check-circle' : 'clock';
    
    document.getElementById('detailContent').innerHTML = `
        <div class="row g-3">
            <div class="col-12">
                <div class="detail-item">
                    <label><i class="fas fa-file-alt me-1"></i> Deskripsi Kemajuan</label>
                    <p>${deskripsi}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-seedling me-1"></i> Jenis Tanaman</label>
                    <p>${jenisTanaman || 'Tidak ditentukan'}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-weight me-1"></i> Hasil Panen</label>
                    <p><span class="harvest-badge ${hasilClass}"><i class="fas fa-${hasilIcon} me-1"></i>${hasilText}</span></p>
                </div>
            </div>
            ${luasPanen > 0 ? `
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-ruler-combined me-1"></i> Luas Panen</label>
                    <p>${luasPanen} ha</p>
                </div>
            </div>
            ` : ''}
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-calendar me-1"></i> Tanggal</label>
                    <p>${formattedDate}</p>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-item">
                    <label><i class="fas fa-user me-1"></i> Petani</label>
                    <p>${petani}</p>
                </div>
            </div>
            ${catatan ? `
            <div class="col-12">
                <div class="detail-item">
                    <label><i class="fas fa-sticky-note me-1"></i> Catatan</label>
                    <p>${catatan}</p>
                </div>
            </div>
            ` : ''}
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}
</script>
@endsection
