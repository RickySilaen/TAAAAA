<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CacheWarmup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warmup 
                            {--clear : Clear all caches before warming up}
                            {--config : Warm up config cache}
                            {--routes : Warm up route cache}
                            {--views : Warm up view cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches for optimal performance';

    protected CacheService $cacheService;

    /**
     * Create a new command instance.
     */
    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔥 Warming up application caches...');
        $this->newLine();

        // Clear caches if requested
        if ($this->option('clear')) {
            $this->clearCaches();
        }

        // Warm up Laravel caches
        $this->warmupLaravelCaches();

        // Warm up application data caches
        $this->warmupDataCaches();

        $this->newLine();
        $this->info('✅ Cache warmup completed successfully!');

        return 0;
    }

    /**
     * Clear all caches.
     */
    protected function clearCaches(): void
    {
        $this->info('🗑️  Clearing existing caches...');

        Artisan::call('cache:clear');
        $this->line('   ✓ Application cache cleared');

        Artisan::call('config:clear');
        $this->line('   ✓ Config cache cleared');

        Artisan::call('route:clear');
        $this->line('   ✓ Route cache cleared');

        Artisan::call('view:clear');
        $this->line('   ✓ View cache cleared');

        $this->newLine();
    }

    /**
     * Warm up Laravel framework caches.
     */
    protected function warmupLaravelCaches(): void
    {
        $this->info('⚡ Warming up framework caches...');

        if ($this->option('config') || ! $this->hasAnyOptions()) {
            Artisan::call('config:cache');
            $this->line('   ✓ Config cache warmed up');
        }

        if ($this->option('routes') || ! $this->hasAnyOptions()) {
            Artisan::call('route:cache');
            $this->line('   ✓ Route cache warmed up');
        }

        if ($this->option('views') || ! $this->hasAnyOptions()) {
            Artisan::call('view:cache');
            $this->line('   ✓ View cache warmed up');
        }

        $this->newLine();
    }

    /**
     * Warm up application data caches.
     */
    protected function warmupDataCaches(): void
    {
        $this->info('📊 Warming up data caches...');

        $bar = $this->output->createProgressBar(4);
        $bar->start();

        // Warm up published berita
        try {
            $this->cacheService->getPublishedBerita(10);
            $bar->advance();

            $this->cacheService->getPublishedBerita(20);
            $bar->advance();
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not cache berita: ' . $e->getMessage());
        }

        // Warm up galeri
        try {
            $this->cacheService->getGaleri();
            $bar->advance();
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not cache galeri: ' . $e->getMessage());
        }

        // Warm up dashboard stats
        try {
            $this->cacheService->getDashboardStats();
            $bar->advance();
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not cache dashboard stats: ' . $e->getMessage());
        }

        $bar->finish();
        $this->newLine(2);

        $this->line('   ✓ Berita cache warmed up');
        $this->line('   ✓ Galeri cache warmed up');
        $this->line('   ✓ Dashboard statistics cache warmed up');
    }

    /**
     * Check if any cache options are specified.
     */
    protected function hasAnyOptions(): bool
    {
        return $this->option('config') ||
               $this->option('routes') ||
               $this->option('views');
    }
}
