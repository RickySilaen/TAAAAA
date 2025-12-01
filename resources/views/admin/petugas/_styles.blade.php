<style>
/* ========== PETUGAS PAGE STYLES ========== */

/* Page Header */
.page-header.petugas-header,
.page-header-edit.petugas-header,
.page-header-create.petugas-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3) !important;
    padding: 1.75rem 2rem !important;
    margin-bottom: 1.5rem !important;
    color: #fff !important;
    position: relative !important;
    overflow: hidden !important;
}

.page-header-create.petugas-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
}

.page-header-edit.petugas-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
}

.petugas-header h1 {
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    margin-bottom: 0.25rem !important;
    color: #fff !important;
}

.petugas-header p {
    font-size: 0.9rem !important;
    opacity: 0.9 !important;
    margin-bottom: 0 !important;
    color: #fff !important;
}

/* Header Icon */
.petugas-header .header-icon {
    width: 52px !important;
    height: 52px !important;
    min-width: 52px !important;
    border-radius: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 1.5rem !important;
    color: #fff !important;
    background: rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(10px) !important;
}

/* Header Button */
.petugas-header .btn-header {
    background: rgba(255, 255, 255, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    color: #fff !important;
    font-weight: 600 !important;
    padding: 0.6rem 1.25rem !important;
    border-radius: 10px !important;
    font-size: 0.875rem !important;
    transition: all 0.2s ease !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
}

.petugas-header .btn-header:hover {
    background: rgba(255, 255, 255, 0.3) !important;
    color: #fff !important;
    transform: translateY(-1px) !important;
}

/* Stats Grid */
.petugas-stats-grid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 1.25rem !important;
    margin-bottom: 1.5rem !important;
}

@media (max-width: 992px) {
    .petugas-stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 576px) {
    .petugas-stats-grid {
        grid-template-columns: 1fr !important;
    }
}

/* Stat Card */
.petugas-stat-card {
    background: #fff !important;
    border-radius: 14px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    padding: 1.25rem !important;
    border: 1px solid rgba(0, 0, 0, 0.04) !important;
    transition: all 0.2s ease !important;
}

.petugas-stat-card:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12) !important;
}

.petugas-stat-card .stat-label {
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    color: #64748b !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    margin-bottom: 0.5rem !important;
}

.petugas-stat-card .stat-value {
    font-size: 2rem !important;
    font-weight: 800 !important;
    line-height: 1.2 !important;
    margin-bottom: 0.5rem !important;
}

.petugas-stat-card .stat-value.text-primary { color: #667eea !important; }
.petugas-stat-card .stat-value.text-success { color: #10b981 !important; }
.petugas-stat-card .stat-value.text-warning { color: #f59e0b !important; }

.petugas-stat-card .stat-icon-box {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px !important;
    border-radius: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 1.25rem !important;
    color: #fff !important;
}

.petugas-stat-card .stat-icon-box.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.petugas-stat-card .stat-icon-box.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
}

.petugas-stat-card .stat-icon-box.bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
}

/* Data Table Container */
.petugas-table-container {
    background: #fff !important;
    border-radius: 14px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    overflow: hidden !important;
    border: 1px solid rgba(0, 0, 0, 0.04) !important;
}

/* Table */
.petugas-table {
    width: 100% !important;
    margin-bottom: 0 !important;
    border-collapse: collapse !important;
}

.petugas-table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    font-weight: 600 !important;
    font-size: 0.8rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    padding: 1rem 1.25rem !important;
    border: none !important;
    white-space: nowrap !important;
}

.petugas-table thead th:first-child {
    padding-left: 1.5rem !important;
}

.petugas-table thead th:last-child {
    padding-right: 1.5rem !important;
}

.petugas-table tbody tr {
    border-bottom: 1px solid #f1f5f9 !important;
    transition: all 0.15s ease !important;
}

.petugas-table tbody tr:last-child {
    border-bottom: none !important;
}

.petugas-table tbody tr:hover {
    background: #f8fafc !important;
}

.petugas-table tbody td {
    padding: 1rem 1.25rem !important;
    vertical-align: middle !important;
    border: none !important;
    font-size: 0.9rem !important;
    color: #334155 !important;
}

.petugas-table tbody td:first-child {
    padding-left: 1.5rem !important;
}

.petugas-table tbody td:last-child {
    padding-right: 1.5rem !important;
}

/* User Avatar */
.petugas-avatar {
    width: 40px !important;
    height: 40px !important;
    min-width: 40px !important;
    border-radius: 10px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    color: #fff !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

/* Badge */
.petugas-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.25rem !important;
    padding: 0.35rem 0.75rem !important;
    border-radius: 6px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
}

.petugas-badge.badge-primary {
    background: #667eea !important;
    color: #fff !important;
}

.petugas-badge.badge-success {
    background: #dcfce7 !important;
    color: #166534 !important;
}

.petugas-badge.badge-info {
    background: #dbeafe !important;
    color: #1e40af !important;
}

.petugas-badge.badge-warning {
    background: #fef3c7 !important;
    color: #92400e !important;
}

.petugas-badge.badge-light {
    background: #f1f5f9 !important;
    color: #475569 !important;
}

/* Action Buttons */
.petugas-action-btn {
    width: 34px !important;
    height: 34px !important;
    border-radius: 8px !important;
    border: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 0.85rem !important;
    color: #fff !important;
    cursor: pointer !important;
    transition: all 0.15s ease !important;
    text-decoration: none !important;
}

.petugas-action-btn:hover {
    transform: scale(1.08) !important;
    color: #fff !important;
}

.petugas-action-btn.btn-edit {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
}

.petugas-action-btn.btn-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
}

/* Pagination */
.petugas-pagination {
    background: #f8fafc !important;
    padding: 1rem 1.5rem !important;
    border-top: 1px solid #e2e8f0 !important;
}

.petugas-pagination .pagination-info {
    color: #64748b !important;
    font-size: 0.875rem !important;
}

.petugas-pagination .pagination {
    margin-bottom: 0 !important;
    gap: 0.25rem !important;
}

.petugas-pagination .page-link {
    border-radius: 6px !important;
    padding: 0.4rem 0.75rem !important;
    font-size: 0.875rem !important;
    border: 1px solid #e2e8f0 !important;
    color: #475569 !important;
    background: #fff !important;
}

.petugas-pagination .page-link:hover,
.petugas-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    border-color: transparent !important;
}

/* Empty State */
.petugas-empty-state {
    text-align: center !important;
    padding: 4rem 2rem !important;
}

.petugas-empty-state .empty-icon {
    width: 90px !important;
    height: 90px !important;
    margin: 0 auto 1.5rem !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-radius: 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 2.5rem !important;
    color: #fff !important;
}

.petugas-empty-state .empty-title {
    font-size: 1.4rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
    margin-bottom: 0.5rem !important;
}

.petugas-empty-state .empty-desc {
    color: #64748b !important;
    font-size: 0.95rem !important;
    max-width: 400px !important;
    margin: 0 auto 1.5rem !important;
}

/* Form Card */
.petugas-form-card {
    background: #fff !important;
    border-radius: 14px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid rgba(0, 0, 0, 0.04) !important;
    overflow: hidden !important;
    margin-bottom: 2rem !important;
}

.petugas-form-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 1.25rem 1.5rem !important;
}

.petugas-form-card .card-header h6 {
    font-size: 1rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
    margin-bottom: 0.25rem !important;
}

.petugas-form-card .card-header p {
    font-size: 0.875rem !important;
    color: #64748b !important;
    margin-bottom: 0 !important;
}

.petugas-form-card .card-body {
    padding: 1.5rem !important;
}

/* Form Labels */
.petugas-form-label {
    font-weight: 600 !important;
    font-size: 0.875rem !important;
    margin-bottom: 0.5rem !important;
    color: #374151 !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
}

.petugas-form-label i {
    font-size: 0.875rem !important;
    opacity: 0.7 !important;
}

/* Input Group */
.petugas-input-group {
    display: flex !important;
}

.petugas-input-group .input-icon {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-right: none !important;
    border-radius: 8px 0 0 8px !important;
    color: #64748b !important;
    padding: 0.6rem 0.875rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.petugas-input-group .form-input {
    flex: 1 !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 0 8px 8px 0 !important;
    padding: 0.6rem 1rem !important;
    font-size: 0.9rem !important;
    color: #1f2937 !important;
    transition: all 0.15s ease !important;
    outline: none !important;
}

.petugas-input-group .form-input:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15) !important;
}

.petugas-input-group .form-input.is-invalid {
    border-color: #ef4444 !important;
}

.petugas-input-group .btn-toggle {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-left: none !important;
    border-radius: 0 8px 8px 0 !important;
    color: #64748b !important;
    padding: 0.6rem 0.875rem !important;
    cursor: pointer !important;
}

.petugas-input-group .btn-toggle:hover {
    background: #f1f5f9 !important;
    color: #667eea !important;
}

/* Alert Modern */
.petugas-alert {
    border-radius: 10px !important;
    padding: 1rem 1.25rem !important;
    margin-bottom: 1.25rem !important;
    display: flex !important;
    align-items: flex-start !important;
    gap: 0.75rem !important;
    border: none !important;
}

.petugas-alert i {
    font-size: 1.125rem !important;
    flex-shrink: 0 !important;
    margin-top: 2px !important;
}

.petugas-alert.alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
    color: #991b1b !important;
    border-left: 4px solid #ef4444 !important;
}

.petugas-alert.alert-warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%) !important;
    color: #92400e !important;
    border-left: 4px solid #f59e0b !important;
}

.petugas-alert.alert-info {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
    color: #1e40af !important;
    border-left: 4px solid #3b82f6 !important;
}

.petugas-alert.alert-success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
    color: #065f46 !important;
    border-left: 4px solid #10b981 !important;
}

/* Buttons */
.petugas-btn {
    font-weight: 600 !important;
    border-radius: 8px !important;
    padding: 0.6rem 1.25rem !important;
    font-size: 0.875rem !important;
    transition: all 0.15s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    border: none !important;
    cursor: pointer !important;
    text-decoration: none !important;
}

.petugas-btn.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
}

.petugas-btn.btn-primary:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4) !important;
    color: #fff !important;
}

.petugas-btn.btn-secondary {
    background: #fff !important;
    color: #475569 !important;
    border: 1px solid #e2e8f0 !important;
}

.petugas-btn.btn-secondary:hover {
    background: #f8fafc !important;
    transform: translateY(-2px) !important;
    color: #475569 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .petugas-header {
        padding: 1.25rem 1.5rem !important;
        text-align: center !important;
    }
    
    .petugas-header .d-flex {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .petugas-header .header-icon {
        margin-bottom: 1rem !important;
    }
    
    .petugas-header .text-lg-end {
        text-align: center !important;
        margin-top: 1rem !important;
    }
    
    .petugas-table-container {
        overflow-x: auto !important;
    }
    
    .petugas-table thead th,
    .petugas-table tbody td {
        padding: 0.75rem 1rem !important;
        font-size: 0.8rem !important;
    }
    
    .petugas-form-card .card-body {
        padding: 1.25rem !important;
    }
    
    .petugas-btn {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>
