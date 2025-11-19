<?php

namespace Database\Factories;

use App\Models\Galeri;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeri>
 */
class GaleriFactory extends Factory
{
    protected $model = Galeri::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoris = [
            'Kegiatan Panen',
            'Pelatihan',
            'Penyerahan Bantuan',
            'Sawah',
            'Kebun',
            'Alat Pertanian',
            'Hasil Panen',
            'Kegiatan Kelompok Tani',
        ];

        $kategori = fake()->randomElement($kategoris);
        $judul = $this->generateTitle($kategori);
        $deskripsi = $this->generateDescription($kategori);

        return [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'foto' => fake()->imageUrl(800, 600, 'agriculture', true),
            'kategori' => $kategori,
            'tanggal' => fake()->dateTimeBetween('-1 year', 'now'),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate title based on category.
     */
    private function generateTitle(string $kategori): string
    {
        return match ($kategori) {
            'Kegiatan Panen' => fake()->randomElement([
                'Panen Raya Padi di Desa ' . fake()->city(),
                'Petani Gembira Saat Panen Jagung',
                'Hasil Panen Melimpah Musim Ini',
                'Panen Perdana Padi Varietas Unggul',
            ]),
            'Pelatihan' => fake()->randomElement([
                'Pelatihan Budidaya Organik',
                'Workshop Pengolahan Pasca Panen',
                'Sosialisasi Teknologi Pertanian Modern',
                'Pelatihan Pembuatan Pupuk Kompos',
            ]),
            'Penyerahan Bantuan' => fake()->randomElement([
                'Penyerahan Bantuan Pupuk Subsidi',
                'Distribusi Bibit Unggul untuk Petani',
                'Bantuan Alat Pertanian dari Pemerintah',
                'Serah Terima Hand Tractor untuk Kelompok Tani',
            ]),
            'Sawah' => fake()->randomElement([
                'Hamparan Sawah Menghijau',
                'Sawah Siap Panen',
                'Sistem Irigasi Sawah Teratur',
                'Pemandangan Sawah Bertingkat',
            ]),
            'Kebun' => fake()->randomElement([
                'Kebun Jagung Produktif',
                'Tanaman Cabai Siap Panen',
                'Kebun Sayuran Organik',
                'Perawatan Kebun Kedelai',
            ]),
            'Alat Pertanian' => fake()->randomElement([
                'Traktor Modern untuk Pengolahan Lahan',
                'Pompa Air Irigasi Otomatis',
                'Alat Semprot Hama Berteknologi',
                'Mesin Perontok Padi Efisien',
            ]),
            'Hasil Panen' => fake()->randomElement([
                'Padi Berkualitas Tinggi',
                'Jagung Grade A Siap Jual',
                'Hasil Panen Sayuran Segar',
                'Kedelai Organik Berkualitas',
            ]),
            'Kegiatan Kelompok Tani' => fake()->randomElement([
                'Rapat Koordinasi Kelompok Tani',
                'Gotong Royong Membersihkan Saluran Irigasi',
                'Musyawarah Jadwal Tanam',
                'Kunjungan Studi Banding ke Daerah Lain',
            ]),
            default => 'Dokumentasi Kegiatan Pertanian',
        };
    }

    /**
     * Generate description based on category.
     */
    private function generateDescription(string $kategori): string
    {
        return match ($kategori) {
            'Kegiatan Panen' => fake()->randomElement([
                'Kegiatan panen yang berlangsung dengan lancar dan hasil yang memuaskan.',
                'Para petani bergotong royong melakukan panen raya dengan penuh semangat.',
                'Hasil panen tahun ini meningkat signifikan dibanding tahun sebelumnya.',
            ]),
            'Pelatihan' => fake()->randomElement([
                'Pelatihan diikuti oleh puluhan petani dengan antusias tinggi.',
                'Narasumber ahli memberikan materi yang sangat bermanfaat untuk petani.',
                'Peserta mendapatkan ilmu dan keterampilan baru yang dapat diterapkan.',
            ]),
            'Penyerahan Bantuan' => fake()->randomElement([
                'Bantuan diserahkan secara simbolis kepada perwakilan kelompok tani.',
                'Petani mengucapkan terima kasih atas bantuan yang diberikan pemerintah.',
                'Bantuan ini sangat membantu meningkatkan produktivitas pertanian.',
            ]),
            'Sawah' => fake()->randomElement([
                'Pemandangan sawah yang indah dan tertata rapi.',
                'Kondisi sawah yang subur dan terawat dengan baik.',
                'Sistem pengairan yang berfungsi optimal untuk pertumbuhan tanaman.',
            ]),
            'Kebun' => fake()->randomElement([
                'Tanaman tumbuh subur dengan perawatan yang intensif.',
                'Kebun yang dikelola dengan baik menghasilkan produk berkualitas.',
                'Penerapan teknik budidaya modern meningkatkan hasil panen.',
            ]),
            'Alat Pertanian' => fake()->randomElement([
                'Penggunaan alat modern meningkatkan efisiensi kerja petani.',
                'Teknologi pertanian membantu meringankan beban kerja.',
                'Investasi alat pertanian memberikan dampak positif jangka panjang.',
            ]),
            'Hasil Panen' => fake()->randomElement([
                'Kualitas hasil panen sangat baik dan sesuai standar pasar.',
                'Produktivitas tinggi berkat perawatan optimal selama masa tanam.',
                'Hasil panen siap dipasarkan dengan harga yang menguntungkan.',
            ]),
            'Kegiatan Kelompok Tani' => fake()->randomElement([
                'Kerjasama antar anggota kelompok tani yang solid dan harmonis.',
                'Musyawarah untuk mengambil keputusan bersama demi kemajuan.',
                'Kegiatan rutin yang memperkuat ikatan dan kerjasama petani.',
            ]),
            default => fake()->sentence(10),
        };
    }

    /**
     * Galeri for specific category.
     */
    public function kategori(string $kategori): static
    {
        return $this->state(function (array $attributes) use ($kategori) {
            return [
                'kategori' => $kategori,
                'judul' => $this->generateTitle($kategori),
                'deskripsi' => $this->generateDescription($kategori),
            ];
        });
    }

    /**
     * Recent galeri.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal' => fake()->dateTimeBetween('-1 month', 'now'),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
