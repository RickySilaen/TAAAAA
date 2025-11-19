<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Seed the application's database with minimal production data.
     *
     * This seeder creates ONLY essential data for production deployment:
     * - 1 Super Admin
     * - 1 Admin
     * - 2 Officers (Petugas)
     *
     * ⚠️ IMPORTANT: Change all default passwords after first login!
     */
    public function run(): void
    {
        $this->command->warn('⚠️  PRODUCTION SEEDER');
        $this->command->warn('This will create minimal essential data for production.');
        $this->command->newLine();

        if (! app()->environment('production')) {
            if (! $this->command->confirm('You are not in production environment. Continue?', false)) {
                $this->command->info('Seeding cancelled.');

                return;
            }
        }

        $this->command->info('🌾 Starting Production Data Seeder...');
        $this->command->newLine();

        // Check if admin already exists
        if (User::where('email', 'admin@pertanian-toba.com')->exists()) {
            $this->command->error('❌ Admin user already exists. Skipping seeder.');
            $this->command->info('If you need to reset, please manually delete users and run again.');

            return;
        }

        // Create Super Admin
        $this->command->info('👑 Creating Super Admin...');
        $superAdmin = User::create([
            'nama_lengkap' => 'Super Administrator',
            'email' => 'admin@pertanian-toba.com',
            'password' => Hash::make('Admin2025!Change'), // ⚠️ MUST CHANGE AFTER FIRST LOGIN
            'role' => 'admin',
            'is_verified' => true,
            'no_telepon' => '081234567890',
            'alamat' => 'Kantor Dinas Pertanian Toba Samosir',
        ]);
        $this->command->info('✅ Super Admin created: ' . $superAdmin->email);

        // Create Admin
        $this->command->info('👨‍💼 Creating Admin...');
        $admin = User::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin2@pertanian-toba.com',
            'password' => Hash::make('Admin2025!Change'), // ⚠️ MUST CHANGE AFTER FIRST LOGIN
            'role' => 'admin',
            'is_verified' => true,
            'no_telepon' => '081234567891',
            'alamat' => 'Kantor Dinas Pertanian Toba Samosir',
        ]);
        $this->command->info('✅ Admin created: ' . $admin->email);

        // Create Petugas 1
        $this->command->info('👷 Creating Officers...');
        $petugas1 = User::create([
            'nama_lengkap' => 'Petugas Lapangan 1',
            'email' => 'petugas1@pertanian-toba.com',
            'password' => Hash::make('Petugas2025!Change'), // ⚠️ MUST CHANGE AFTER FIRST LOGIN
            'role' => 'petugas',
            'is_verified' => true,
            'no_telepon' => '081234567892',
            'alamat' => 'Kecamatan Balige',
        ]);
        $this->command->info('✅ Petugas 1 created: ' . $petugas1->email);

        // Create Petugas 2
        $petugas2 = User::create([
            'nama_lengkap' => 'Petugas Lapangan 2',
            'email' => 'petugas2@pertanian-toba.com',
            'password' => Hash::make('Petugas2025!Change'), // ⚠️ MUST CHANGE AFTER FIRST LOGIN
            'role' => 'petugas',
            'is_verified' => true,
            'no_telepon' => '081234567893',
            'alamat' => 'Kecamatan Laguboti',
        ]);
        $this->command->info('✅ Petugas 2 created: ' . $petugas2->email);

        $this->command->newLine();
        $this->command->info('🎉 Production data seeding completed successfully!');
        $this->command->newLine();

        // Display credentials
        $this->displayCredentials();

        // Security warnings
        $this->displaySecurityWarnings();
    }

    /**
     * Display default credentials.
     */
    private function displayCredentials(): void
    {
        $this->command->warn('🔑 DEFAULT CREDENTIALS (⚠️ CHANGE IMMEDIATELY!):');
        $this->command->newLine();

        $this->command->table(
            ['Role', 'Email', 'Default Password'],
            [
                ['Super Admin', 'admin@pertanian-toba.com', 'Admin2025!Change'],
                ['Admin', 'admin2@pertanian-toba.com', 'Admin2025!Change'],
                ['Petugas 1', 'petugas1@pertanian-toba.com', 'Petugas2025!Change'],
                ['Petugas 2', 'petugas2@pertanian-toba.com', 'Petugas2025!Change'],
            ]
        );

        $this->command->newLine();
    }

    /**
     * Display security warnings.
     */
    private function displaySecurityWarnings(): void
    {
        $this->command->error('⚠️  SECURITY WARNINGS:');
        $this->command->newLine();

        $warnings = [
            '1. CHANGE ALL DEFAULT PASSWORDS IMMEDIATELY after first login!',
            '2. Update email addresses to real admin emails.',
            '3. Update phone numbers to real contact numbers.',
            '4. Update addresses with actual office locations.',
            '5. Enable Two-Factor Authentication (2FA) for all admin accounts.',
            '6. Regularly review and update user access permissions.',
            '7. Set up proper backup procedures before going live.',
            '8. Configure email settings for password reset functionality.',
            '9. Set up monitoring and logging for security events.',
            '10. Review and configure all environment variables properly.',
        ];

        foreach ($warnings as $warning) {
            $this->command->warn('   ' . $warning);
        }

        $this->command->newLine();
        $this->command->info('📚 For more information, check:');
        $this->command->info('   - docs/SECURITY_HARDENING.md');
        $this->command->info('   - docs/DEPLOYMENT_GUIDE.md');
        $this->command->newLine();
    }
}
