<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DetectN1Queries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only enable in development
        if (! config('app.debug')) {
            return $next($request);
        }

        // Enable query logging
        DB::enableQueryLog();

        // Store initial query count
        $initialQueries = count(DB::getQueryLog());

        // Process request
        $response = $next($request);

        // Get all queries executed
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Detect potential N+1 queries
        $this->detectNPlusOneQueries($queries, $request);

        // Log if too many queries
        if ($queryCount > 20) {
            Log::warning('High query count detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'query_count' => $queryCount,
                'user_id' => auth()->id(),
            ]);
        }

        // Add query count to response header in development
        $response->headers->set('X-Database-Queries', $queryCount);
        $response->headers->set('X-Query-Time', $this->getTotalQueryTime($queries) . 'ms');

        return $response;
    }

    /**
     * Detect N+1 query problems.
     */
    protected function detectNPlusOneQueries(array $queries, Request $request): void
    {
        $patterns = [];
        $nPlusOneDetected = false;

        foreach ($queries as $query) {
            $sql = $query['query'];

            // Normalize query to detect patterns
            $normalized = preg_replace('/\d+/', '?', $sql);
            $normalized = preg_replace('/\'[^\']*\'/', '?', $normalized);

            if (! isset($patterns[$normalized])) {
                $patterns[$normalized] = 0;
            }

            $patterns[$normalized]++;

            // If same query pattern executed more than 5 times, likely N+1
            if ($patterns[$normalized] > 5) {
                $nPlusOneDetected = true;

                Log::warning('Potential N+1 Query Detected', [
                    'url' => $request->fullUrl(),
                    'query' => $sql,
                    'count' => $patterns[$normalized],
                    'suggestion' => $this->getSuggestion($sql),
                ]);
            }
        }

        // Log summary if N+1 detected
        if ($nPlusOneDetected) {
            Log::warning('N+1 Query Problem Summary', [
                'url' => $request->fullUrl(),
                'total_queries' => count($queries),
                'repeated_patterns' => array_filter($patterns, fn ($count) => $count > 5),
                'solution' => 'Use eager loading: User::with(\'relation\')->get()',
            ]);
        }
    }

    /**
     * Get optimization suggestion based on query.
     */
    protected function getSuggestion(string $sql): string
    {
        if (str_contains($sql, 'bantuans')) {
            return 'Use: User::with(\'bantuans\')->get()';
        }

        if (str_contains($sql, 'laporans')) {
            return 'Use: User::with(\'laporans\')->get()';
        }

        if (str_contains($sql, 'notifications')) {
            return 'Use: User::with(\'notifications\')->get()';
        }

        return 'Use eager loading to load relationships';
    }

    /**
     * Calculate total query execution time.
     */
    protected function getTotalQueryTime(array $queries): float
    {
        $total = 0;

        foreach ($queries as $query) {
            $total += $query['time'] ?? 0;
        }

        return round($total, 2);
    }
}
