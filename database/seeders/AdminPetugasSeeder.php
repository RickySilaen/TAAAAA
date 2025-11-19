<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminPetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pertanian.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'telepon' => '081234567890',
            'alamat_desa' => 'Balige',
            'alamat_kecamatan' => 'Balige',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Create Petugas untuk beberapa desa
        $petugasList = [
            [
                'name' => 'Petugas Balige',
                'email' => 'petugas.balige@pertanian.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'telepon' => '081234567891',
                'alamat_desa' => 'Balige',
                'alamat_kecamatan' => 'Balige',
                'is_verified' => true,
                'verified_at' => now(),
            ],
            [
                'name' => 'Petugas Laguboti',
                'email' => 'petugas.laguboti@pertanian.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'telepon' => '081234567892',
                'alamat_desa' => 'Laguboti',
                'alamat_kecamatan' => 'Laguboti',
                'is_verified' => true,
                'verified_at' => now(),
            ],
            [
                'name' => 'Petugas Lumban Julu',
                'email' => 'petugas.lumbanjulu@pertanian.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'telepon' => '081234567893',
                'alamat_desa' => 'Lumban Julu',
                'alamat_kecamatan' => 'Balige',
                'is_verified' => true,
                'verified_at' => now(),
            ],
        ];

        foreach ($petugasList as $petugas) {
            User::create($petugas);
        }

        $this->command->info('Admin dan Petugas berhasil dibuat!');
        $this->command->info('Login Admin: admin@pertanian.com / admin123');
        $this->command->info('Login Petugas: petugas.balige@pertanian.com / petugas123');
    }
}
