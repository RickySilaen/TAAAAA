<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupRotation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:rotate 
                            {--keep-daily=7 : Number of daily backups to keep}
                            {--keep-weekly=4 : Number of weekly backups to keep}
                            {--keep-monthly=3 : Number of monthly backups to keep}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rotate and cleanup old backup files based on retention policy';

    protected int $deletedCount = 0;

    protected int $freedSpace = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗂️  Backup Rotation & Cleanup');
        $this->newLine();

        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No files will be deleted');
            $this->newLine();
        }

        // Get rotation policy from options
        $keepDaily = (int) $this->option('keep-daily');
        $keepWeekly = (int) $this->option('keep-weekly');
        $keepMonthly = (int) $this->option('keep-monthly');

        $this->info('📋 Retention Policy:');
        $this->line("   • Daily backups: {$keepDaily} days");
        $this->line("   • Weekly backups: {$keepWeekly} weeks");
        $this->line("   • Monthly backups: {$keepMonthly} months");
        $this->newLine();

        // Rotate database backups
        $this->rotateBackups(
            storage_path('app/backups'),
            $keepDaily,
            $keepWeekly,
            $keepMonthly,
            $dryRun
        );

        // Rotate Spatie backups if exists
        if (File::exists(storage_path('app/Sistema-Pertanian-Toba'))) {
            $this->rotateBackups(
                storage_path('app/Sistema-Pertanian-Toba'),
                $keepDaily,
                $keepWeekly,
                $keepMonthly,
                $dryRun
            );
        }

        // Summary
        $this->newLine();
        $this->info('📊 Summary:');
        $this->line("   • Files deleted: {$this->deletedCount}");
        $this->line('   • Space freed: ' . $this->formatBytes($this->freedSpace));

        if ($dryRun) {
            $this->newLine();
            $this->warn('⚠️  This was a dry run. Run without --dry-run to actually delete files.');
        } else {
            $this->newLine();
            $this->info('✅ Backup rotation completed successfully!');
        }

        return 0;
    }

    /**
     * Rotate backups in a directory.
     */
    protected function rotateBackups(string $path, int $keepDaily, int $keepWeekly, int $keepMonthly, bool $dryRun): void
    {
        if (! File::exists($path)) {
            return;
        }

        $this->info("📁 Processing: {$path}");

        $files = File::files($path);

        if (empty($files)) {
            $this->line('   No backup files found');

            return;
        }

        // Group files by date
        $filesByDate = [];

        foreach ($files as $file) {
            $timestamp = File::lastModified($file->getPathname());
            $date = Carbon::createFromTimestamp($timestamp);

            $filesByDate[] = [
                'path' => $file->getPathname(),
                'name' => $file->getFilename(),
                'date' => $date,
                'size' => File::size($file->getPathname()),
                'age_days' => $date->diffInDays(now()),
            ];
        }

        // Sort by date descending (newest first)
        usort($filesByDate, fn ($a, $b) => $b['date']->timestamp <=> $a['date']->timestamp);

        // Determine which files to keep
        $toKeep = [];
        $toDelete = [];

        foreach ($filesByDate as $file) {
            $ageDays = $file['age_days'];

            // Keep daily backups
            if ($ageDays <= $keepDaily) {
                $toKeep[] = $file;
                continue;
            }

            // Keep weekly backups (one per week)
            if ($ageDays <= ($keepWeekly * 7)) {
                $weekNumber = $file['date']->weekOfYear;
                $key = "weekly_{$file['date']->year}_{$weekNumber}";

                if (! isset($toKeep[$key])) {
                    $toKeep[$key] = $file;
                    continue;
                }
            }

            // Keep monthly backups (one per month)
            if ($ageDays <= ($keepMonthly * 30)) {
                $monthKey = $file['date']->format('Y-m');
                $key = "monthly_{$monthKey}";

                if (! isset($toKeep[$key])) {
                    $toKeep[$key] = $file;
                    continue;
                }
            }

            // Mark for deletion
            $toDelete[] = $file;
        }

        // Display and delete files
        if (! empty($toDelete)) {
            $mode = $this->option('dry-run') ? 'DRY RUN' : 'ACTUAL';
            $this->line("   📝 Files to delete ({$mode}):");

            foreach ($toDelete as $file) {
                $this->line("      • {$file['name']} ({$this->formatBytes($file['size'])}, {$file['age_days']} days old)");

                if (! $dryRun) {
                    File::delete($file['path']);
                }

                $this->deletedCount++;
                $this->freedSpace += $file['size'];
            }
        } else {
            $this->line('   ✅ No files need to be deleted');
        }

        $this->newLine();
    }

    /**
     * Format bytes to human readable.
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
