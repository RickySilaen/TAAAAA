<?php

namespace Database\Seeders;

use App\Models\Bantuan;
use App\Models\Berita;
use App\Models\Feedback;
use App\Models\Galeri;
use App\Models\Laporan;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestingSeeder extends Seeder
{
    /**
     * Seed the application's database with comprehensive testing data.
     *
     * This seeder creates realistic data for development and testing purposes:
     * - 50 farmers (petani)
     * - 5 officers (petugas)
     * - 2 admins
     * - 150 harvest reports (laporans)
     * - 100 aid requests (bantuans)
     * - 50 news articles (beritas)
     * - 80 feedbacks
     * - 60 gallery items (galeris)
     * - 200 newsletter subscriptions
     *
     * Total: 697+ records
     */
    public function run(): void
    {
        $this->command->info('🌾 Starting Testing Data Seeder...');
        $this->command->newLine();

        // Clear existing data (optional, comment out if you want to keep existing data)
        if ($this->command->confirm('Do you want to clear existing data first?', false)) {
            $this->clearExistingData();
        }

        // Create Users
        $this->command->info('👥 Creating users...');
        $users = $this->createUsers();
        $this->command->info('✅ Created ' . count($users) . ' users');
        $this->command->newLine();

        // Create Harvest Reports
        $this->command->info('📊 Creating harvest reports...');
        $laporans = $this->createLaporans($users['petani']);
        $this->command->info('✅ Created ' . $laporans . ' harvest reports');
        $this->command->newLine();

        // Create Aid Requests
        $this->command->info('🤝 Creating aid requests...');
        $bantuans = $this->createBantuans($users['petani']);
        $this->command->info('✅ Created ' . $bantuans . ' aid requests');
        $this->command->newLine();

        // Create News
        $this->command->info('📰 Creating news articles...');
        $beritas = $this->createBeritas();
        $this->command->info('✅ Created ' . $beritas . ' news articles');
        $this->command->newLine();

        // Create Feedbacks
        $this->command->info('💬 Creating feedbacks...');
        $feedbacks = $this->createFeedbacks();
        $this->command->info('✅ Created ' . $feedbacks . ' feedbacks');
        $this->command->newLine();

        // Create Gallery
        $this->command->info('📸 Creating gallery items...');
        $galeris = $this->createGaleris();
        $this->command->info('✅ Created ' . $galeris . ' gallery items');
        $this->command->newLine();

        // Create Newsletters
        $this->command->info('📧 Creating newsletter subscriptions...');
        $newsletters = $this->createNewsletters();
        $this->command->info('✅ Created ' . $newsletters . ' newsletter subscriptions');
        $this->command->newLine();

        $this->command->info('🎉 Testing data seeding completed successfully!');
        $this->command->newLine();
        $this->displaySummary();
    }

    /**
     * Clear existing data.
     */
    private function clearExistingData(): void
    {
        $this->command->warn('⚠️  Clearing existing data...');

        Newsletter::truncate();
        Galeri::truncate();
        Feedback::truncate();
        Berita::truncate();
        Bantuan::truncate();
        Laporan::truncate();
        User::whereNotIn('email', ['admin@pertanian.com', 'petugas@pertanian.com'])->delete();

        $this->command->info('✅ Existing data cleared');
        $this->command->newLine();
    }

    /**
     * Create users with different roles.
     */
    private function createUsers(): array
    {
        // Create Farmers (Petani) - 50 users
        $petani = User::factory()
            ->count(50)
            ->create([
                'role' => 'petani',
                'is_verified' => true,
            ]);

        // Create some unverified farmers
        User::factory()
            ->count(10)
            ->create([
                'role' => 'petani',
                'is_verified' => false,
            ]);

        // Create Officers (Petugas) - 5 users
        $petugas = User::factory()
            ->count(5)
            ->create([
                'role' => 'petugas',
                'is_verified' => true,
            ]);

        // Create Admins - 2 users
        $admin = User::factory()
            ->count(2)
            ->create([
                'role' => 'admin',
                'is_verified' => true,
            ]);

        // Create a known test admin
        User::factory()->create([
            'nama_lengkap' => 'Admin Testing',
            'email' => 'admin.test@pertanian.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
            'no_telepon' => '081234567890',
        ]);

        // Create a known test petugas
        User::factory()->create([
            'nama_lengkap' => 'Petugas Testing',
            'email' => 'petugas.test@pertanian.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'is_verified' => true,
            'no_telepon' => '081234567891',
        ]);

        // Create a known test petani
        User::factory()->create([
            'nama_lengkap' => 'Petani Testing',
            'email' => 'petani.test@pertanian.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'is_verified' => true,
            'no_telepon' => '081234567892',
            'alamat' => 'Desa Testing, Kecamatan Testing, Toba Samosir',
            'luas_lahan' => 2.5,
            'jenis_tanaman_utama' => 'Padi',
        ]);

        return [
            'petani' => $petani,
            'petugas' => $petugas,
            'admin' => $admin,
        ];
    }

    /**
     * Create harvest reports (laporans).
     */
    private function createLaporans($petani): int
    {
        // Status distribution: 40% pending, 30% verified, 20% completed, 10% rejected
        $laporanCount = 0;

        // Pending reports
        Laporan::factory()
            ->count(60)
            ->pending()
            ->recycle($petani)
            ->create();
        $laporanCount += 60;

        // Verified reports
        Laporan::factory()
            ->count(45)
            ->verified()
            ->recycle($petani)
            ->create();
        $laporanCount += 45;

        // Completed reports
        Laporan::factory()
            ->count(30)
            ->completed()
            ->recycle($petani)
            ->create();
        $laporanCount += 30;

        // Rejected reports
        Laporan::factory()
            ->count(15)
            ->rejected()
            ->recycle($petani)
            ->create();
        $laporanCount += 15;

        // High yield reports (showcase successful farming)
        Laporan::factory()
            ->count(10)
            ->highYield()
            ->verified()
            ->recycle($petani)
            ->create();
        $laporanCount += 10;

        // Low yield reports (realistic challenges)
        Laporan::factory()
            ->count(10)
            ->lowYield()
            ->recycle($petani)
            ->create();
        $laporanCount += 10;

        return $laporanCount;
    }

    /**
     * Create aid requests (bantuans).
     */
    private function createBantuans($petani): int
    {
        // Status distribution: 35% pending, 30% approved, 25% completed, 10% rejected
        $bantuanCount = 0;

        // Pending requests
        Bantuan::factory()
            ->count(35)
            ->pending()
            ->recycle($petani)
            ->create();
        $bantuanCount += 35;

        // Approved requests
        Bantuan::factory()
            ->count(30)
            ->approved()
            ->recycle($petani)
            ->create();
        $bantuanCount += 30;

        // Completed requests
        Bantuan::factory()
            ->count(25)
            ->completed()
            ->recycle($petani)
            ->create();
        $bantuanCount += 25;

        // Rejected requests
        Bantuan::factory()
            ->count(10)
            ->rejected()
            ->recycle($petani)
            ->create();
        $bantuanCount += 10;

        return $bantuanCount;
    }

    /**
     * Create news articles (beritas).
     */
    private function createBeritas(): int
    {
        $beritaCount = 0;

        // Published news - 40 articles
        Berita::factory()
            ->count(40)
            ->published()
            ->create();
        $beritaCount += 40;

        // Draft news - 10 articles
        Berita::factory()
            ->count(10)
            ->draft()
            ->create();
        $beritaCount += 10;

        // Popular news - 10 articles
        Berita::factory()
            ->count(10)
            ->popular()
            ->create();
        $beritaCount += 10;

        return $beritaCount;
    }

    /**
     * Create feedbacks.
     */
    private function createFeedbacks(): int
    {
        $feedbackCount = 0;

        // Pending feedbacks - 30
        Feedback::factory()
            ->count(30)
            ->pending()
            ->create();
        $feedbackCount += 30;

        // Responded feedbacks - 25
        Feedback::factory()
            ->count(25)
            ->responded()
            ->create();
        $feedbackCount += 25;

        // Completed feedbacks - 25
        Feedback::factory()
            ->count(25)
            ->completed()
            ->create();
        $feedbackCount += 25;

        return $feedbackCount;
    }

    /**
     * Create gallery items.
     */
    private function createGaleris(): int
    {
        $galeriCount = 0;

        // Different categories with realistic distribution
        $categories = [
            'Kegiatan Panen' => 15,
            'Pelatihan' => 10,
            'Penyerahan Bantuan' => 8,
            'Sawah' => 12,
            'Hasil Panen' => 10,
            'Kegiatan Kelompok Tani' => 5,
        ];

        foreach ($categories as $kategori => $count) {
            Galeri::factory()
                ->count($count)
                ->kategori($kategori)
                ->create();
            $galeriCount += $count;
        }

        return $galeriCount;
    }

    /**
     * Create newsletter subscriptions.
     */
    private function createNewsletters(): int
    {
        $newsletterCount = 0;

        // Active subscriptions - 150
        Newsletter::factory()
            ->count(150)
            ->active()
            ->create();
        $newsletterCount += 150;

        // Unsubscribed - 50
        Newsletter::factory()
            ->count(50)
            ->unsubscribed()
            ->create();
        $newsletterCount += 50;

        return $newsletterCount;
    }

    /**
     * Display seeding summary.
     */
    private function displaySummary(): void
    {
        $this->command->info('📊 Summary:');
        $this->command->table(
            ['Model', 'Count'],
            [
                ['Users (Petani)', User::where('role', 'petani')->count()],
                ['Users (Petugas)', User::where('role', 'petugas')->count()],
                ['Users (Admin)', User::where('role', 'admin')->count()],
                ['Harvest Reports', Laporan::count()],
                ['Aid Requests', Bantuan::count()],
                ['News Articles', Berita::count()],
                ['Feedbacks', Feedback::count()],
                ['Gallery Items', Galeri::count()],
                ['Newsletter Subscriptions', Newsletter::count()],
                ['---', '---'],
                ['TOTAL RECORDS', User::count() + Laporan::count() + Bantuan::count() + Berita::count() + Feedback::count() + Galeri::count() + Newsletter::count()],
            ]
        );

        $this->command->newLine();
        $this->command->info('🔑 Test Credentials:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin.test@pertanian.com', 'password'],
                ['Petugas', 'petugas.test@pertanian.com', 'password'],
                ['Petani', 'petani.test@pertanian.com', 'password'],
            ]
        );
    }
}
