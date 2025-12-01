@extends('layouts.app')

@section('title', '📋 Daftar Bantuan - Sistem Pertanian')

@section('content')
<style>
    /* Modern Page Styles */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        color: #059669;
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
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        padding: 16px 24px;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-header h5 {
        margin: 0;
        font-weight: 700;
        color: #059669;
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
        background: #f0fdf4;
    }
    
    .table-modern tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    /* Item Display */
    .item-display {
        display: flex;
        align-items: center;
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
    }
    
    .item-icon.bibit {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    
    .item-icon.pupuk {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }
    
    .item-icon.pestisida {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #2563eb;
    }
    
    .item-icon.alat {
        background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
        color: #9333ea;
    }
    
    .item-info h6 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
    }
    
    .item-info span {
        color: #6b7280;
        font-size: 0.85rem;
    }
    
    /* Quantity Badge */
    .qty-badge {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: #1d4ed8;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    
    /* Status Badge */
    .status-pill {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-pill.sent {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #15803d;
    }
    
    .status-pill.processing {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    
    /* Date Display */
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
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    /* Modal Styles */
    .modal-modern .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
                <h2><i class="fas fa-hand-holding-heart me-2"></i>Daftar Bantuan Pertanian</h2>
                <p>Kelola dan pantau semua bantuan yang telah didistribusikan</p>
                
                <div class="stats-container">
                    <span class="stat-badge">
                        <i class="fas fa-boxes"></i>
                        {{ $bantuans->count() }} Total Bantuan
                    </span>
                    <span class="stat-badge">
                        <i class="fas fa-check-circle"></i>
                        {{ $bantuans->where('status', 'Dikirim')->count() }} Dikirim
                    </span>
                    <span class="stat-badge">
                        <i class="fas fa-clock"></i>
                        {{ $bantuans->where('status', 'Diproses')->count() }} Diproses
                    </span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="header-actions justify-content-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('export.bantuan.pdf') }}" class="btn-export" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </a>
                    <a href="{{ route('input.data') }}" class="btn-add">
                        <i class="fas fa-plus"></i>
                        Tambah Bantuan
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
                    <label class="filter-label">Status</label>
                    <select class="filter-select" id="statusFilter">
                        <option value="">🌱 Semua Status</option>
                        <option value="Diproses">⏳ Diproses</option>
                        <option value="Dikirim">✅ Dikirim</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Jenis Bantuan</label>
                    <select class="filter-select" id="jenisFilter">
                        <option value="">🌾 Semua Jenis</option>
                        <option value="Bibit">🌱 Bibit</option>
                        <option value="Pupuk">🧪 Pupuk</option>
                        <option value="Pestisida">💧 Pestisida</option>
                        <option value="Alat">🔧 Alat</option>
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
            <table class="table-modern" id="bantuanTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-seedling me-2"></i>Jenis Bantuan</th>
                        <th><i class="fas fa-hashtag me-2"></i>Jumlah</th>
                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                        <th class="text-center"><i class="fas fa-cogs me-2"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuans as $bantuan)
                        <tr>
                            <td data-label="Jenis Bantuan">
                                <div class="item-display">
                                    <div class="item-icon {{ strtolower($bantuan->jenis_bantuan) }}">
                                        <i class="fas fa-{{ $bantuan->jenis_bantuan == 'Bibit' ? 'seedling' : ($bantuan->jenis_bantuan == 'Pupuk' ? 'flask' : ($bantuan->jenis_bantuan == 'Pestisida' ? 'spray-can' : 'tools')) }}"></i>
                                    </div>
                                    <div class="item-info">
                                        <h6>{{ $bantuan->jenis_bantuan }}</h6>
                                        <span>{{ $bantuan->user->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Jumlah">
                                <span class="qty-badge">{{ $bantuan->jumlah }} unit</span>
                            </td>
                            <td data-label="Status">
                                <span class="status-pill {{ $bantuan->status == 'Dikirim' ? 'sent' : 'processing' }}">
                                    <i class="fas fa-{{ $bantuan->status == 'Dikirim' ? 'check-circle' : 'clock' }}"></i>
                                    {{ $bantuan->status }}
                                </span>
                            </td>
                            <td data-label="Tanggal">
                                <span class="date-badge">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}
                                </span>
                            </td>
                            <td data-label="Aksi">
                                <div class="action-buttons">
                                    <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn-action-icon edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn-action-icon view" title="Detail" onclick="showDetail({{ $bantuan->id }}, '{{ $bantuan->jenis_bantuan }}', {{ $bantuan->jumlah }}, '{{ $bantuan->status }}', '{{ $bantuan->tanggal }}', '{{ $bantuan->user->name ?? 'N/A' }}', '{{ $bantuan->catatan ?? '' }}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('delete.bantuan', $bantuan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bantuan ini?')">
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
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5>Tidak ada data bantuan</h5>
                                    <p>Belum ada bantuan yang tercatat dalam sistem</p>
                                    <a href="{{ route('input.data') }}" class="btn-empty-add">
                                        <i class="fas fa-plus"></i>
                                        Tambah Bantuan Pertama
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Bantuan</h5>
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
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('jenisFilter').addEventListener('change', filterTable);
    document.getElementById('startDateFilter').addEventListener('change', filterTable);
    document.getElementById('endDateFilter').addEventListener('change', filterTable);
});

function filterTable() {
    const statusValue = document.getElementById('statusFilter').value;
    const jenisValue = document.getElementById('jenisFilter').value;
    const startDate = document.getElementById('startDateFilter').value;
    const endDate = document.getElementById('endDateFilter').value;

    const rows = document.querySelectorAll('#bantuanTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 5) return;

        const jenis = row.cells[0].textContent.toLowerCase();
        const status = row.cells[2].textContent.toLowerCase();
        const tanggal = row.cells[3].textContent;

        let show = true;

        // Status filter
        if (statusValue && !status.includes(statusValue.toLowerCase())) {
            show = false;
        }

        // Jenis filter
        if (jenisValue && !jenis.includes(jenisValue.toLowerCase())) {
            show = false;
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

function showDetail(id, jenis, jumlah, status, tanggal, penerima, catatan) {
    const statusClass = status === 'Dikirim' ? 'sent' : 'processing';
    const formattedDate = new Date(tanggal).toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
    });
    
    document.getElementById('detailContent').innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-seedling me-1"></i> Jenis Bantuan</label>
                    <p>${jenis}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-hashtag me-1"></i> Jumlah</label>
                    <p>${jumlah} unit</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-info-circle me-1"></i> Status</label>
                    <p><span class="status-pill ${statusClass}"><i class="fas fa-${status === 'Dikirim' ? 'check-circle' : 'clock'} me-1"></i>${status}</span></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <label><i class="fas fa-calendar me-1"></i> Tanggal</label>
                    <p>${formattedDate}</p>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-item">
                    <label><i class="fas fa-user me-1"></i> Penerima</label>
                    <p>${penerima}</p>
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
