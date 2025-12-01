<?php

namespace App\Models;

use App\Traits\OptimizedQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bantuan.
 *
 * @property int $id
 * @property int $user_id
 * @property string $jenis_bantuan
 * @property int|null $jumlah
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property \Illuminate\Support\Carbon|null $tanggal_permintaan
 * @property string|null $keterangan
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class Bantuan extends Model
{
    use HasFactory;
    use OptimizedQuery;

    protected $fillable = [
        'user_id',
        'jenis_bantuan',
        'jumlah',
        'status',
        'tanggal',
        'tanggal_permintaan',
        'keterangan',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_permintaan' => 'date',
        'jumlah' => 'integer',
    ];

    /**
     * The attributes that should be loaded by default.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Relationship: Bantuan belongs to User.
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
     * Scope: Only pending bantuans.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Only approved bantuans.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope: Only rejected bantuans.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope: Only completed bantuans.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope: Filter by user ID.
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by jenis bantuan.
     */
    public function scopeJenisBantuan(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis_bantuan', $jenis);
    }

    /**
     * Scope: Filter by date range (tanggal_permintaan).
     */
    public function scopeDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('tanggal_permintaan', [$startDate, $endDate]);
    }

    /**
     * Scope: Recent bantuans (last 30 days).
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Order by latest.
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Order by request date.
     */
    public function scopeOrderByRequestDate(Builder $query, string $direction = 'desc'): Builder
    {
        return $query->orderBy('tanggal_permintaan', $direction);
    }

    /**
     * Scope: With user relationship (eager loading).
     */
    public function scopeWithUser(Builder $query): Builder
    {
        return $query->with('user:id,nama_lengkap,email,no_telepon,alamat');
    }

    /**
     * Scope: Search by various fields.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('jenis_bantuan', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
                ->orWhere('catatan', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama_lengkap', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope: Urgent requests (pending > 7 days).
     */
    public function scopeUrgent(Builder $query): Builder
    {
        return $query->where('status', 'pending')
            ->where('tanggal_permintaan', '<=', now()->subDays(7));
    }

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Get days since request.
     */
    public function getDaysSinceRequestAttribute(): int
    {
        return $this->tanggal_permintaan ? now()->diffInDays($this->tanggal_permintaan) : 0;
    }

    /**
     * Get processing time in days.
     */
    public function getProcessingDaysAttribute(): ?int
    {
        if (! $this->tanggal || ! $this->tanggal_permintaan) {
            return null;
        }

        return $this->tanggal->diffInDays($this->tanggal_permintaan);
    }

    /**
     * Check if request is urgent (> 7 days pending).
     */
    public function getIsUrgentAttribute(): bool
    {
        return $this->status === 'pending' && $this->days_since_request > 7;
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'disetujui' => 'blue',
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
            'pending' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
