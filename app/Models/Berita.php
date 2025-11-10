<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'penulis',
        'status',
        'tanggal_publikasi'
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];
}
