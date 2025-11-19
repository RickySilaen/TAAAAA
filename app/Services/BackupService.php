<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupService
{
    protected string $backupPath;

    protected string $tempPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        $this->tempPath = storage_path('app/temp');

        // Ensure directories exist
        if (! File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }

        if (! File::exists($this->tempPath)) {
            File::makeDirectory($this->tempPath, 0755, true);
        }
    }

    /**
     * Create full system backup.
     */
    public function createFullBackup(array $options = []): array
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $results = [
            'database' => null,
            'files' => null,
            'config' => null,
            'full_backup' => null,
        ];

        // 1. Database backup
        if ($options['database'] ?? true) {
            $results['database'] = $this->backupDatabase($timestamp);
        }

        // 2. Files backup
        if ($options['files'] ?? true) {
            $results['files'] = $this->backupFiles($timestamp);
        }

        // 3. Config backup
        if ($options['config'] ?? true) {
            $results['config'] = $this->backupConfiguration($timestamp);
        }

        // 4. Create combined ZIP
        if ($options['compress'] ?? true) {
            $results['full_backup'] = $this->createCombinedBackup($timestamp, $results);
        }

        return $results;
    }

    /**
     * Backup database.
     */
    public function backupDatabase(string $timestamp): string
    {
        $filename = "database_{$timestamp}.json";
        $filepath = "{$this->backupPath}/{$filename}";

        $tables = DB::select('SHOW TABLES');
        $database = DB::getDatabaseName();
        $tableKey = "Tables_in_{$database}";

        $backup = [];

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Get table structure
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $structure = $createTable[0]->{'Create Table'};

            // Get table data
            $data = DB::table($tableName)->get()->toArray();

            $backup[$tableName] = [
                'structure' => $structure,
                'data' => $data,
                'row_count' => count($data),
            ];
        }

        File::put($filepath, json_encode($backup, JSON_PRETTY_PRINT));

        return $filepath;
    }

    /**
     * Backup important files.
     */
    public function backupFiles(string $timestamp): string
    {
        $filename = "files_{$timestamp}.zip";
        $filepath = "{$this->backupPath}/{$filename}";

        $zip = new ZipArchive();

        if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("Cannot create ZIP file: {$filepath}");
        }

        // Directories to backup
        $directories = [
            'public/uploads' => 'uploads',
            'storage/app/public' => 'storage_public',
        ];

        foreach ($directories as $source => $destination) {
            $sourcePath = base_path($source);

            if (File::exists($sourcePath)) {
                $this->addDirectoryToZip($zip, $sourcePath, $destination);
            }
        }

        $zip->close();

        return $filepath;
    }

    /**
     * Backup configuration files.
     */
    public function backupConfiguration(string $timestamp): string
    {
        $filename = "config_{$timestamp}.zip";
        $filepath = "{$this->backupPath}/{$filename}";

        $zip = new ZipArchive();

        if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("Cannot create ZIP file: {$filepath}");
        }

        // Files to backup
        $files = [
            '.env' => '.env',
            '.env.example' => '.env.example',
            'config/app.php' => 'config/app.php',
            'config/database.php' => 'config/database.php',
            'config/mail.php' => 'config/mail.php',
            'config/backup.php' => 'config/backup.php',
        ];

        foreach ($files as $source => $destination) {
            $sourcePath = base_path($source);

            if (File::exists($sourcePath)) {
                $zip->addFile($sourcePath, $destination);
            }
        }

        $zip->close();

        return $filepath;
    }

    /**
     * Create combined backup ZIP.
     */
    protected function createCombinedBackup(string $timestamp, array $backups): string
    {
        $filename = "full_backup_{$timestamp}.zip";
        $filepath = "{$this->backupPath}/{$filename}";

        $zip = new ZipArchive();

        if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("Cannot create ZIP file: {$filepath}");
        }

        // Add individual backups to combined ZIP
        foreach ($backups as $type => $path) {
            if ($path && File::exists($path)) {
                $zip->addFile($path, basename($path));
            }
        }

        // Add metadata
        $metadata = [
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => auth()->user()->name ?? 'System',
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'database' => DB::getDatabaseName(),
            'backups_included' => array_keys(array_filter($backups)),
        ];

        $zip->addFromString('backup_info.json', json_encode($metadata, JSON_PRETTY_PRINT));
        $zip->close();

        // Clean up individual backup files
        foreach ($backups as $path) {
            if ($path && File::exists($path) && $path !== $filepath) {
                File::delete($path);
            }
        }

        return $filepath;
    }

    /**
     * Add directory to ZIP recursively.
     */
    protected function addDirectoryToZip(ZipArchive $zip, string $path, string $zipPath): void
    {
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $relativePath = str_replace($path . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $zip->addFile($file->getPathname(), $zipPath . '/' . $relativePath);
        }
    }

    /**
     * Restore from backup.
     */
    public function restore(string $backupFile, array $options = []): bool
    {
        if (! File::exists($backupFile)) {
            throw new \Exception("Backup file not found: {$backupFile}");
        }

        // Extract backup
        $extractPath = "{$this->tempPath}/restore_" . time();
        File::makeDirectory($extractPath, 0755, true);

        $zip = new ZipArchive();
        if ($zip->open($backupFile) !== true) {
            throw new \Exception("Cannot open backup file: {$backupFile}");
        }

        $zip->extractTo($extractPath);
        $zip->close();

        // Restore components
        $success = true;

        if ($options['database'] ?? true) {
            $success = $success && $this->restoreDatabase($extractPath);
        }

        if ($options['files'] ?? true) {
            $success = $success && $this->restoreFiles($extractPath);
        }

        if ($options['config'] ?? false) {
            $success = $success && $this->restoreConfiguration($extractPath);
        }

        // Cleanup
        File::deleteDirectory($extractPath);

        return $success;
    }

    /**
     * Restore database from backup.
     */
    protected function restoreDatabase(string $extractPath): bool
    {
        $dbFile = File::glob("{$extractPath}/database_*.json")[0] ?? null;

        if (! $dbFile) {
            return false;
        }

        $backup = json_decode(File::get($dbFile), true);

        DB::beginTransaction();

        try {
            foreach ($backup as $tableName => $tableData) {
                // Truncate table
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table($tableName)->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                // Insert data
                if (! empty($tableData['data'])) {
                    DB::table($tableName)->insert($tableData['data']);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Restore files from backup.
     */
    protected function restoreFiles(string $extractPath): bool
    {
        $filesZip = File::glob("{$extractPath}/files_*.zip")[0] ?? null;

        if (! $filesZip) {
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($filesZip) !== true) {
            return false;
        }

        $zip->extractTo(base_path());
        $zip->close();

        return true;
    }

    /**
     * Restore configuration from backup.
     */
    protected function restoreConfiguration(string $extractPath): bool
    {
        $configZip = File::glob("{$extractPath}/config_*.zip")[0] ?? null;

        if (! $configZip) {
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($configZip) !== true) {
            return false;
        }

        $zip->extractTo(base_path());
        $zip->close();

        return true;
    }

    /**
     * Get backup statistics.
     */
    public function getBackupStats(): array
    {
        $files = File::files($this->backupPath);

        $stats = [
            'total_backups' => count($files),
            'total_size' => 0,
            'oldest_backup' => null,
            'newest_backup' => null,
            'backups_by_type' => [
                'database' => 0,
                'files' => 0,
                'config' => 0,
                'full' => 0,
            ],
        ];

        foreach ($files as $file) {
            $stats['total_size'] += File::size($file->getPathname());

            $timestamp = File::lastModified($file->getPathname());

            if (! $stats['oldest_backup'] || $timestamp < $stats['oldest_backup']) {
                $stats['oldest_backup'] = $timestamp;
            }

            if (! $stats['newest_backup'] || $timestamp > $stats['newest_backup']) {
                $stats['newest_backup'] = $timestamp;
            }

            // Count by type
            $filename = $file->getFilename();
            if (str_contains($filename, 'database_')) {
                $stats['backups_by_type']['database']++;
            } elseif (str_contains($filename, 'files_')) {
                $stats['backups_by_type']['files']++;
            } elseif (str_contains($filename, 'config_')) {
                $stats['backups_by_type']['config']++;
            } elseif (str_contains($filename, 'full_backup_')) {
                $stats['backups_by_type']['full']++;
            }
        }

        if ($stats['oldest_backup']) {
            $stats['oldest_backup'] = Carbon::createFromTimestamp($stats['oldest_backup'])->toDateTimeString();
        }

        if ($stats['newest_backup']) {
            $stats['newest_backup'] = Carbon::createFromTimestamp($stats['newest_backup'])->toDateTimeString();
        }

        $stats['total_size_formatted'] = $this->formatBytes($stats['total_size']);

        return $stats;
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
