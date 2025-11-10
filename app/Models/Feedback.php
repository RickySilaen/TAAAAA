<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'subjek',
        'pesan',
        'kategori',
        'status',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
