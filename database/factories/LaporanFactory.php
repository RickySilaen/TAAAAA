<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laporan>
 */
class LaporanFactory extends Factory
{
    protected $model = Laporan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisTanaman = [
            'Padi',
            'Jagung',
            'Kedelai',
            'Kacang Tanah',
            'Ubi Kayu',
            'Ubi Jalar',
            'Kacang Hijau',
            'Cabai',
            'Tomat',
            'Terong',
            'Kangkung',
            'Bayam',
        ];

        $status = ['pending', 'diverifikasi', 'ditolak', 'selesai'];
        $selectedStatus = fake()->randomElement($status);

        // Tanggal panen dalam 1 tahun terakhir
        $tanggalPanen = fake()->dateTimeBetween('-12 months', 'now');

        // Tanggal laporan dibuat setelah panen
        $tanggalLaporan = fake()->dateTimeBetween($tanggalPanen, 'now');

        // Luas lahan antara 0.1 - 5 hektar
        $luasLahan = fake()->randomFloat(2, 0.1, 5);

        // Luas panen bisa sama atau lebih kecil dari luas lahan (80-100%)
        $luasPanen = $luasLahan * fake()->randomFloat(2, 0.8, 1);

        // Hasil panen berdasarkan jenis tanaman (ton/hektar)
        $selectedTanaman = fake()->randomElement($jenisTanaman);
        $hasilPerHektar = match ($selectedTanaman) {
            'Padi' => fake()->randomFloat(2, 3, 7),           // 3-7 ton/ha
            'Jagung' => fake()->randomFloat(2, 4, 8),         // 4-8 ton/ha
            'Kedelai' => fake()->randomFloat(2, 1, 2.5),      // 1-2.5 ton/ha
            'Kacang Tanah' => fake()->randomFloat(2, 1.5, 3), // 1.5-3 ton/ha
            'Ubi Kayu' => fake()->randomFloat(2, 15, 30),     // 15-30 ton/ha
            'Ubi Jalar' => fake()->randomFloat(2, 10, 20),    // 10-20 ton/ha
            'Kacang Hijau' => fake()->randomFloat(2, 0.8, 1.5), // 0.8-1.5 ton/ha
            'Cabai' => fake()->randomFloat(2, 5, 12),         // 5-12 ton/ha
            'Tomat' => fake()->randomFloat(2, 20, 40),        // 20-40 ton/ha
            'Terong' => fake()->randomFloat(2, 15, 25),       // 15-25 ton/ha
            'Kangkung' => fake()->randomFloat(2, 8, 15),      // 8-15 ton/ha
            'Bayam' => fake()->randomFloat(2, 6, 12),         // 6-12 ton/ha
            default => fake()->randomFloat(2, 1, 10),
        };

        $hasilPanen = $luasPanen * $hasilPerHektar;

        // Generate realistic descriptions
        $deskripsiKemajuan = fake()->optional(0.8)->randomElement([
            'Pertumbuhan tanaman sangat baik, tidak ada hama yang signifikan.',
            'Cuaca mendukung, hasil panen memuaskan.',
            'Ada sedikit gangguan hama tikus pada fase vegetatif, namun dapat diatasi.',
            'Kualitas hasil panen sangat baik, ukuran bulir/buah di atas rata-rata.',
            'Terjadi kekeringan singkat pada fase generatif, namun tidak terlalu berpengaruh.',
            'Perawatan intensif menghasilkan produktivitas tinggi.',
            'Penggunaan pupuk organik meningkatkan kualitas hasil panen.',
            'Sistem irigasi berfungsi dengan baik sepanjang musim tanam.',
        ]);

        $catatan = fake()->optional(0.6)->randomElement([
            'Perlu perbaikan saluran irigasi untuk musim tanam berikutnya.',
            'Hasil panen sudah dijual ke pengepul lokal.',
            'Sebagian hasil disimpan untuk konsumsi sendiri.',
            'Kualitas panen grade A, harga jual memuaskan.',
            'Perlu penambahan pupuk organik untuk musim depan.',
            'Menggunakan varietas unggul baru dengan hasil yang baik.',
            'Panen dilakukan secara bertahap sesuai kematangan.',
        ]);

        return [
            'user_id' => User::where('role', 'petani')->inRandomOrder()->first()?->id ?? User::factory(),
            'jenis_tanaman' => $selectedTanaman,
            'hasil_panen' => round($hasilPanen, 2),
            'luas_panen' => round($luasPanen, 2),
            'luas_lahan' => round($luasLahan, 2),
            'deskripsi_kemajuan' => $deskripsiKemajuan,
            'tanggal' => $tanggalLaporan,
            'tanggal_panen' => $tanggalPanen,
            'catatan' => $catatan,
            'status' => $selectedStatus,
            'created_at' => $tanggalLaporan,
            'updated_at' => fake()->dateTimeBetween($tanggalLaporan, 'now'),
        ];
    }

    /**
     * Indicate that the laporan is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the laporan is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diverifikasi',
        ]);
    }

    /**
     * Indicate that the laporan is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ditolak',
            'catatan' => fake()->randomElement([
                'Data tidak lengkap, mohon dilengkapi.',
                'Hasil panen tidak sesuai dengan luas lahan.',
                'Perlu verifikasi lapangan lebih lanjut.',
                'Foto dokumentasi kurang jelas.',
                'Tanggal panen tidak sesuai dengan musim tanam.',
            ]),
        ]);
    }

    /**
     * Indicate that the laporan is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }

    /**
     * Laporan for specific crop type.
     */
    public function jenisTanaman(string $jenis): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_tanaman' => $jenis,
        ]);
    }

    /**
     * High yield laporan.
     */
    public function highYield(): static
    {
        return $this->state(function (array $attributes) {
            $luasLahan = fake()->randomFloat(2, 2, 5); // Larger farms
            $luasPanen = $luasLahan * 0.95; // High harvest percentage

            // High productivity
            $hasilPerHektar = match ($attributes['jenis_tanaman']) {
                'Padi' => fake()->randomFloat(2, 6, 7),
                'Jagung' => fake()->randomFloat(2, 7, 8),
                'Kedelai' => fake()->randomFloat(2, 2, 2.5),
                default => fake()->randomFloat(2, 8, 10),
            };

            return [
                'luas_lahan' => round($luasLahan, 2),
                'luas_panen' => round($luasPanen, 2),
                'hasil_panen' => round($luasPanen * $hasilPerHektar, 2),
                'deskripsi_kemajuan' => 'Hasil panen sangat memuaskan dengan produktivitas tinggi. Perawatan intensif dan penggunaan varietas unggul memberikan hasil maksimal.',
            ];
        });
    }

    /**
     * Low yield laporan.
     */
    public function lowYield(): static
    {
        return $this->state(function (array $attributes) {
            $luasLahan = fake()->randomFloat(2, 0.1, 1); // Smaller farms
            $luasPanen = $luasLahan * fake()->randomFloat(2, 0.6, 0.8); // Low harvest percentage

            // Low productivity
            $hasilPerHektar = match ($attributes['jenis_tanaman']) {
                'Padi' => fake()->randomFloat(2, 2, 3),
                'Jagung' => fake()->randomFloat(2, 3, 4),
                'Kedelai' => fake()->randomFloat(2, 0.8, 1.2),
                default => fake()->randomFloat(2, 2, 4),
            };

            return [
                'luas_lahan' => round($luasLahan, 2),
                'luas_panen' => round($luasPanen, 2),
                'hasil_panen' => round($luasPanen * $hasilPerHektar, 2),
                'deskripsi_kemajuan' => fake()->randomElement([
                    'Terjadi kekeringan yang cukup parah pada fase generatif.',
                    'Serangan hama tikus cukup berat, mengurangi hasil panen.',
                    'Cuaca tidak mendukung selama musim tanam.',
                    'Kualitas bibit kurang baik, mempengaruhi produktivitas.',
                ]),
            ];
        });
    }
}
