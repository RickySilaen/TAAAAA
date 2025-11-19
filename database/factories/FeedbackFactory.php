<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoris = [
            'Saran',
            'Keluhan',
            'Pertanyaan',
            'Pujian',
            'Lainnya',
        ];

        $statuses = ['pending', 'ditanggapi', 'selesai'];
        $kategori = fake()->randomElement($kategoris);
        $status = fake()->randomElement($statuses);

        // Generate feedback based on category
        [$nama, $pesan] = $this->generateFeedback($kategori);

        $createdAt = fake()->dateTimeBetween('-3 months', 'now');
        $tanggapan = null;

        if (in_array($status, ['ditanggapi', 'selesai'])) {
            $tanggapan = $this->generateResponse($kategori);
        }

        return [
            'nama' => $nama,
            'email' => fake()->safeEmail(),
            'telepon' => fake()->optional(0.7)->numerify('08##-####-####'),
            'kategori' => $kategori,
            'pesan' => $pesan,
            'status' => $status,
            'tanggapan' => $tanggapan,
            'created_at' => $createdAt,
            'updated_at' => $tanggapan ? fake()->dateTimeBetween($createdAt, 'now') : $createdAt,
        ];
    }

    /**
     * Generate realistic feedback based on category.
     */
    private function generateFeedback(string $kategori): array
    {
        $nama = fake()->name();

        $pesan = match ($kategori) {
            'Saran' => fake()->randomElement([
                'Sebaiknya ditambahkan fitur notifikasi real-time untuk status bantuan agar petani bisa langsung tahu.',
                'Saya sarankan ada aplikasi mobile untuk memudahkan petani melaporkan hasil panen dari lapangan.',
                'Perlu ada pelatihan rutin tentang cara menggunakan sistem ini agar semua petani bisa memanfaatkannya.',
                'Bagaimana kalau dibuat forum diskusi online untuk petani berbagi pengalaman?',
                'Sistem pembayaran digital akan sangat membantu dalam transaksi hasil panen.',
                'Perlu ada dashboard khusus untuk melihat statistik perkembangan pertanian di daerah kita.',
            ]),
            'Keluhan' => fake()->randomElement([
                'Saya sudah mengajukan bantuan 2 minggu lalu tapi belum ada kabar. Mohon ditindaklanjuti.',
                'Website sering lambat saat diakses, terutama pada jam kerja.',
                'Proses verifikasi laporan terlalu lama, sudah 1 bulan belum diverifikasi.',
                'Form pengajuan bantuan terlalu rumit, banyak field yang tidak perlu.',
                'Sulit menghubungi petugas lapangan untuk konsultasi.',
                'Data statistik di dashboard tidak update, masih menampilkan data bulan lalu.',
            ]),
            'Pertanyaan' => fake()->randomElement([
                'Bagaimana cara mengajukan bantuan pupuk subsidi? Apa saja syaratnya?',
                'Berapa lama waktu yang dibutuhkan untuk verifikasi laporan hasil panen?',
                'Apakah ada batas maksimal luas lahan untuk mendapatkan bantuan?',
                'Kapan jadwal penyaluran bantuan berikutnya?',
                'Bagaimana cara mengubah data profil petani yang sudah terdaftar?',
                'Apakah bisa mengajukan lebih dari satu jenis bantuan dalam waktu bersamaan?',
            ]),
            'Pujian' => fake()->randomElement([
                'Terima kasih atas sistem yang memudahkan petani untuk melaporkan hasil panen. Sangat membantu!',
                'Prosesnya cepat dan transparan, bantuan yang diajukan langsung direspon. Mantap!',
                'Petugas sangat responsif dalam menjawab pertanyaan. Pelayanan prima!',
                'Website mudah digunakan, bahkan untuk orang awam teknologi seperti saya.',
                'Program bantuan sangat membantu meningkatkan produktivitas pertanian kami.',
                'Sistem tracking status bantuan sangat berguna, kami bisa tahu prosesnya sampai mana.',
            ]),
            default => fake()->paragraph(),
        };

        return [$nama, $pesan];
    }

    /**
     * Generate appropriate response based on category.
     */
    private function generateResponse(string $kategori): string
    {
        return match ($kategori) {
            'Saran' => fake()->randomElement([
                'Terima kasih atas sarannya. Kami akan mempertimbangkan untuk pengembangan fitur di masa mendatang.',
                'Saran yang sangat baik. Tim teknis kami sedang mempelajari kemungkinan implementasinya.',
                'Apresiasi atas masukannya. Fitur tersebut sudah masuk dalam roadmap pengembangan kami.',
            ]),
            'Keluhan' => fake()->randomElement([
                'Mohon maaf atas ketidaknyamanannya. Kami sudah menindaklanjuti kasus Anda dan akan segera memberikan update.',
                'Terima kasih atas laporannya. Tim teknis kami sedang memperbaiki masalah tersebut.',
                'Kami meminta maaf atas keterlambatan. Permintaan Anda sudah kami prioritaskan dan sedang dalam proses.',
            ]),
            'Pertanyaan' => fake()->randomElement([
                'Untuk informasi lebih detail, silakan hubungi kantor dinas pertanian setempat atau petugas lapangan.',
                'Prosesnya membutuhkan waktu 3-7 hari kerja. Status dapat dipantau melalui dashboard.',
                'Informasi lengkap sudah kami kirimkan melalui email. Jika ada pertanyaan lanjutan, silakan hubungi kami.',
            ]),
            'Pujian' => fake()->randomElement([
                'Terima kasih atas apresiasinya. Kami akan terus meningkatkan pelayanan untuk petani.',
                'Kami sangat senang bisa membantu. Kepuasan Anda adalah motivasi kami.',
                'Apresiasi Anda sangat berarti bagi kami. Semoga terus bermanfaat.',
            ]),
            default => 'Terima kasih atas feedback Anda. Kami sangat menghargai masukan untuk perbaikan layanan kami.',
        };
    }

    /**
     * Indicate that the feedback is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'tanggapan' => null,
        ]);
    }

    /**
     * Indicate that the feedback has been responded.
     */
    public function responded(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'ditanggapi',
                'tanggapan' => $this->generateResponse($attributes['kategori']),
            ];
        });
    }

    /**
     * Indicate that the feedback is completed.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'selesai',
                'tanggapan' => $this->generateResponse($attributes['kategori']),
            ];
        });
    }

    /**
     * Feedback for specific category.
     */
    public function kategori(string $kategori): static
    {
        return $this->state(function (array $attributes) use ($kategori) {
            [$nama, $pesan] = $this->generateFeedback($kategori);

            return [
                'kategori' => $kategori,
                'nama' => $nama,
                'pesan' => $pesan,
            ];
        });
    }
}
