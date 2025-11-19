<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Optimized Query Trait.
 *
 * Provides methods to optimize database queries with eager loading,
 * select specific columns, and pagination
 */
trait OptimizedQuery
{
    /**
     * Get optimized user query with relations.
     *
     * @param  array  $with  Relations to eager load
     * @param  array|null  $select  Columns to select
     */
    public static function optimizedUserQuery(array $with = [], ?array $select = null): Builder
    {
        $query = static::query();

        // Default relations for users
        $defaultWith = ['bantuans', 'laporans'];
        $relations = ! empty($with) ? $with : $defaultWith;

        // Eager load with count to avoid N+1
        foreach ($relations as $relation) {
            if (method_exists(static::class, $relation)) {
                $query->withCount($relation);
            }
        }

        // Select specific columns if provided
        if ($select) {
            $query->select($select);
        }

        return $query;
    }

    /**
     * Get users with their statistics (optimized).
     */
    public static function withStats(): Builder
    {
        return static::query()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.is_verified',
                'users.created_at',
            ])
            ->withCount([
                'bantuans',
                'laporans',
                'bantuans as approved_bantuans_count' => function ($query) {
                    $query->where('status', 'approved');
                },
                'laporans as approved_laporans_count' => function ($query) {
                    $query->where('status', 'approved');
                },
            ]);
    }

    /**
     * Get pending items with user information.
     */
    public static function withPendingItems(): Builder
    {
        return static::query()
            ->with([
                'bantuans' => function ($query) {
                    $query->where('status', 'pending')
                        ->select('id', 'user_id', 'jenis_bantuan', 'jumlah', 'status', 'created_at')
                        ->latest();
                },
                'laporans' => function ($query) {
                    $query->where('status', 'pending')
                        ->select('id', 'user_id', 'jenis_tanaman', 'hasil_panen', 'status', 'created_at')
                        ->latest();
                },
            ])
            ->select('id', 'name', 'email', 'role', 'is_verified');
    }

    /**
     * Scope for filtering by status with optimizations.
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status)
            ->select([
                'id',
                'user_id',
                'status',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * Scope for latest items with user.
     */
    public function scopeLatestWithUser(Builder $query, int $limit = 10): Builder
    {
        return $query->with([
            'user:id,name,email,role',
        ])
            ->latest()
            ->limit($limit);
    }

    /**
     * Get dashboard statistics (optimized).
     */
    public static function getDashboardStats(): array
    {
        $stats = static::query()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
            ')
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'pending' => $stats->pending ?? 0,
            'approved' => $stats->approved ?? 0,
            'rejected' => $stats->rejected ?? 0,
        ];
    }

    /**
     * Chunk query for memory efficiency.
     */
    public static function processInChunks(int $size, callable $callback): void
    {
        static::query()->chunk($size, $callback);
    }

    /**
     * Get paginated results with eager loading.
     */
    public static function paginatedWith(array $with, int $perPage = 15): mixed
    {
        return static::with($with)->paginate($perPage);
    }
}
