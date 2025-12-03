<?php

namespace App\Services;

use App\Models\LaporanBantuan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanBantuanService extends BaseService
{
    /**
     * Get public reports for dashboard.
     */
    public function getPublicReports(int $perPage = 12, ?string $search = null, ?string $jenis = null)
    {
        $query = LaporanBantuan::with(['user', 'bantuan'])
            ->published()
            ->latest('tanggal_pelaporan');

        if ($search) {
            $query->search($search);
        }

        if ($jenis) {
            $query->jenisBantuan($jenis);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get reports for petani (their own reports).
     */
    public function getPetaniReports(int $userId, int $perPage = 10)
    {
        return LaporanBantuan::with(['bantuan', 'verifier'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all reports for admin (with filters).
     */
    public function getAdminReports(array $filters = [], int $perPage = 15)
    {
        $query = LaporanBantuan::with(['user', 'bantuan', 'verifier'])
            ->latest();

        // Apply filters
        if (! empty($filters['status'])) {
            $query->status($filters['status']);
        }

        if (! empty($filters['jenis_bantuan'])) {
            $query->jenisBantuan($filters['jenis_bantuan']);
        }

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['start_date'])) {
            $query->where('tanggal_pelaporan', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->where('tanggal_pelaporan', '<=', $filters['end_date']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Create new report.
     */
    public function createReport(array $data, int $userId): LaporanBantuan
    {
        DB::beginTransaction();

        try {
            // Process photo uploads
            $fotoPaths = [];
            if (! empty($data['foto_bukti'])) {
                $fotoPaths = $this->uploadMultiplePhotos($data['foto_bukti'], $userId);
            }

            // Get user data for auto-fill
            $user = User::find($userId);

            $laporan = LaporanBantuan::create([
                'user_id' => $userId,
                'bantuan_id' => $data['bantuan_id'] ?? null,
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
                'jenis_bantuan' => $data['jenis_bantuan'],
                'jumlah_bantuan' => $data['jumlah_bantuan'] ?? null,
                'satuan' => $data['satuan'] ?? null,
                'foto_bukti' => $fotoPaths,
                'alamat_desa' => $data['alamat_desa'] ?? $user->alamat_desa,
                'alamat_kecamatan' => $data['alamat_kecamatan'] ?? $user->alamat_kecamatan,
                'koordinat' => $data['koordinat'] ?? null,
                'tanggal_penerimaan' => $data['tanggal_penerimaan'] ?? null,
                'tanggal_pelaporan' => now(),
                'status' => 'pending',
                'is_public' => $data['is_public'] ?? true,
            ]);

            DB::commit();

            // Log activity
            Log::info('Laporan bantuan created', [
                'laporan_id' => $laporan->id,
                'user_id' => $userId,
            ]);

            return $laporan;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create laporan bantuan', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
            ]);

            throw $e;
        }
    }

    /**
     * Update report.
     */
    public function updateReport(LaporanBantuan $laporan, array $data, int $userId): bool
    {
        DB::beginTransaction();

        try {
            // Process new photo uploads
            $fotoPaths = $laporan->foto_bukti ?? [];
            if (! empty($data['foto_bukti_new'])) {
                $newPhotos = $this->uploadMultiplePhotos($data['foto_bukti_new'], $userId);
                $fotoPaths = array_merge($fotoPaths, $newPhotos);
            }

            // Remove deleted photos
            if (! empty($data['foto_bukti_delete'])) {
                foreach ($data['foto_bukti_delete'] as $photoPath) {
                    Storage::disk('public')->delete($photoPath);
                    $fotoPaths = array_diff($fotoPaths, [$photoPath]);
                }
            }

            $updateData = [
                'judul' => $data['judul'] ?? $laporan->judul,
                'deskripsi' => $data['deskripsi'] ?? $laporan->deskripsi,
                'jenis_bantuan' => $data['jenis_bantuan'] ?? $laporan->jenis_bantuan,
                'jumlah_bantuan' => $data['jumlah_bantuan'] ?? $laporan->jumlah_bantuan,
                'satuan' => $data['satuan'] ?? $laporan->satuan,
                'foto_bukti' => $fotoPaths,
                'alamat_desa' => $data['alamat_desa'] ?? $laporan->alamat_desa,
                'alamat_kecamatan' => $data['alamat_kecamatan'] ?? $laporan->alamat_kecamatan,
                'tanggal_penerimaan' => $data['tanggal_penerimaan'] ?? $laporan->tanggal_penerimaan,
            ];

            $result = $laporan->update($updateData);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update laporan bantuan', [
                'error' => $e->getMessage(),
                'laporan_id' => $laporan->id,
            ]);

            throw $e;
        }
    }

    /**
     * Upload multiple photos.
     */
    private function uploadMultiplePhotos(array $photos, int $userId): array
    {
        $paths = [];

        foreach ($photos as $photo) {
            if ($photo instanceof UploadedFile) {
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('laporan_bantuan/' . $userId, $filename, 'public');
                $paths[] = $path;
            }
        }

        return $paths;
    }

    /**
     * Verify report (Admin/Petugas).
     */
    public function verifyReport(LaporanBantuan $laporan, int $verifierId, ?string $catatan = null): bool
    {
        return $laporan->verify($verifierId, $catatan);
    }

    /**
     * Reject report.
     */
    public function rejectReport(LaporanBantuan $laporan, int $verifierId, string $catatan): bool
    {
        return $laporan->reject($verifierId, $catatan);
    }

    /**
     * Publish report to public dashboard.
     */
    public function publishReport(LaporanBantuan $laporan): bool
    {
        return $laporan->publish();
    }

    /**
     * Get statistics for decision support.
     */
    public function getStatistics(?string $period = 'month'): array
    {
        $query = LaporanBantuan::query();

        // Filter by period
        if ($period === 'week') {
            $query->where('tanggal_pelaporan', '>=', now()->subWeek());
        } elseif ($period === 'month') {
            $query->where('tanggal_pelaporan', '>=', now()->subMonth());
        } elseif ($period === 'year') {
            $query->where('tanggal_pelaporan', '>=', now()->subYear());
        }

        $total = $query->count();
        $pending = (clone $query)->pending()->count();
        $verified = (clone $query)->verified()->count();
        $published = (clone $query)->published()->count();

        // Group by jenis bantuan
        $byJenis = (clone $query)
            ->select('jenis_bantuan', DB::raw('COUNT(*) as total'), DB::raw('SUM(jumlah_bantuan) as total_jumlah'))
            ->groupBy('jenis_bantuan')
            ->get();

        // Group by location (desa)
        $byDesa = (clone $query)
            ->select('alamat_desa', DB::raw('COUNT(*) as total'))
            ->whereNotNull('alamat_desa')
            ->groupBy('alamat_desa')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Recent reports
        $recentReports = (clone $query)
            ->with(['user', 'bantuan'])
            ->latest()
            ->limit(5)
            ->get();

        return [
            'summary' => [
                'total' => $total,
                'pending' => $pending,
                'verified' => $verified,
                'published' => $published,
                'rejection_rate' => $total > 0 ? round(((clone $query)->status('rejected')->count() / $total) * 100, 2) : 0,
            ],
            'by_jenis' => $byJenis,
            'by_desa' => $byDesa,
            'recent_reports' => $recentReports,
            'period' => $period,
        ];
    }

    /**
     * Get insights and recommendations for decision making.
     */
    public function getInsights(): array
    {
        $stats = $this->getStatistics('month');

        $insights = [];

        // Insight 1: Most reported bantuan type
        if (! empty($stats['by_jenis']) && $stats['by_jenis']->isNotEmpty()) {
            $topJenis = $stats['by_jenis']->sortByDesc('total')->first();
            $insights[] = [
                'type' => 'info',
                'title' => 'Jenis Bantuan Terpopuler',
                'message' => "Bantuan {$topJenis->jenis_bantuan} paling banyak dilaporkan ({$topJenis->total} laporan).",
                'icon' => 'trending-up',
            ];
        }

        // Insight 2: Pending reports
        if ($stats['summary']['pending'] > 10) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Laporan Menunggu Verifikasi',
                'message' => "Ada {$stats['summary']['pending']} laporan yang menunggu verifikasi. Segera tindak lanjuti.",
                'icon' => 'alert-circle',
            ];
        }

        // Insight 3: Top location
        if (! empty($stats['by_desa']) && $stats['by_desa']->isNotEmpty()) {
            $topDesa = $stats['by_desa']->first();
            $insights[] = [
                'type' => 'success',
                'title' => 'Desa Paling Aktif',
                'message' => "Desa {$topDesa->alamat_desa} memiliki partisipasi tertinggi ({$topDesa->total} laporan).",
                'icon' => 'map-pin',
            ];
        }

        // Insight 4: Rejection rate
        if ($stats['summary']['rejection_rate'] > 20) {
            $insights[] = [
                'type' => 'danger',
                'title' => 'Tingkat Penolakan Tinggi',
                'message' => "Tingkat penolakan laporan mencapai {$stats['summary']['rejection_rate']}%. Perlu edukasi kepada petani.",
                'icon' => 'x-circle',
            ];
        }

        return $insights;
    }

    /**
     * Delete report (soft delete).
     */
    public function deleteReport(LaporanBantuan $laporan): bool
    {
        // Delete photos from storage
        if (! empty($laporan->foto_bukti)) {
            foreach ($laporan->foto_bukti as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }

        return $laporan->delete();
    }
}
