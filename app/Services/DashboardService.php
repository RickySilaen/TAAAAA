<?php

namespace App\Services;

use App\Models\Bantuan;
use App\Models\Berita;
use App\Models\Laporan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * DashboardService.
 *
 * Advanced dashboard with:
 * - Interactive charts data
 * - Real-time statistics
 * - Export to Excel/PDF
 * - Advanced filtering
 * - Trend analysis
 * - Performance metrics
 *
 * @version 1.0.0
 */
class DashboardService
{
    /**
     * Get dashboard overview statistics.
     *
     * @param  string|null  $role  Filter by role
     * @param  array  $filters  Additional filters
     */
    public function getOverviewStats(?string $role = null, array $filters = []): array
    {
        $cacheKey = 'dashboard.overview.' . md5($role . json_encode($filters));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($role, $filters) {
            $startDate = $filters['start_date'] ?? now()->subMonths(6);
            $endDate = $filters['end_date'] ?? now();

            $stats = [
                'users' => $this->getUserStats($role, $startDate, $endDate),
                'bantuan' => $this->getBantuanStats($startDate, $endDate),
                'laporan' => $this->getLaporanStats($startDate, $endDate),
                'berita' => $this->getBeritaStats($startDate, $endDate),
                'growth' => $this->getGrowthMetrics($startDate, $endDate),
                'trends' => $this->getTrendData($startDate, $endDate),
            ];

            return $stats;
        });
    }

    /**
     * Get user statistics.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getUserStats(?string $role, $startDate, $endDate): array
    {
        $query = User::whereBetween('created_at', [$startDate, $endDate]);

        if ($role) {
            $query->where('role', $role);
        }

        $total = $query->count();
        $active = (clone $query)->where('is_verified', true)->count();  // Use custom verification instead of email_verified_at
        $new = (clone $query)->where('created_at', '>=', now()->subDays(30))->count();

        // Role distribution
        $byRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        return [
            'total' => $total,
            'active' => $active,
            'new' => $new,
            'inactive' => $total - $active,
            'by_role' => $byRole,
            'verification_rate' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get bantuan statistics.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getBantuanStats($startDate, $endDate): array
    {
        $query = Bantuan::whereBetween('created_at', [$startDate, $endDate]);

        $total = $query->count();
        $pending = (clone $query)->where('status', 'pending')->count();
        $approved = (clone $query)->where('status', 'approved')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();
        $delivered = (clone $query)->where('status', 'delivered')->count();

        // By type
        $byType = Bantuan::select('jenis_bantuan', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('jenis_bantuan')
            ->pluck('total', 'jenis_bantuan')
            ->toArray();

        // Average processing time
        $avgProcessingTime = Bantuan::where('status', '!=', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('updated_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours'))
            ->value('avg_hours');

        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'delivered' => $delivered,
            'by_type' => $byType,
            'approval_rate' => $total > 0 ? round(($approved / $total) * 100, 2) : 0,
            'rejection_rate' => $total > 0 ? round(($rejected / $total) * 100, 2) : 0,
            'avg_processing_hours' => round($avgProcessingTime ?? 0, 2),
        ];
    }

    /**
     * Get laporan statistics.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getLaporanStats($startDate, $endDate): array
    {
        $query = Laporan::whereBetween('created_at', [$startDate, $endDate]);

        $total = $query->count();
        $verified = (clone $query)->where('status', 'verified')->count();
        $pending = (clone $query)->where('status', 'pending')->count();

        // Total harvest
        $totalHarvest = (clone $query)->sum('hasil_panen');

        // By crop type
        $byCrop = Laporan::select(
            'jenis_tanaman',
            DB::raw('count(*) as total'),
            DB::raw('sum(hasil_panen) as total_harvest')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('jenis_tanaman')
            ->get()
            ->keyBy('jenis_tanaman')
            ->toArray();

        return [
            'total' => $total,
            'verified' => $verified,
            'pending' => $pending,
            'total_harvest' => $totalHarvest,
            'avg_harvest' => $total > 0 ? round($totalHarvest / $total, 2) : 0,
            'by_crop' => $byCrop,
            'verification_rate' => $total > 0 ? round(($verified / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get berita statistics.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getBeritaStats($startDate, $endDate): array
    {
        $total = Berita::whereBetween('created_at', [$startDate, $endDate])->count();
        $published = Berita::where('is_published', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            'total' => $total,
            'published' => $published,
            'draft' => $total - $published,
        ];
    }

    /**
     * Get growth metrics.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getGrowthMetrics($startDate, $endDate): array
    {
        $previousPeriod = now()->parse($startDate)->diffInDays($endDate);
        $previousStart = now()->parse($startDate)->subDays($previousPeriod);
        $previousEnd = $startDate;

        // User growth
        $currentUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousUsers = User::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $userGrowth = $previousUsers > 0
            ? round((($currentUsers - $previousUsers) / $previousUsers) * 100, 2)
            : 100;

        // Bantuan growth
        $currentBantuan = Bantuan::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousBantuan = Bantuan::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $bantuanGrowth = $previousBantuan > 0
            ? round((($currentBantuan - $previousBantuan) / $previousBantuan) * 100, 2)
            : 100;

        // Laporan growth
        $currentLaporan = Laporan::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousLaporan = Laporan::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $laporanGrowth = $previousLaporan > 0
            ? round((($currentLaporan - $previousLaporan) / $previousLaporan) * 100, 2)
            : 100;

        return [
            'users' => [
                'current' => $currentUsers,
                'previous' => $previousUsers,
                'growth' => $userGrowth,
            ],
            'bantuan' => [
                'current' => $currentBantuan,
                'previous' => $previousBantuan,
                'growth' => $bantuanGrowth,
            ],
            'laporan' => [
                'current' => $currentLaporan,
                'previous' => $previousLaporan,
                'growth' => $laporanGrowth,
            ],
        ];
    }

    /**
     * Get trend data for charts.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getTrendData($startDate, $endDate): array
    {
        // Monthly trends
        $monthlyUsers = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyBantuan = Bantuan::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyLaporan = Laporan::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, sum(hasil_panen) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'monthly_users' => $monthlyUsers,
            'monthly_bantuan' => $monthlyBantuan,
            'monthly_harvest' => $monthlyLaporan,
        ];
    }

    /**
     * Get chart data for ApexCharts.
     *
     * @param  string  $type  Chart type (line, bar, pie, donut, area)
     */
    public function getChartData(string $type, array $filters = []): array
    {
        $startDate = $filters['start_date'] ?? now()->subMonths(6);
        $endDate = $filters['end_date'] ?? now();

        return match ($type) {
            'bantuan_status' => $this->getBantuanStatusChart($startDate, $endDate),
            'laporan_crop' => $this->getLaporanCropChart($startDate, $endDate),
            'monthly_trend' => $this->getMonthlyTrendChart($startDate, $endDate),
            'user_growth' => $this->getUserGrowthChart($startDate, $endDate),
            'harvest_trend' => $this->getHarvestTrendChart($startDate, $endDate),
            default => [],
        };
    }

    /**
     * Get bantuan status chart data.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getBantuanStatusChart($startDate, $endDate): array
    {
        $data = Bantuan::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'type' => 'donut',
            'series' => array_values($data),
            'labels' => array_map('ucfirst', array_keys($data)),
            'colors' => ['#ffc107', '#28a745', '#dc3545', '#17a2b8'],
        ];
    }

    /**
     * Get laporan crop chart data.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getLaporanCropChart($startDate, $endDate): array
    {
        $data = Laporan::select('jenis_tanaman', DB::raw('sum(hasil_panen) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('jenis_tanaman')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'jenis_tanaman')
            ->toArray();

        return [
            'type' => 'bar',
            'series' => [
                [
                    'name' => 'Hasil Panen (kg)',
                    'data' => array_values($data),
                ],
            ],
            'categories' => array_keys($data),
            'colors' => ['#28a745'],
        ];
    }

    /**
     * Get monthly trend chart data.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getMonthlyTrendChart($startDate, $endDate): array
    {
        $months = [];
        $current = now()->parse($startDate);
        while ($current <= $endDate) {
            $months[] = $current->format('Y-m');
            $current->addMonth();
        }

        $bantuanData = Bantuan::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $laporanData = Laporan::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $bantuanSeries = [];
        $laporanSeries = [];
        foreach ($months as $month) {
            $bantuanSeries[] = $bantuanData[$month] ?? 0;
            $laporanSeries[] = $laporanData[$month] ?? 0;
        }

        return [
            'type' => 'line',
            'series' => [
                [
                    'name' => 'Bantuan',
                    'data' => $bantuanSeries,
                ],
                [
                    'name' => 'Laporan',
                    'data' => $laporanSeries,
                ],
            ],
            'categories' => $months,
            'colors' => ['#0d6efd', '#28a745'],
        ];
    }

    /**
     * Get user growth chart data.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getUserGrowthChart($startDate, $endDate): array
    {
        $data = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'type' => 'area',
            'series' => [
                [
                    'name' => 'Pengguna Baru',
                    'data' => array_values($data),
                ],
            ],
            'categories' => array_keys($data),
            'colors' => ['#0d6efd'],
        ];
    }

    /**
     * Get harvest trend chart data.
     *
     * @param  mixed  $startDate
     * @param  mixed  $endDate
     */
    protected function getHarvestTrendChart($startDate, $endDate): array
    {
        $data = Laporan::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, sum(hasil_panen) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'type' => 'area',
            'series' => [
                [
                    'name' => 'Total Panen (kg)',
                    'data' => array_values($data),
                ],
            ],
            'categories' => array_keys($data),
            'colors' => ['#28a745'],
        ];
    }

    /**
     * Export dashboard data to Excel.
     *
     * @return string File path
     */
    public function exportToExcel(array $filters = []): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set metadata
        $spreadsheet->getProperties()
            ->setCreator('Sistem Pertanian')
            ->setTitle('Dashboard Report')
            ->setSubject('Dashboard Statistics')
            ->setDescription('Comprehensive dashboard report');

        // Get data
        $stats = $this->getOverviewStats(null, $filters);

        // Header styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0d6efd']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        // Overview Section
        $row = 1;
        $sheet->setCellValue('A' . $row, 'DASHBOARD OVERVIEW');
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($headerStyle);
        $row += 2;

        // User Stats
        $sheet->setCellValue('A' . $row, 'USER STATISTICS');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($headerStyle);
        $row++;
        foreach ($stats['users'] as $key => $value) {
            $sheet->setCellValue('A' . $row, ucwords(str_replace('_', ' ', $key)));
            $sheet->setCellValue('B' . $row, is_array($value) ? json_encode($value) : $value);
            $row++;
        }
        $row++;

        // Bantuan Stats
        $sheet->setCellValue('A' . $row, 'BANTUAN STATISTICS');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($headerStyle);
        $row++;
        foreach ($stats['bantuan'] as $key => $value) {
            $sheet->setCellValue('A' . $row, ucwords(str_replace('_', ' ', $key)));
            $sheet->setCellValue('B' . $row, is_array($value) ? json_encode($value) : $value);
            $row++;
        }
        $row++;

        // Laporan Stats
        $sheet->setCellValue('A' . $row, 'LAPORAN STATISTICS');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($headerStyle);
        $row++;
        foreach ($stats['laporan'] as $key => $value) {
            $sheet->setCellValue('A' . $row, ucwords(str_replace('_', ' ', $key)));
            $sheet->setCellValue('B' . $row, is_array($value) ? json_encode($value) : $value);
            $row++;
        }

        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // Save file
        $filename = 'dashboard_report_' . date('Y-m-d_His') . '.xlsx';
        $filepath = storage_path('app/exports/' . $filename);

        if (! file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);

        return $filepath;
    }

    /**
     * Export dashboard data to PDF.
     *
     * @return string File path
     */
    public function exportToPDF(array $filters = []): string
    {
        $stats = $this->getOverviewStats(null, $filters);
        $charts = [
            'bantuan_status' => $this->getChartData('bantuan_status', $filters),
            'monthly_trend' => $this->getChartData('monthly_trend', $filters),
        ];

        $pdf = Pdf::loadView('reports.dashboard', [
            'stats' => $stats,
            'charts' => $charts,
            'filters' => $filters,
            'generated_at' => now()->format('d M Y H:i:s'),
        ]);

        $filename = 'dashboard_report_' . date('Y-m-d_His') . '.pdf';
        $filepath = storage_path('app/exports/' . $filename);

        if (! file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $pdf->save($filepath);

        return $filepath;
    }
}
