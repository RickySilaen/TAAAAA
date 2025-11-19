<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {--sql : Export as SQL file}
                            {--compress : Compress backup}
                            {--tables=* : Specific tables to backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database (works without mysqldump)';

    protected $backupPath;

    protected $timestamp;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting database backup...');
        $this->newLine();

        $this->timestamp = now()->format('Y-m-d_His');
        $this->backupPath = storage_path('app/backups');

        // Create backup directory
        if (! File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }

        try {
            if ($this->option('sql')) {
                $this->backupAsSQL();
            } else {
                $this->backupAsJSON();
            }

            $this->newLine();
            $this->info('✅ Database backup completed successfully!');

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Backup failed: ' . $e->getMessage());

            return 1;
        }
    }

    /**
     * Backup database as JSON format.
     */
    protected function backupAsJSON()
    {
        $dbName = config('database.connections.mysql.database');
        $tables = $this->option('tables') ?: $this->getAllTables();

        $this->info("📦 Backing up database: {$dbName}");
        $this->newLine();

        $backup = [
            'database' => $dbName,
            'timestamp' => $this->timestamp,
            'tables' => [],
        ];

        $progressBar = $this->output->createProgressBar(count($tables));
        $progressBar->start();

        foreach ($tables as $table) {
            $data = DB::table($table)->get()->toArray();
            $backup['tables'][$table] = [
                'count' => count($data),
                'data' => $data,
            ];
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $filename = "backup_{$dbName}_{$this->timestamp}.json";
        $filepath = "{$this->backupPath}/{$filename}";

        File::put($filepath, json_encode($backup, JSON_PRETTY_PRINT));

        // Compress if requested
        if ($this->option('compress')) {
            $filepath = $this->compressBackup($filepath);
        }

        $this->displayBackupInfo($filepath);
    }

    /**
     * Backup database as SQL format.
     */
    protected function backupAsSQL()
    {
        $dbName = config('database.connections.mysql.database');
        $tables = $this->option('tables') ?: $this->getAllTables();

        $this->info("📦 Backing up database: {$dbName} (SQL format)");
        $this->newLine();

        $sql = "-- Database Backup\n";
        $sql .= "-- Database: {$dbName}\n";
        $sql .= "-- Timestamp: {$this->timestamp}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $progressBar = $this->output->createProgressBar(count($tables));
        $progressBar->start();

        foreach ($tables as $table) {
            // Drop table
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

            // Create table
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0];
            $sql .= $createTable->{'Create Table'} . ";\n\n";

            // Insert data
            $data = DB::table($table)->get();

            if ($data->count() > 0) {
                foreach ($data as $row) {
                    $values = [];
                    foreach ((array) $row as $value) {
                        if (is_null($value)) {
                            $values[] = 'NULL';
                        } else {
                            $escaped = str_replace("'", "''", $value);
                            $values[] = "'" . $escaped . "'";
                        }
                    }
                    $sql .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }

            $progressBar->advance();
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $progressBar->finish();
        $this->newLine(2);

        $filename = "backup_{$dbName}_{$this->timestamp}.sql";
        $filepath = "{$this->backupPath}/{$filename}";

        File::put($filepath, $sql);

        // Compress if requested
        if ($this->option('compress')) {
            $filepath = $this->compressBackup($filepath);
        }

        $this->displayBackupInfo($filepath);
    }

    /**
     * Get all database tables.
     */
    protected function getAllTables(): array
    {
        $tables = [];
        $results = DB::select('SHOW TABLES');

        foreach ($results as $result) {
            $tableKey = 'Tables_in_' . config('database.connections.mysql.database');
            $tables[] = $result->$tableKey;
        }

        return $tables;
    }

    /**
     * Compress backup file.
     */
    protected function compressBackup($filepath)
    {
        $this->info('🗜️  Compressing backup...');

        $zip = new ZipArchive();
        $zipFilename = $filepath . '.zip';

        if ($zip->open($zipFilename, ZipArchive::CREATE) === true) {
            $zip->addFile($filepath, basename($filepath));
            $zip->close();

            // Delete original file
            File::delete($filepath);

            $this->info('✅ Backup compressed');

            return $zipFilename;
        }

        return $filepath;
    }

    /**
     * Display backup information.
     */
    protected function displayBackupInfo($filepath)
    {
        $filesize = File::size($filepath);
        $filesizeHuman = $this->formatBytes($filesize);

        $this->table(
            ['Property', 'Value'],
            [
                ['File', basename($filepath)],
                ['Size', $filesizeHuman],
                ['Location', $filepath],
                ['Timestamp', $this->timestamp],
            ]
        );
    }

    /**
     * Format bytes to human readable.
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
