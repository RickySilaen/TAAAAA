/**
 * Interactive Dashboard with ApexCharts
 * 
 * Features:
 * - Real-time data updates
 * - Interactive charts (Line, Bar, Pie, Donut, Area)
 * - Export to Excel/PDF
 * - Advanced filtering
 * - Responsive design
 */

class DashboardCharts {
    constructor(options = {}) {
        this.apiUrl = options.apiUrl || '/api/dashboard';
        this.refreshInterval = options.refreshInterval || 60000; // 1 minute
        this.autoRefresh = options.autoRefresh !== false;
        
        this.charts = {};
        this.filters = {
            start_date: this.getDefaultStartDate(),
            end_date: this.getDefaultEndDate(),
        };
        
        this.init();
    }

    /**
     * Initialize dashboard
     */
    init() {
        this.initializeCharts();
        this.attachEventListeners();
        this.loadData();
        
        if (this.autoRefresh) {
            this.startAutoRefresh();
        }
    }

    /**
     * Get default start date (6 months ago)
     */
    getDefaultStartDate() {
        const date = new Date();
        date.setMonth(date.getMonth() - 6);
        return date.toISOString().split('T')[0];
    }

    /**
     * Get default end date (today)
     */
    getDefaultEndDate() {
        return new Date().toISOString().split('T')[0];
    }

    /**
     * Initialize all charts
     */
    initializeCharts() {
        // Bantuan Status Donut Chart
        if (document.getElementById('chart-bantuan-status')) {
            this.charts.bantuanStatus = new ApexCharts(
                document.getElementById('chart-bantuan-status'),
                this.getChartOptions('donut', 'bantuan_status')
            );
            this.charts.bantuanStatus.render();
        }

        // Laporan Crop Bar Chart
        if (document.getElementById('chart-laporan-crop')) {
            this.charts.laporanCrop = new ApexCharts(
                document.getElementById('chart-laporan-crop'),
                this.getChartOptions('bar', 'laporan_crop')
            );
            this.charts.laporanCrop.render();
        }

        // Monthly Trend Line Chart
        if (document.getElementById('chart-monthly-trend')) {
            this.charts.monthlyTrend = new ApexCharts(
                document.getElementById('chart-monthly-trend'),
                this.getChartOptions('line', 'monthly_trend')
            );
            this.charts.monthlyTrend.render();
        }

        // User Growth Area Chart
        if (document.getElementById('chart-user-growth')) {
            this.charts.userGrowth = new ApexCharts(
                document.getElementById('chart-user-growth'),
                this.getChartOptions('area', 'user_growth')
            );
            this.charts.userGrowth.render();
        }

        // Harvest Trend Area Chart
        if (document.getElementById('chart-harvest-trend')) {
            this.charts.harvestTrend = new ApexCharts(
                document.getElementById('chart-harvest-trend'),
                this.getChartOptions('area', 'harvest_trend')
            );
            this.charts.harvestTrend.render();
        }
    }

    /**
     * Get chart options
     */
    getChartOptions(type, dataType) {
        const commonOptions = {
            chart: {
                fontFamily: 'inherit',
                foreColor: '#6c757d',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false,
                    },
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 5,
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 300,
                    },
                    legend: {
                        position: 'bottom',
                    },
                },
            }],
        };

        const typeOptions = {
            donut: {
                chart: {
                    type: 'donut',
                    height: 350,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '16px',
                                    fontWeight: 600,
                                },
                            },
                        },
                    },
                },
                legend: {
                    position: 'bottom',
                    fontSize: '14px',
                },
            },
            bar: {
                chart: {
                    type: 'bar',
                    height: 350,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5,
                        dataLabels: {
                            position: 'top',
                        },
                    },
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ['#304758'],
                    },
                },
            },
            line: {
                chart: {
                    type: 'line',
                    height: 350,
                },
                markers: {
                    size: 5,
                    hover: {
                        size: 7,
                    },
                },
                legend: {
                    position: 'top',
                },
            },
            area: {
                chart: {
                    type: 'area',
                    height: 350,
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                    },
                },
                markers: {
                    size: 0,
                },
            },
        };

        return {
            ...commonOptions,
            ...typeOptions[type],
            series: [],
            labels: [],
            xaxis: {
                categories: [],
            },
        };
    }

    /**
     * Load dashboard data
     */
    async loadData() {
        try {
            this.showLoading();

            // Load overview stats
            await this.loadOverviewStats();

            // Load chart data
            await this.loadChartData();

            this.hideLoading();

        } catch (error) {
            console.error('Error loading dashboard data:', error);
            this.showError('Gagal memuat data dashboard');
        }
    }

    /**
     * Load overview statistics
     */
    async loadOverviewStats() {
        const params = new URLSearchParams(this.filters);
        const response = await fetch(`${this.apiUrl}/overview?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) throw new Error('Failed to load overview stats');

        const data = await response.json();
        this.updateOverviewCards(data);
    }

    /**
     * Update overview stat cards
     */
    updateOverviewCards(data) {
        // Update user stats
        this.updateCard('total-users', data.users?.total);
        this.updateCard('active-users', data.users?.active);
        this.updateCard('new-users', data.users?.new);
        this.updateCard('verification-rate', data.users?.verification_rate + '%');

        // Update bantuan stats
        this.updateCard('total-bantuan', data.bantuan?.total);
        this.updateCard('pending-bantuan', data.bantuan?.pending);
        this.updateCard('approved-bantuan', data.bantuan?.approved);
        this.updateCard('approval-rate', data.bantuan?.approval_rate + '%');

        // Update laporan stats
        this.updateCard('total-laporan', data.laporan?.total);
        this.updateCard('verified-laporan', data.laporan?.verified);
        this.updateCard('total-harvest', this.formatNumber(data.laporan?.total_harvest) + ' kg');
        this.updateCard('avg-harvest', this.formatNumber(data.laporan?.avg_harvest) + ' kg');

        // Update growth indicators
        this.updateGrowthIndicator('user-growth', data.growth?.users?.growth);
        this.updateGrowthIndicator('bantuan-growth', data.growth?.bantuan?.growth);
        this.updateGrowthIndicator('laporan-growth', data.growth?.laporan?.growth);
    }

    /**
     * Update stat card
     */
    updateCard(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value ?? '-';
            element.classList.add('updated');
            setTimeout(() => element.classList.remove('updated'), 300);
        }
    }

    /**
     * Update growth indicator
     */
    updateGrowthIndicator(id, growth) {
        const element = document.getElementById(id);
        if (element) {
            const isPositive = growth >= 0;
            element.innerHTML = `
                <i class="bi bi-arrow-${isPositive ? 'up' : 'down'}"></i>
                ${Math.abs(growth)}%
            `;
            element.className = `growth-indicator ${isPositive ? 'positive' : 'negative'}`;
        }
    }

    /**
     * Load chart data
     */
    async loadChartData() {
        const chartTypes = [
            'bantuan_status',
            'laporan_crop',
            'monthly_trend',
            'user_growth',
            'harvest_trend',
        ];

        await Promise.all(chartTypes.map(type => this.loadChart(type)));
    }

    /**
     * Load individual chart
     */
    async loadChart(type) {
        const params = new URLSearchParams({ ...this.filters, type });
        const response = await fetch(`${this.apiUrl}/chart?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) throw new Error(`Failed to load chart: ${type}`);

        const data = await response.json();
        this.updateChart(type, data);
    }

    /**
     * Update chart with new data
     */
    updateChart(type, data) {
        const chartMap = {
            'bantuan_status': 'bantuanStatus',
            'laporan_crop': 'laporanCrop',
            'monthly_trend': 'monthlyTrend',
            'user_growth': 'userGrowth',
            'harvest_trend': 'harvestTrend',
        };

        const chartKey = chartMap[type];
        const chart = this.charts[chartKey];

        if (!chart) return;

        // Update chart data
        chart.updateOptions({
            series: data.series || [],
            labels: data.labels || [],
            xaxis: {
                categories: data.categories || [],
            },
            colors: data.colors || [],
        });
    }

    /**
     * Attach event listeners
     */
    attachEventListeners() {
        // Filter date range
        const startDateInput = document.getElementById('filter-start-date');
        const endDateInput = document.getElementById('filter-end-date');
        const applyFilterBtn = document.getElementById('apply-filter');

        applyFilterBtn?.addEventListener('click', () => {
            this.filters.start_date = startDateInput.value;
            this.filters.end_date = endDateInput.value;
            this.loadData();
        });

        // Export buttons
        document.getElementById('export-excel')?.addEventListener('click', () => {
            this.exportData('excel');
        });

        document.getElementById('export-pdf')?.addEventListener('click', () => {
            this.exportData('pdf');
        });

        // Refresh button
        document.getElementById('refresh-dashboard')?.addEventListener('click', () => {
            this.loadData();
        });
    }

    /**
     * Export data
     */
    async exportData(format) {
        try {
            const params = new URLSearchParams({ ...this.filters, format });
            const response = await fetch(`${this.apiUrl}/export?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) throw new Error('Export failed');

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `dashboard_report_${new Date().toISOString().split('T')[0]}.${format}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            this.showSuccess(`Data berhasil diekspor ke ${format.toUpperCase()}`);

        } catch (error) {
            console.error('Export error:', error);
            this.showError('Gagal mengekspor data');
        }
    }

    /**
     * Start auto-refresh
     */
    startAutoRefresh() {
        this.refreshTimer = setInterval(() => {
            this.loadData();
        }, this.refreshInterval);
    }

    /**
     * Stop auto-refresh
     */
    stopAutoRefresh() {
        if (this.refreshTimer) {
            clearInterval(this.refreshTimer);
            this.refreshTimer = null;
        }
    }

    /**
     * Show loading state
     */
    showLoading() {
        document.body.classList.add('dashboard-loading');
    }

    /**
     * Hide loading state
     */
    hideLoading() {
        document.body.classList.remove('dashboard-loading');
    }

    /**
     * Show success message
     */
    showSuccess(message) {
        // Implement toast notification
        console.log('Success:', message);
    }

    /**
     * Show error message
     */
    showError(message) {
        // Implement toast notification
        console.error('Error:', message);
    }

    /**
     * Format number with thousand separator
     */
    formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num || 0);
    }

    /**
     * Destroy dashboard
     */
    destroy() {
        this.stopAutoRefresh();
        Object.values(this.charts).forEach(chart => chart.destroy());
    }
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('dashboard-charts')) {
            window.dashboardCharts = new DashboardCharts();
        }
    });
} else {
    if (document.getElementById('dashboard-charts')) {
        window.dashboardCharts = new DashboardCharts();
    }
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DashboardCharts;
}
