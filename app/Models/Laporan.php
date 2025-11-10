<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'nama_petani',
        'alamat_desa',
        'deskripsi_kemajuan',
        'hasil_panen',
        'foto_bukti',
        'tanggal',
        'jenis_tanaman',
        'catatan_laporan',
        'luas_lahan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
