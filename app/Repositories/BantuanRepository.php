<?php

namespace App\Repositories;

use App\Models\Bantuan;
use Illuminate\Database\Eloquent\Collection;

/**
 * Bantuan Repository.
 *
 * Handles data access for Bantuan (Aid Request) entities.
 * Provides specialized query methods for aid request operations.
 */
class BantuanRepository extends BaseRepository
{
    /**
     * BantuanRepository constructor.
     */
    public function __construct(Bantuan $model)
    {
        $this->model = $model;
    }

    /**
     * Get bantuan by status.
     */
    public function getByStatus(string $status, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->where('status', $status)
            ->latest()
            ->get();
    }

    /**
     * Get bantuan for a specific user.
     */
    public function getByUser(int $userId, array $with = []): Collection
    {
        return $this->query()
            ->with($with)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Get pending bantuan (menunggu).
     */
    public function getPending(array $with = ['user']): Collection
    {
        return $this->getByStatus('menunggu', $with);
    }

    /**
     * Get approved bantuan (disetujui).
     */
    public function getApproved(array $with = ['user']): Collection
    {
        return $this->getByStatus('disetujui', $with);
    }

    /**
     * Get rejected bantuan (ditolak).
     */
    public function getRejected(array $with = ['user']): Collection
    {
        return $this->getByStatus('ditolak', $with);
    }

    /**
     * Get bantuan by date range.
     */
    public function getByDateRange(string $startDate, string $endDate, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->whereBetween('tanggal_permintaan', [$startDate, $endDate])
            ->latest('tanggal_permintaan')
            ->get();
    }

    /**
     * Get bantuan statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->count(),
            'pending' => $this->count(['status' => 'menunggu']),
            'approved' => $this->count(['status' => 'disetujui']),
            'rejected' => $this->count(['status' => 'ditolak']),
        ];
    }

    /**
     * Search bantuan.
     */
    public function search(string $keyword, array $with = ['user']): Collection
    {
        return $this->query()
            ->with($with)
            ->where(function ($query) use ($keyword) {
                $query->where('jenis_bantuan', 'like', "%{$keyword}%")
                    ->orWhere('alasan', 'like', "%{$keyword}%")
                    ->orWhere('keterangan', 'like', "%{$keyword}%");
            })
            ->latest()
            ->get();
    }
}
