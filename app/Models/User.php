<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
            'email_verified_at' => 'datetime',
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
     * Relasi ke petugas yang memverifikasi akun ini
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Relasi ke petani yang diverifikasi oleh petugas ini
     */
    public function verifiedPetani()
    {
        return $this->hasMany(User::class, 'verified_by');
    }
}
