<?php

namespace App\Models;

use App\Traits\OptimizedQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\LaporanBantuan.
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $bantuan_id
 * @property string $judul
 * @property string $deskripsi
 * @property string $jenis_bantuan
 * @property float|null $jumlah_bantuan
 * @property string|null $satuan
 * @property array $foto_bukti
 * @property string|null $alamat_desa
 * @property string|null $alamat_kecamatan
 * @property string|null $koordinat
 * @property string $status
 * @property string|null $catatan_verifikasi
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $is_public
 * @property int $views_count
 * @property \Illuminate\Support\Carbon|null $tanggal_penerimaan
 * @property \Illuminate\Support\Carbon $tanggal_pelaporan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class LaporanBantuan extends Model
{
    use HasFactory;
    use OptimizedQuery;
    use SoftDeletes;

    protected $table = 'laporan_bantuans';

    protected $fillable = [
        'user_id',
        'bantuan_id',
        'judul',
        'deskripsi',
        'jenis_bantuan',
        'jumlah_bantuan',
        'satuan',
        'foto_bukti',
        'alamat_desa',
        'alamat_kecamatan',
        'koordinat',
        'status',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
        'is_public',
        'views_count',
        'tanggal_penerimaan',
        'tanggal_pelaporan',
    ];

    protected $casts = [
        'foto_bukti' => 'array',
        'is_public' => 'boolean',
        'views_count' => 'integer',
        'jumlah_bantuan' => 'decimal:2',
        'tanggal_penerimaan' => 'date',
        'tanggal_pelaporan' => 'date',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'status_badge',
        'foto_bukti_urls',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Laporan belongs to User (Petani).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Laporan belongs to Bantuan.
     */
    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class);
    }

    /**
     * Verifier (Admin/Petugas yang memverifikasi).
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Only public reports.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope: Only published reports.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('is_public', true);
    }

    /**
     * Scope: Pending reports.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Verified reports.
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope: Filter by status.
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter by jenis bantuan.
     */
    public function scopeJenisBantuan(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis_bantuan', $jenis);
    }

    /**
     * Scope: Recent reports.
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('tanggal_pelaporan', '>=', now()->subDays($days));
    }

    /**
     * Scope: Search by keyword.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%")
                ->orWhere('jenis_bantuan', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%");
                });
        });
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Menunggu Verifikasi</span>',
            'verified' => '<span class="badge bg-success">Terverifikasi</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
            'published' => '<span class="badge bg-primary">Dipublikasikan</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Get foto bukti URLs.
     */
    public function getFotoBuktiUrlsAttribute(): array
    {
        if (empty($this->foto_bukti)) {
            return [];
        }

        return collect($this->foto_bukti)->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();
    }

    // ============================================
    // METHODS
    // ============================================

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Verify report.
     */
    public function verify(int $verifierId, ?string $catatan = null): bool
    {
        return $this->update([
            'status' => 'verified',
            'verified_by' => $verifierId,
            'verified_at' => now(),
            'catatan_verifikasi' => $catatan,
        ]);
    }

    /**
     * Reject report.
     */
    public function reject(int $verifierId, string $catatan): bool
    {
        return $this->update([
            'status' => 'rejected',
            'verified_by' => $verifierId,
            'verified_at' => now(),
            'catatan_verifikasi' => $catatan,
        ]);
    }

    /**
     * Publish report.
     */
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'is_public' => true,
        ]);
    }

    /**
     * Unpublish report.
     */
    public function unpublish(): bool
    {
        return $this->update([
            'is_public' => false,
        ]);
    }
}
