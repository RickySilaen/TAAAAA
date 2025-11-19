<?php

namespace Database\Factories;

use App\Models\Berita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    protected $model = Berita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoris = [
            'Teknologi Pertanian',
            'Pelatihan',
            'Panen Raya',
            'Bantuan Pemerintah',
            'Inovasi',
            'Pasar',
            'Cuaca',
            'Kesehatan Tanaman',
        ];

        $titles = [
            'Pelatihan Budidaya Padi Organik untuk Petani Toba',
            'Panen Raya Jagung Mencapai Rekor Baru',
            'Pemerintah Salurkan 1000 Ton Pupuk Subsidi',
            'Teknologi Drone untuk Penyemprotan Pestisida',
            'Workshop Pengolahan Pasca Panen yang Efisien',
            'Harga Gabah Naik 15% Bulan Ini',
            'Prakiraan Cuaca: Musim Hujan Tiba Lebih Awal',
            'Cara Mengatasi Hama Wereng pada Tanaman Padi',
            'Program Asuransi Pertanian untuk Petani Toba',
            'Inovasi Sistem Irigasi Hemat Air',
            'Pemanfaatan Pupuk Kompos dari Limbah Pertanian',
            'Kemitraan dengan Pengepul: Jaminan Harga Stabil',
        ];

        $title = fake()->randomElement($titles);
        $slug = Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999);
        $kategori = fake()->randomElement($kategoris);
        $tanggalPublikasi = fake()->dateTimeBetween('-6 months', 'now');

        // Generate realistic content based on category
        $content = $this->generateContent($kategori, $title);

        return [
            'judul' => $title,
            'slug' => $slug,
            'konten' => $content,
            'gambar' => fake()->optional(0.8)->imageUrl(800, 600, 'agriculture', true),
            'kategori' => $kategori,
            'penulis' => fake()->name(),
            'tanggal_publikasi' => $tanggalPublikasi,
            'status' => fake()->randomElement(['draft', 'published']),
            'views' => fake()->numberBetween(0, 1000),
            'created_at' => $tanggalPublikasi,
            'updated_at' => fake()->dateTimeBetween($tanggalPublikasi, 'now'),
        ];
    }

    /**
     * Generate realistic content based on category.
     */
    private function generateContent(string $kategori, string $title): string
    {
        $intro = fake()->paragraph(3);

        $body = match ($kategori) {
            'Teknologi Pertanian' => $this->getTechnologyContent(),
            'Pelatihan' => $this->getTrainingContent(),
            'Panen Raya' => $this->getHarvestContent(),
            'Bantuan Pemerintah' => $this->getGovernmentAidContent(),
            'Inovasi' => $this->getInnovationContent(),
            'Pasar' => $this->getMarketContent(),
            'Cuaca' => $this->getWeatherContent(),
            'Kesehatan Tanaman' => $this->getPlantHealthContent(),
            default => fake()->paragraphs(5, true),
        };

        $conclusion = fake()->paragraph(2);

        return $intro . "\n\n" . $body . "\n\n" . $conclusion;
    }

    private function getTechnologyContent(): string
    {
        return implode("\n\n", [
            'Teknologi pertanian modern semakin berkembang pesat di wilayah Toba Samosir. Penggunaan alat-alat canggih membantu meningkatkan produktivitas dan efisiensi.',
            'Beberapa teknologi yang mulai diterapkan antara lain sistem irigasi tetes, drone untuk penyemprotan, dan sensor kelembaban tanah. Teknologi ini terbukti meningkatkan hasil panen hingga 30%.',
            'Petani yang sudah mengadopsi teknologi ini melaporkan penurunan biaya operasional dan peningkatan kualitas hasil panen. Pemerintah daerah terus mendorong adopsi teknologi melalui program subsidi dan pelatihan.',
        ]);
    }

    private function getTrainingContent(): string
    {
        return implode("\n\n", [
            'Program pelatihan pertanian berkelanjutan terus digalakkan untuk meningkatkan kompetensi petani. Pelatihan ini mencakup berbagai topik mulai dari teknik budidaya hingga manajemen usaha tani.',
            'Peserta pelatihan akan mendapatkan materi teori dan praktik langsung di lapangan. Para instruktur adalah pakar pertanian yang berpengalaman puluhan tahun.',
            'Setelah mengikuti pelatihan, petani diharapkan dapat menerapkan ilmu yang didapat untuk meningkatkan produktivitas lahan mereka. Sertifikat kompetensi juga diberikan kepada peserta yang lulus.',
        ]);
    }

    private function getHarvestContent(): string
    {
        return implode("\n\n", [
            'Musim panen raya kali ini menunjukkan hasil yang sangat memuaskan. Cuaca yang mendukung dan perawatan yang intensif menghasilkan produktivitas di atas rata-rata.',
            'Rata-rata hasil panen mencapai 6-7 ton per hektar untuk padi, dan 8-9 ton per hektar untuk jagung. Ini merupakan peningkatan signifikan dibanding tahun lalu.',
            'Para petani mengapresiasi dukungan pemerintah dalam penyediaan bibit unggul dan pupuk bersubsidi. Kualitas gabah yang dihasilkan juga sangat baik, sehingga harga jual memuaskan.',
        ]);
    }

    private function getGovernmentAidContent(): string
    {
        return implode("\n\n", [
            'Pemerintah melalui Dinas Pertanian menyalurkan bantuan kepada petani untuk mendukung peningkatan produksi pertanian. Bantuan berupa pupuk, bibit, dan alat pertanian.',
            'Program bantuan ini merupakan bagian dari upaya pemerintah untuk mewujudkan ketahanan pangan nasional. Sasaran penerima bantuan adalah petani yang terdaftar dan memenuhi kriteria.',
            'Penyaluran bantuan dilakukan secara transparan dan tepat sasaran. Petani yang menerima bantuan wajib melaporkan penggunaan dan hasil panennya untuk evaluasi program.',
        ]);
    }

    private function getInnovationContent(): string
    {
        return implode("\n\n", [
            'Inovasi di bidang pertanian terus berkembang untuk menjawab tantangan produktivitas dan keberlanjutan. Berbagai metode baru diperkenalkan kepada petani.',
            'Salah satu inovasi yang menarik adalah sistem tanam jajar legowo yang terbukti meningkatkan hasil panen hingga 20%. Metode ini juga lebih efisien dalam penggunaan air dan pupuk.',
            'Petani inovatif yang sudah menerapkan metode baru ini bersedia berbagi pengalaman dengan petani lain. Program pendampingan juga disediakan untuk memastikan keberhasilan adopsi inovasi.',
        ]);
    }

    private function getMarketContent(): string
    {
        return implode("\n\n", [
            'Kondisi pasar pertanian menunjukkan tren yang positif bulan ini. Harga komoditas pertanian utama mengalami kenaikan yang menguntungkan petani.',
            'Kenaikan harga didorong oleh peningkatan permintaan dan berkurangnya pasokan dari daerah lain. Harga gabah kering panen naik menjadi Rp 5.500 per kg, sementara jagung pipilan mencapai Rp 4.800 per kg.',
            'Para pengepul dan pedagang menyatakan optimisme terhadap stabilitas harga hingga akhir tahun. Petani disarankan untuk memanfaatkan momentum ini dengan baik.',
        ]);
    }

    private function getWeatherContent(): string
    {
        return implode("\n\n", [
            'Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) mengeluarkan prakiraan cuaca untuk wilayah Toba Samosir dalam beberapa minggu ke depan.',
            'Diprediksi akan terjadi peningkatan intensitas hujan pada pertengahan bulan. Petani disarankan untuk mengantisipasi dengan perbaikan drainase dan penundaan jadwal penyemprotan pestisida.',
            'Untuk tanaman yang sedang dalam fase generatif, perlu dilakukan pemantauan ekstra terhadap kelembaban. Cuaca ekstrem dapat mempengaruhi kualitas dan kuantitas hasil panen.',
        ]);
    }

    private function getPlantHealthContent(): string
    {
        return implode("\n\n", [
            'Kesehatan tanaman merupakan faktor kunci dalam keberhasilan budidaya pertanian. Pencegahan dan pengendalian hama penyakit harus dilakukan secara terpadu.',
            'Beberapa hama yang sering menyerang tanaman di wilayah ini antara lain wereng, tikus, dan ulat. Pengendalian dapat dilakukan dengan kombinasi metode biologis, mekanis, dan kimiawi.',
            'Penggunaan pestisida harus dilakukan secara bijak dan sesuai dosis. Petani disarankan untuk mengutamakan penggunaan pestisida nabati atau organik untuk menjaga kelestarian lingkungan.',
        ]);
    }

    /**
     * Indicate that the berita is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'tanggal_publikasi' => fake()->dateTimeBetween('-6 months', 'now'),
            'views' => fake()->numberBetween(100, 1000),
        ]);
    }

    /**
     * Indicate that the berita is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'tanggal_publikasi' => null,
            'views' => 0,
        ]);
    }

    /**
     * Berita with high views.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'views' => fake()->numberBetween(500, 2000),
        ]);
    }

    /**
     * Berita for specific category.
     */
    public function kategori(string $kategori): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => $kategori,
        ]);
    }
}
