<?php

namespace App\Models;

use App\Traits\OptimizedQuery;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $role
 * @property string|null $alamat_desa
 * @property string|null $alamat_kecamatan
 * @property string|null $telepon
 * @property float|null $luas_lahan
 * @property string|null $profile_picture
 * @property bool $is_verified
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bantuan[] $bantuans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Laporan[] $laporans
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use OptimizedQuery;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // admin/petani/petugas
        'alamat_desa',
        'alamat_kecamatan',
        'telepon',
        'luas_lahan',
        'profile_picture',
        'is_verified',   // Status verifikasi akun
        'verified_at',   // Waktu verifikasi
        'verified_by',   // ID petugas yang memverifikasi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function bantuans()
    {
        return $this->hasMany(Bantuan::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Laporan bantuan yang dibuat user.
     */
    public function laporanBantuans()
    {
        return $this->hasMany(LaporanBantuan::class);
    }

    /**
     * Laporan bantuan yang diverifikasi oleh user (admin/petugas).
     */
    public function verifiedLaporanBantuans()
    {
        return $this->hasMany(LaporanBantuan::class, 'verified_by');
    }

    /**
     * Relasi ke petugas yang memverifikasi akun ini.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Relasi ke petani yang diverifikasi oleh petugas ini.
     */
    public function verifiedPetani()
    {
        return $this->hasMany(User::class, 'verified_by');
    }
}
