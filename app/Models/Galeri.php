<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal',
        'lokasi',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the user that owns the gallery.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
