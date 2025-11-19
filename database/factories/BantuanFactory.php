<?php

namespace Database\Factories;

use App\Models\Bantuan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bantuan>
 */
class BantuanFactory extends Factory
{
    protected $model = Bantuan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisBantuan = [
            'Pupuk Organik',
            'Pupuk Urea',
            'Pupuk NPK',
            'Bibit Padi',
            'Bibit Jagung',
            'Bibit Kedelai',
            'Pestisida Organik',
            'Herbisida',
            'Alat Semprot',
            'Traktor Mini',
            'Hand Tractor',
            'Pompa Air',
            'Terpal',
            'Karung',
            'Dana Tunai',
        ];

        $status = ['pending', 'disetujui', 'ditolak', 'selesai'];
        $selectedStatus = fake()->randomElement($status);

        // Tanggal permintaan dalam 6 bulan terakhir
        $tanggalPermintaan = fake()->dateTimeBetween('-6 months', 'now');

        // Jika disetujui/selesai, ada tanggal persetujuan/selesai
        $tanggal = null;
        if (in_array($selectedStatus, ['disetujui', 'selesai'])) {
            $tanggal = fake()->dateTimeBetween($tanggalPermintaan, 'now');
        }

        return [
            'user_id' => User::where('role', 'petani')->inRandomOrder()->first()?->id ?? User::factory(),
            'jenis_bantuan' => fake()->randomElement($jenisBantuan),
            'jumlah' => fake()->numberBetween(1, 100),
            'status' => $selectedStatus,
            'tanggal' => $tanggal,
            'tanggal_permintaan' => $tanggalPermintaan,
            'keterangan' => fake()->optional(0.7)->paragraph(),
            'created_at' => $tanggalPermintaan,
            'updated_at' => $tanggal ?? $tanggalPermintaan,
        ];
    }

    /**
     * Indicate that the bantuan is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'tanggal' => null,
        ]);
    }

    /**
     * Indicate that the bantuan is approved.
     */
    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPermintaan = $attributes['tanggal_permintaan'] ?? now()->subDays(rand(1, 30));

            return [
                'status' => 'disetujui',
                'tanggal' => fake()->dateTimeBetween($tanggalPermintaan, 'now'),
            ];
        });
    }

    /**
     * Indicate that the bantuan is rejected.
     */
    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPermintaan = $attributes['tanggal_permintaan'] ?? now()->subDays(rand(1, 30));

            return [
                'status' => 'ditolak',
                'tanggal' => fake()->dateTimeBetween($tanggalPermintaan, 'now'),
                'keterangan' => fake()->randomElement([
                    'Data tidak lengkap',
                    'Kuota bantuan sudah habis',
                    'Tidak memenuhi kriteria',
                    'Sudah menerima bantuan serupa',
                    'Verifikasi lapangan tidak sesuai',
                ]),
            ];
        });
    }

    /**
     * Indicate that the bantuan is completed.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPermintaan = $attributes['tanggal_permintaan'] ?? now()->subDays(rand(30, 90));
            $tanggalSelesai = fake()->dateTimeBetween($tanggalPermintaan, 'now');

            return [
                'status' => 'selesai',
                'tanggal' => $tanggalSelesai,
                'keterangan' => fake()->randomElement([
                    'Bantuan sudah diterima dengan baik',
                    'Sudah diserahkan ke petani',
                    'Bantuan sudah digunakan untuk penanaman',
                    'Tanda terima sudah ditandatangani',
                ]),
                'updated_at' => $tanggalSelesai,
            ];
        });
    }

    /**
     * Bantuan for specific jenis.
     */
    public function jenis(string $jenis): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_bantuan' => $jenis,
        ]);
    }
}
