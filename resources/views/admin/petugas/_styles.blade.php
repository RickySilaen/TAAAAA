<style>
:root {
    --primary-color: #667eea;
    --primary-dark: #5a67d8;
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --secondary-color: #edf2f7;
    --text-color: #2d3748;
    --light-text-color: #4a5568;
    --border-color: #e2e8f0;
    --bg-light: #f7fafc;
    --card-bg: #ffffff;

    /* Shadows */
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);

    /* Radius */
    --border-radius-sm: 0.5rem;
    --border-radius-md: 0.75rem;
    --border-radius-lg: 1rem;

    /* Transition */
    --transition-ease: all 0.3s ease;
    --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Base */
body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: var(--text-color);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    min-height: 100vh;
}

.container-fluid {
    padding: 0 1.5rem;
}

/* ========== PAGE HEADER ========== */
.page-header,
.page-header-edit,
.page-header-create {
    background: var(--primary-gradient);
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(102,126,234,0.08);
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.page-header h1,
.page-header-edit h1,
.page-header-create h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.page-header p,
.page-header-edit p,
.page-header-create p {
    font-size: 1.05rem;
    opacity: 0.95;
    max-width: 700px;
}

/* Button inside headers */
.page-header .btn-light {
    background-color: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    font-weight: 600;
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    transition: var(--transition-ease);
}
.page-header .btn-light:hover {
    background-color: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

/* Header variations */
.page-header-create { background: var(--success-gradient); }
.page-header-edit { background: var(--warning-gradient); }

/* ========== ALERT ========== */
.alert-custom {
    border-radius: 14px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 16px rgba(102,126,234,0.06);
    border: none;
}
.alert-custom .fas {
    font-size: 1.4rem;
}
.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #059669;
}
.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #b91c1c;
}
.alert-warning {
    background: linear-gradient(135deg, #fef9c3 0%, #fde68a 100%);
    color: #b45309;
}
.alert-info {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #2563eb;
}

/* ========== STATS GRID ========== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.stat-card {
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(102,126,234,0.08);
    background: #fff;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}
.stat-card .stat-label {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--light-text-color);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.8;
}
.stat-card .stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0.5rem 0;
}
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}

/* ========== DATA TABLE ========== */
.data-table-container {
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(102,126,234,0.08);
    background: #fff;
    overflow: hidden;
    margin-bottom: 2rem;
    display: flex;
    flex-direction: column;
}
.table-responsive {
    max-height: calc(100vh - 300px);
    overflow: auto;
}
.table thead th {
    background: linear-gradient(135deg, #5563d6 0%, #5b47bf 100%);
    color: #fff;
    font-weight: 700;
    font-size: 0.95rem;
    border: none;
    position: sticky;
    top: 0;
    z-index: 30;
    text-align: left;
}
.table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f1f5f9;
}
.table tbody tr:hover {
    background: linear-gradient(90deg, #f8fafc 0%, #ffffff 100%);
    transform: translateX(4px);
    box-shadow: -4px 0 0 0 #667eea, 0 4px 12px rgba(102,126,234,0.08);
}
.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
}
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    background: var(--primary-gradient);
}
.data-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action buttons */
.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    color: #fff;
}
.action-btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}
.btn-edit { background: var(--success-gradient); }
.btn-delete { background: var(--danger-gradient); }

/* Pagination */
.pagination-container {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    padding: 1rem 1.5rem;
    border-top: 1px solid #eef2ff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.pagination-info {
    color: #64748b;
    font-weight: 600;
    font-size: 1rem;
}
.pagination .page-link {
    border-radius: 999px;
    padding: 0.4rem 0.7rem;
    font-size: 0.9rem;
    border: 1px solid #e6eefc;
    color: #475569;
    font-weight: 600;
    margin: 0 2px;
}
.pagination .page-link:hover,
.pagination .page-item.active .page-link {
    background: var(--primary-gradient);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 6px 18px rgba(86,90,179,0.12);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(102,126,234,0.08);
}
.empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    background: var(--success-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
.empty-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 1rem;
}
.empty-description {
    color: #64748b;
    font-size: 1rem;
    max-width: 400px;
    margin: 0 auto 2rem;
}

/* ========== FORM CARD ========== */
.form-card-modern {
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(102,126,234,0.08);
    border: none;
    background-color: var(--card-bg);
    margin-bottom: 2.5rem;
}
.form-card-modern .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    border-radius: 18px 18px 0 0;
    border-bottom: 1px solid #eef2ff;
    padding: 1.5rem 2rem;
}
.form-card-modern .card-body {
    padding: 2rem;
}
.form-label-modern {
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #374151;
}

/* Input styles */
.input-group-modern .form-control-modern {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    box-shadow: none;
    font-size: 1rem;
    padding: 0.75rem 1rem;
    transition: var(--transition-ease);
}
.input-group-modern .form-control-modern:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}
.input-group-text {
    background: #f3f4f6;
    border: none;
    border-radius: 10px 0 0 10px;
}
.btn-toggle-password {
    background: transparent;
    border: none;
    color: #64748b;
    font-size: 1.1rem;
}

/* Alert Modern */
.alert-modern {
    border-radius: 14px;
    border: none;
    box-shadow: 0 4px 16px rgba(102,126,234,0.06);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}
.alert-modern-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #b91c1c;
}
.alert-modern-warning {
    background: linear-gradient(135deg, #fef9c3 0%, #fde68a 100%);
    color: #b45309;
}
.alert-modern-info {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #2563eb;
}

/* Buttons */
.btn-modern-primary {
    background: var(--primary-gradient);
    color: #fff;
    font-weight: 700;
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 16px rgba(102,126,234,0.08);
    padding: 0.75rem 1.75rem;
    transition: var(--transition-ease);
}
.btn-modern-primary:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}
.btn-modern-secondary {
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    padding: 0.75rem 1.75rem;
}
.btn-modern-secondary:hover {
    background-color: #e2e8f0;
    transform: translateY(-2px);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .page-header, .form-card-modern, .data-table-container, .empty-state { padding: 1rem; }
    .header-content h1 { font-size: 1.4rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .table-responsive { font-size: 0.9rem; }
    .stat-value { font-size: 2rem; }
    .page-header-edit, .form-card-modern { padding: 1rem; }
}
@media (max-width: 576px) {
    .table-responsive { font-size: 0.8rem; }
    .action-btn { width: 30px; height: 30px; font-size: 0.8rem; }
}
@media (max-width: 992px) {
    .page-header { padding: 2rem; text-align: center; }
    .page-header h1 { font-size: 2rem; }
    .stats-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
    .table td, .table th { padding: 0.8rem 1rem; font-size: 0.85rem; }
    .btn-modern-primary, .btn-modern-secondary { font-size: 0.9rem; padding: 0.6rem 1.5rem; }
}
</style>
