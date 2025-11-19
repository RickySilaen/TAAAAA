<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Default cache TTL (Time To Live) in seconds.
     */
    protected int $defaultTtl = 3600; // 1 hour

    /**
     * Cache tags for organized cache management.
     */
    protected array $tags = [];

    /**
     * Remember a value in cache.
     */
    public function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        $ttl = $ttl ?? $this->defaultTtl;

        // Check if cache driver supports tagging
        if (! empty($this->tags) && $this->supportsTagging()) {
            return Cache::tags($this->tags)->remember($key, $ttl, $callback);
        }

        // Prefix key with tags for non-tagging drivers
        if (! empty($this->tags)) {
            $key = implode('.', $this->tags) . '.' . $key;
        }

        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Check if current cache driver supports tagging.
     */
    protected function supportsTagging(): bool
    {
        $driver = config('cache.default');
        $supportedDrivers = ['redis', 'memcached', 'array'];

        return in_array($driver, $supportedDrivers);
    }

    /**
     * Set cache tags for the next operation.
     *
     * @return $this
     */
    public function tags(string|array $tags): self
    {
        $this->tags = is_array($tags) ? $tags : [$tags];

        return $this;
    }

    /**
     * Flush cache by tags.
     */
    public function flush(string|array $tags): bool
    {
        if ($this->supportsTagging()) {
            $tags = is_array($tags) ? $tags : [$tags];

            return Cache::tags($tags)->flush();
        }

        // For non-tagging drivers, clear all cache
        // In production with Redis, this will work properly
        return Cache::flush();
    }

    /**
     * Cache query results with automatic invalidation.
     *
     * @param  string  $model  Model class name
     * @param  string  $method  Method to call (e.g., 'all', 'where')
     * @param  array  $params  Method parameters
     * @param  int|null  $ttl  Cache TTL
     */
    public function cacheQuery(string $model, string $method, array $params = [], ?int $ttl = null): mixed
    {
        $key = $this->generateQueryKey($model, $method, $params);
        $modelName = class_basename($model);

        return $this->tags(['queries', $modelName])->remember($key, function () use ($model, $method, $params) {
            return call_user_func_array([$model, $method], $params);
        }, $ttl);
    }

    /**
     * Cache model by ID.
     */
    public function cacheModel(string $model, int $id, ?int $ttl = null): ?Model
    {
        $modelName = class_basename($model);
        $key = "{$modelName}.{$id}";

        return $this->tags(['models', $modelName])->remember($key, function () use ($model, $id) {
            return $model::find($id);
        }, $ttl);
    }

    /**
     * Cache collection.
     */
    public function cacheCollection(string $key, callable $callback, ?int $ttl = null): Collection
    {
        return $this->tags('collections')->remember($key, $callback, $ttl);
    }

    /**
     * Cache paginated results.
     */
    public function cachePagination(string $key, callable $callback, ?int $ttl = null): mixed
    {
        return $this->tags('pagination')->remember($key, $callback, $ttl);
    }

    /**
     * Generate cache key for query.
     */
    protected function generateQueryKey(string $model, string $method, array $params): string
    {
        $modelName = class_basename($model);
        $paramsHash = md5(serialize($params));

        return "query.{$modelName}.{$method}.{$paramsHash}";
    }

    /**
     * Invalidate model cache.
     */
    public function invalidateModel(string $model): bool
    {
        $modelName = class_basename($model);

        return $this->flush(['models', $modelName, 'queries']);
    }

    /**
     * Cache public berita (news).
     */
    public function getPublishedBerita(int $limit = 10): mixed
    {
        return $this->tags(['berita', 'public'])->remember(
            "berita.published.{$limit}",
            fn () => \App\Models\Berita::where('status', 'published')
                ->orderBy('tanggal_publikasi', 'desc')
                ->limit($limit)
                ->get(),
            3600 // 1 hour
        );
    }

    /**
     * Cache galeri.
     */
    public function getGaleri(): mixed
    {
        return $this->tags(['galeri', 'public'])->remember(
            'galeri.all',
            fn () => \App\Models\Galeri::orderBy('created_at', 'desc')->get(),
            3600 // 1 hour
        );
    }

    /**
     * Cache user statistics.
     */
    public function getUserStats(int $userId): array
    {
        return $this->tags(['user-stats', "user.{$userId}"])->remember(
            "user.{$userId}.stats",
            function () use ($userId) {
                $user = \App\Models\User::find($userId);

                if (! $user) {
                    return [];
                }

                return [
                    'total_bantuans' => $user->bantuans()->count(),
                    'total_laporans' => $user->laporans()->count(),
                    'approved_bantuans' => $user->bantuans()->where('status', 'approved')->count(),
                    'approved_laporans' => $user->laporans()->where('status', 'approved')->count(),
                    'pending_bantuans' => $user->bantuans()->where('status', 'pending')->count(),
                    'pending_laporans' => $user->laporans()->where('status', 'pending')->count(),
                ];
            },
            1800 // 30 minutes
        );
    }

    /**
     * Cache dashboard statistics.
     */
    public function getDashboardStats(): array
    {
        return $this->tags(['dashboard', 'stats'])->remember(
            'dashboard.stats',
            function () {
                return [
                    'total_users' => \App\Models\User::where('role', 'petani')->count(),
                    'verified_users' => \App\Models\User::where('role', 'petani')
                        ->where('is_verified', true)->count(),
                    'total_bantuans' => \App\Models\Bantuan::count(),
                    'pending_bantuans' => \App\Models\Bantuan::where('status', 'pending')->count(),
                    'total_laporans' => \App\Models\Laporan::count(),
                    'pending_laporans' => \App\Models\Laporan::where('status', 'pending')->count(),
                    'total_berita' => \App\Models\Berita::where('status', 'published')->count(),
                    'total_feedbacks' => \App\Models\Feedback::count(),
                    'unread_feedbacks' => \App\Models\Feedback::where('status', 'unread')->count(),
                ];
            },
            600 // 10 minutes
        );
    }

    /**
     * Warm up common caches (for cron job).
     */
    public function warmUpCache(): void
    {
        // Warm up public berita
        $this->getPublishedBerita(10);
        $this->getPublishedBerita(20);

        // Warm up galeri
        $this->getGaleri();

        // Warm up dashboard stats
        $this->getDashboardStats();
    }

    /**
     * Clear all application caches.
     */
    public function clearAll(): void
    {
        Cache::flush();
    }

    /**
     * Clear specific cache groups.
     */
    public function clearGroups(array $groups): void
    {
        foreach ($groups as $group) {
            $this->flush($group);
        }
    }
}
