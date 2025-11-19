<?php

namespace App\Repositories;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Collection;

/**
 * Laporan Repository.
 *
 * Handles data access for Laporan (Harvest Report) entities.
 * Provides specialized query methods for harvest report operations.
 */
class LaporanRepository extends BaseRepository
{
    /**
     * LaporanRepository constructor.
     */
    public function __construct(Laporan $model)
    {
        $this->model = $model;
    }

    /**
     * Get laporan by status.
     */
    public function getByStatus(string $status, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->where('status', $status)
            ->latest('tanggal_panen')
            ->get();
    }

    /**
     * Get laporan for a specific user.
     */
    public function getByUser(int $userId, array $with = []): Collection
    {
        return $this->query()
            ->with($with)
            ->where('user_id', $userId)
            ->latest('tanggal_panen')
            ->get();
    }

    /**
     * Get pending laporan (pending).
     */
    public function getPending(array $with = ['user']): Collection
    {
        return $this->getByStatus('pending', $with);
    }

    /**
     * Get verified laporan (terverifikasi).
     */
    public function getVerified(array $with = ['user']): Collection
    {
        return $this->getByStatus('terverifikasi', $with);
    }

    /**
     * Get rejected laporan (ditolak).
     */
    public function getRejected(array $with = ['user']): Collection
    {
        return $this->getByStatus('ditolak', $with);
    }

    /**
     * Get laporan by date range.
     */
    public function getByDateRange(string $startDate, string $endDate, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->whereBetween('tanggal_panen', [$startDate, $endDate])
            ->latest('tanggal_panen')
            ->get();
    }

    /**
     * Get laporan by komoditas.
     */
    public function getByKomoditas(string $komoditas, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->where('komoditas', $komoditas)
            ->latest('tanggal_panen')
            ->get();
    }

    /**
     * Get laporan statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->count(),
            'pending' => $this->count(['status' => 'pending']),
            'verified' => $this->count(['status' => 'terverifikasi']),
            'rejected' => $this->count(['status' => 'ditolak']),
            'total_harvest' => $this->query()->sum('jumlah_panen'),
        ];
    }

    /**
     * Search laporan.
     */
    public function search(string $keyword, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->where(function ($query) use ($keyword) {
                $query->where('komoditas', 'like', "%{$keyword}%")
                    ->orWhere('jenis_tanaman', 'like', "%{$keyword}%")
                    ->orWhere('kualitas', 'like', "%{$keyword}%")
                    ->orWhere('catatan', 'like', "%{$keyword}%");
            })
            ->latest('tanggal_panen')
            ->get();
    }

    /**
     * Get harvest summary by period.
     */
    public function getHarvestSummary(string $startDate, string $endDate): array
    {
        $data = $this->query()
            ->whereBetween('tanggal_panen', [$startDate, $endDate])
            ->where('status', 'terverifikasi')
            ->selectRaw('
                komoditas,
                COUNT(*) as total_reports,
                SUM(jumlah_panen) as total_harvest,
                AVG(jumlah_panen) as avg_harvest,
                SUM(luas_lahan) as total_area
            ')
            ->groupBy('komoditas')
            ->get()
            ->toArray();

        return $data;
    }
}
