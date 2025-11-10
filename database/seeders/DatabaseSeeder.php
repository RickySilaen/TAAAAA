<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert petugas user
        DB::table('users')->insert([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'alamat_desa' => 'Desa X', // Petugas bertugas di Desa X
            'luas_lahan' => 10.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert petugas users
        $petugas1 = DB::table('users')->insertGetId([
            'name' => 'Petugas A',
            'email' => 'petugasa@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'alamat_desa' => 'Desa X',
            'luas_lahan' => 5.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $petugas2 = DB::table('users')->insertGetId([
            'name' => 'Petugas B',
            'email' => 'petugasb@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'alamat_desa' => 'Desa Y',
            'luas_lahan' => 3.5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert bantuans
        DB::table('bantuan')->insert([
            [
                'user_id' => $petugas1,
                'jenis_bantuan' => 'Pupuk',
                'jumlah' => 50,
                'status' => 'Dikirim',
                'tanggal' => '2025-10-09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $petugas2,
                'jenis_bantuan' => 'Benih Jagung',
                'jumlah' => 30,
                'status' => 'Diproses',
                'tanggal' => '2025-10-04',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $petugas1,
                'jenis_bantuan' => 'Alat Pertanian',
                'jumlah' => 2,
                'status' => 'Dikirim',
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert laporans
        DB::table('laporan')->insert([
            [
                'user_id' => $petugas1,
                'nama_petani' => 'Petugas A',
                'alamat_desa' => 'Desa X',
                'jenis_tanaman' => 'Padi',
                'deskripsi_kemajuan' => 'Panen Padi Selesai',
                'hasil_panen' => 100,
                'luas_panen' => 1.5,
                'tanggal' => '2025-10-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $petugas2,
                'nama_petani' => 'Petugas B',
                'alamat_desa' => 'Desa Y',
                'jenis_tanaman' => 'Jagung',
                'deskripsi_kemajuan' => 'Pengaruh Dibuka',
                'hasil_panen' => 0,
                'luas_panen' => 0.0,
                'tanggal' => '2025-10-06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $petugas1,
                'nama_petani' => 'Petugas A',
                'alamat_desa' => 'Desa X',
                'jenis_tanaman' => 'Padi',
                'deskripsi_kemajuan' => 'Laporan baru hari ini',
                'hasil_panen' => 50,
                'luas_panen' => 0.75,
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}