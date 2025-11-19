<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Data Real Kabupaten Toba: 1 Admin, 16 Petugas, 32 Petani.
     */
    public function run(): void
    {
        $kecamatan = [
            'Balige', 'Laguboti', 'Habinsaran', 'Ajibata',
            'Lumban Julu', 'Porsea', 'Silaen', 'Sigumpar',
            'Pintupohan Meranti', 'Nassau', 'Siantar Narumonda',
            'Parmaksian', 'Bonatua Lunasi', 'Tampahan', 'Bor Bor', 'Uluan',
        ];

        $this->command->info('🌾 Seeding Database - Kabupaten Toba');
        $this->command->info('=====================================');

        // 1. CREATE ADMIN
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@tobapertanian.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'telepon' => '081234567890',
            'alamat_desa' => null,
            'alamat_kecamatan' => null,
            'is_verified' => true,
            'verified_at' => now(),
        ]);
        $this->command->info('✅ Admin: admin@tobapertanian.com');

        // 2. CREATE 16 PETUGAS
        $this->command->info('👷 Creating 16 Petugas...');
        foreach ($kecamatan as $index => $kec) {
            User::create([
                'name' => 'Petugas ' . $kec,
                'email' => strtolower(str_replace(' ', '', $kec)) . '@petugas.toba.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'telepon' => '0812' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                'alamat_desa' => $kec,
                'alamat_kecamatan' => $kec,
                'is_verified' => true,
                'verified_at' => now(),
                'verified_by' => 1,
            ]);
            $this->command->info('  ✅ ' . $kec);
        }

        // 3. CREATE 32 PETANI
        $this->command->info('👨‍🌾 Creating 32 Petani...');
        $nama_petani = [
            'Balige' => ['Jonatan Siahaan', 'Maria Situmorang'],
            'Laguboti' => ['Parulian Panggabean', 'Ruth Simbolon'],
            'Habinsaran' => ['Samuel Manurung', 'Esther Hutabarat'],
            'Ajibata' => ['Daniel Simatupang', 'Sarah Lumbantobing'],
            'Lumban Julu' => ['Andreas Sinaga', 'Rebecca Silaen'],
            'Porsea' => ['David Nababan', 'Martha Sihombing'],
            'Silaen' => ['Kristian Tampubolon', 'Debora Silalahi'],
            'Sigumpar' => ['Mikhael Pasaribu', 'Anna Sitorus'],
            'Pintupohan Meranti' => ['Gabriel Siregar', 'Eva Panjaitan'],
            'Nassau' => ['Yohanes Sitanggang', 'Hanna Sibarani'],
            'Siantar Narumonda' => ['Petrus Gultom', 'Magdalena Purba'],
            'Parmaksian' => ['Lukas Hutapea', 'Rahel Simanjuntak'],
            'Bonatua Lunasi' => ['Markus Ambarita', 'Lydia Pardede'],
            'Tampahan' => ['Timotius Simbolon', 'Nora Manurung'],
            'Bor Bor' => ['Filipus Siahaan', 'Ester Nababan'],
            'Uluan' => ['Thomas Panggabean', 'Veronika Situmorang'],
        ];

        $petani_counter = 1;
        foreach ($kecamatan as $kec_idx => $kec) {
            for ($i = 0; $i < 2; $i++) {
                $nama = $nama_petani[$kec][$i];
                $email = strtolower(str_replace(' ', '', $kec)) . '.petani' . ($i + 1) . '@toba.com';

                User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make('petani123'),
                    'role' => 'petani',
                    'telepon' => '0813' . str_pad($petani_counter, 8, '0', STR_PAD_LEFT),
                    'alamat_desa' => $kec . ' Desa ' . ($i + 1),
                    'alamat_kecamatan' => $kec,
                    'luas_lahan' => rand(5, 50) / 10,
                    'is_verified' => ($i == 0) ? true : false,
                    'verified_at' => ($i == 0) ? now() : null,
                    'verified_by' => ($i == 0) ? (2 + $kec_idx) : null,
                ]);

                $status = ($i == 0) ? '✅' : '⏳';
                $this->command->info("  $status {$nama} ({$kec})");
                $petani_counter++;
            }
        }

        $this->command->info('=====================================');
        $this->command->info('🎉 Seeding Completed!');
        $this->command->info('📊 Total: 1 Admin + 16 Petugas + 32 Petani = 49 Users');
        $this->command->info('🔑 Passwords: admin123, petugas123, petani123');
    }
}
