<?php

namespace App\Models;

use App\Traits\OptimizedQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use OptimizedQuery;

    protected $fillable = [
        'user_id',
        'nama_petani',
        'alamat_desa',
        'deskripsi_kemajuan',
        'hasil_panen',
        'foto_bukti',
        'tanggal',
        'tanggal_panen',
        'jenis_tanaman',
        'catatan',
        'luas_lahan',
        'luas_panen',
        'status',
    ];

    protected $casts = [
        'tanggal_panen' => 'date',
        'tanggal' => 'date',
        'hasil_panen' => 'decimal:2',
        'luas_panen' => 'decimal:2',
        'luas_lahan' => 'decimal:2',
    ];

    /**
     * The attributes that should be loaded by default.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Relationship: Laporan belongs to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // QUERY SCOPES
    // ============================================

    /**
     * Scope: Filter by status.
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Only pending laporans.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Only verified laporans.
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status', 'diverifikasi');
    }

    /**
     * Scope: Only completed laporans.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope: Only rejected laporans.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope: Filter by user ID.
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by jenis tanaman.
     */
    public function scopeJenisTanaman(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis_tanaman', $jenis);
    }

    /**
     * Scope: Filter by date range.
     */
    public function scopeDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('tanggal_panen', [$startDate, $endDate]);
    }

    /**
     * Scope: Recent laporans (last 30 days).
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: High yield laporans (> 5 tons/hectare).
     */
    public function scopeHighYield(Builder $query): Builder
    {
        return $query->whereRaw('(hasil_panen / luas_panen) > 5');
    }

    /**
     * Scope: Order by latest.
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Order by harvest date.
     */
    public function scopeOrderByHarvestDate(Builder $query, string $direction = 'desc'): Builder
    {
        return $query->orderBy('tanggal_panen', $direction);
    }

    /**
     * Scope: With user relationship (eager loading).
     */
    public function scopeWithUser(Builder $query): Builder
    {
        return $query->with('user:id,nama_lengkap,email,no_telepon');
    }

    /**
     * Scope: Search by various fields.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('jenis_tanaman', 'like', "%{$search}%")
                ->orWhere('deskripsi_kemajuan', 'like', "%{$search}%")
                ->orWhere('catatan', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama_lengkap', 'like', "%{$search}%");
                });
        });
    }

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Get productivity (ton/hectare).
     */
    public function getProductivityAttribute(): ?float
    {
        if (! $this->luas_panen || $this->luas_panen == 0) {
            return null;
        }

        return round($this->hasil_panen / $this->luas_panen, 2);
    }

    /**
     * Get harvest efficiency (%).
     */
    public function getHarvestEfficiencyAttribute(): ?float
    {
        if (! $this->luas_lahan || $this->luas_lahan == 0) {
            return null;
        }

        return round(($this->luas_panen / $this->luas_lahan) * 100, 2);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'diverifikasi' => 'blue',
            'selesai' => 'green',
            'ditolak' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'diverifikasi' => 'Terverifikasi',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
