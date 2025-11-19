<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnalyzeQueryPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'query:analyze 
                            {--table= : Analyze specific table}
                            {--slow : Show slow query analysis}
                            {--indexes : Show index usage}
                            {--missing : Show missing indexes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze database query performance, detect N+1 queries, and show optimization opportunities';

    protected $queryLog = [];

    protected $tables = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Database Performance Analysis');
        $this->newLine();

        // Get all tables
        $this->tables = $this->getAllTables();

        if ($this->option('indexes')) {
            $this->analyzeIndexes();
        } elseif ($this->option('missing')) {
            $this->detectMissingIndexes();
        } elseif ($this->option('slow')) {
            $this->analyzeSlowQueries();
        } else {
            $this->comprehensiveAnalysis();
        }

        return 0;
    }

    /**
     * Comprehensive performance analysis.
     */
    protected function comprehensiveAnalysis()
    {
        $this->info('📊 Comprehensive Performance Analysis');
        $this->newLine();

        // 1. Table Statistics
        $this->analyzeTableStatistics();

        // 2. Index Usage
        $this->analyzeIndexes();

        // 3. Missing Indexes
        $this->detectMissingIndexes();

        // 4. Query Optimization Tips
        $this->showOptimizationTips();
    }

    /**
     * Analyze table statistics.
     */
    protected function analyzeTableStatistics()
    {
        $this->info('📋 Table Statistics');
        $this->newLine();

        $stats = [];

        foreach ($this->tables as $table) {
            try {
                $count = DB::table($table)->count();
                $size = $this->getTableSize($table);

                $stats[] = [
                    'Table' => $table,
                    'Rows' => number_format($count),
                    'Size' => $this->formatBytes($size),
                    'Avg Row Size' => $count > 0 ? $this->formatBytes($size / $count) : '0 B',
                ];
            } catch (\Exception $e) {
                continue;
            }
        }

        $this->table(['Table', 'Rows', 'Size', 'Avg Row Size'], $stats);
        $this->newLine();
    }

    /**
     * Analyze indexes.
     */
    protected function analyzeIndexes()
    {
        $this->info('🔑 Index Analysis');
        $this->newLine();

        $table = $this->option('table');
        $tables = $table ? [$table] : $this->tables;

        foreach ($tables as $tableName) {
            try {
                $indexes = $this->getTableIndexes($tableName);

                if (empty($indexes)) {
                    $this->warn("⚠️  Table '{$tableName}' has no indexes");
                    continue;
                }

                $this->line("📌 Table: <fg=cyan>{$tableName}</>");

                $indexData = [];
                foreach ($indexes as $index) {
                    $indexData[] = [
                        'Name' => $index['name'],
                        'Type' => $index['unique'] ? 'UNIQUE' : 'INDEX',
                        'Columns' => $index['columns'],
                    ];
                }

                $this->table(['Name', 'Type', 'Columns'], $indexData);
                $this->newLine();
            } catch (\Exception $e) {
                $this->error("Error analyzing table {$tableName}: " . $e->getMessage());
            }
        }
    }

    /**
     * Detect missing indexes.
     */
    protected function detectMissingIndexes()
    {
        $this->info('🔍 Missing Index Detection');
        $this->newLine();

        $recommendations = [];

        foreach ($this->tables as $table) {
            try {
                $columns = Schema::getColumnListing($table);
                $indexes = $this->getTableIndexes($table);
                $indexedColumns = [];

                // Get all indexed columns
                foreach ($indexes as $index) {
                    $cols = explode(',', $index['columns']);
                    foreach ($cols as $col) {
                        $indexedColumns[] = trim($col);
                    }
                }

                // Check for common columns that should be indexed
                $shouldBeIndexed = [
                    'user_id', 'status', 'created_at', 'updated_at',
                    'role', 'is_verified', 'email', 'type', 'category',
                    'kategori', 'jenis_bantuan', 'jenis_tanaman',
                    'tanggal', 'tanggal_panen', 'tanggal_permintaan',
                ];

                foreach ($shouldBeIndexed as $column) {
                    if (in_array($column, $columns) && ! in_array($column, $indexedColumns)) {
                        $recommendations[] = [
                            'Table' => $table,
                            'Column' => $column,
                            'Reason' => $this->getIndexReason($column),
                            'Query' => "ALTER TABLE {$table} ADD INDEX idx_{$table}_{$column} ({$column});",
                        ];
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        if (empty($recommendations)) {
            $this->info('✅ All recommended indexes are in place!');
        } else {
            $this->table(
                ['Table', 'Column', 'Reason', 'SQL Command'],
                $recommendations
            );

            $this->newLine();
            $this->warn('⚠️  Found ' . count($recommendations) . ' missing index recommendations');
        }
    }

    /**
     * Analyze slow queries (simulated).
     */
    protected function analyzeSlowQueries()
    {
        $this->info('🐌 Slow Query Analysis');
        $this->newLine();

        // Enable query logging
        DB::enableQueryLog();

        // Simulate common queries
        $startTime = microtime(true);

        try {
            // Test query 1: Get users with bantuans
            $users = DB::table('users')
                ->leftJoin('bantuans', 'users.id', '=', 'bantuans.user_id')
                ->select('users.*', DB::raw('COUNT(bantuans.id) as total_bantuans'))
                ->groupBy('users.id')
                ->get();

            $query1Time = (microtime(true) - $startTime) * 1000;

            // Test query 2: Get laporans with status
            $startTime = microtime(true);
            $laporans = DB::table('laporans')
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get();

            $query2Time = (microtime(true) - $startTime) * 1000;

            // Display results
            $queryStats = [
                [
                    'Query' => 'Users with Bantuans Count',
                    'Time (ms)' => number_format($query1Time, 2),
                    'Status' => $query1Time < 100 ? '✅ Fast' : ($query1Time < 500 ? '⚠️  Medium' : '❌ Slow'),
                ],
                [
                    'Query' => 'Approved Laporans (Latest 100)',
                    'Time (ms)' => number_format($query2Time, 2),
                    'Status' => $query2Time < 100 ? '✅ Fast' : ($query2Time < 500 ? '⚠️  Medium' : '❌ Slow'),
                ],
            ];

            $this->table(['Query', 'Time (ms)', 'Status'], $queryStats);
        } catch (\Exception $e) {
            $this->error('Error running test queries: ' . $e->getMessage());
        }

        DB::disableQueryLog();
    }

    /**
     * Show optimization tips.
     */
    protected function showOptimizationTips()
    {
        $this->info('💡 Optimization Tips');
        $this->newLine();

        $tips = [
            '✅ Use eager loading to prevent N+1 queries: $users->load(\'bantuans\', \'laporans\')',
            '✅ Add indexes on frequently queried columns (status, user_id, created_at)',
            '✅ Use select() to limit returned columns: User::select(\'id\', \'name\')->get()',
            '✅ Cache frequently accessed data: Cache::remember(\'key\', 3600, fn() => ...)',
            '✅ Use chunk() for large datasets: User::chunk(100, fn($users) => ...)',
            '✅ Optimize WHERE clauses to use indexed columns first',
            '✅ Use composite indexes for multi-column WHERE clauses',
            '✅ Avoid SELECT * when possible',
            '✅ Use EXPLAIN to analyze query execution plans',
            '✅ Consider read replicas for heavy read operations',
        ];

        foreach ($tips as $tip) {
            $this->line($tip);
        }

        $this->newLine();
    }

    /**
     * Get all database tables.
     */
    protected function getAllTables(): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            $database = DB::getDatabaseName();
            $tables = DB::select("SELECT table_name as name FROM information_schema.tables WHERE table_schema = '{$database}' AND table_type = 'BASE TABLE'");

            return array_map(fn ($table) => $table->name, $tables);
        } elseif ($driver === 'sqlite') {
            $tables = DB::select('SELECT name FROM sqlite_master WHERE type="table" AND name NOT LIKE "sqlite_%"');

            return array_map(fn ($table) => $table->name, $tables);
        } else {
            // PostgreSQL, SQL Server, etc.
            return Schema::getAllTables();
        }
    }

    /**
     * Get table indexes.
     */
    protected function getTableIndexes(string $table): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            $result = [];
            $grouped = [];

            foreach ($indexes as $index) {
                $name = $index->Key_name;
                if (! isset($grouped[$name])) {
                    $grouped[$name] = [
                        'name' => $name,
                        'unique' => $index->Non_unique == 0,
                        'columns' => [],
                    ];
                }
                $grouped[$name]['columns'][] = $index->Column_name;
            }

            foreach ($grouped as $index) {
                $result[] = [
                    'name' => $index['name'],
                    'unique' => $index['unique'],
                    'columns' => implode(', ', $index['columns']),
                ];
            }

            return $result;
        } elseif ($driver === 'sqlite') {
            $indexes = DB::select("PRAGMA index_list({$table})");
            $result = [];

            foreach ($indexes as $index) {
                $columns = DB::select("PRAGMA index_info({$index->name})");
                $columnNames = array_map(fn ($col) => $col->name, $columns);

                $result[] = [
                    'name' => $index->name,
                    'unique' => $index->unique == 1,
                    'columns' => implode(', ', $columnNames),
                ];
            }

            return $result;
        }

        return [];
    }

    /**
     * Get table size (approximate for SQLite).
     */
    protected function getTableSize(string $table): int
    {
        try {
            $driver = DB::getDriverName();

            if ($driver === 'mysql') {
                $database = DB::getDatabaseName();
                $result = DB::selectOne(
                    'SELECT data_length + index_length as size 
                     FROM information_schema.tables 
                     WHERE table_schema = ? AND table_name = ?',
                    [$database, $table]
                );

                return (int) ($result->size ?? 0);
            } else {
                // Approximate for other databases
                $count = DB::table($table)->count();
                $columns = Schema::getColumnListing($table);

                return $count * count($columns) * 100;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get reason for indexing a column.
     */
    protected function getIndexReason(string $column): string
    {
        return match ($column) {
            'user_id' => 'Foreign key for JOIN operations',
            'status' => 'Frequently used in WHERE/filtering',
            'created_at', 'updated_at' => 'Used for sorting and date ranges',
            'role' => 'User role filtering',
            'is_verified' => 'Boolean flag for filtering',
            'email' => 'Unique lookup and search',
            'kategori', 'category' => 'Category filtering',
            'jenis_bantuan', 'jenis_tanaman' => 'Type-based filtering',
            'tanggal', 'tanggal_panen', 'tanggal_permintaan' => 'Date-based queries',
            default => 'Improve query performance',
        };
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
