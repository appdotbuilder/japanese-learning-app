<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseOptimizationService
{
    /**
     * Apply database-specific optimizations.
     */
    public function optimize(): void
    {
        $driver = DB::getDriverName();
        
        switch ($driver) {
            case 'mysql':
                $this->optimizeMySQL();
                break;
            case 'pgsql':
                $this->optimizePostgreSQL();
                break;
            case 'sqlite':
                $this->optimizeSQLite();
                break;
            default:
                Log::info("No specific optimizations for driver: {$driver}");
        }
    }

    /**
     * Apply MySQL-specific optimizations.
     */
    protected function optimizeMySQL(): void
    {
        try {
            // Set charset for Japanese character support
            DB::statement('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
            
            // Optimize for JSON operations
            DB::statement('SET sql_mode = ""');
            
            // Enable better performance for JSON queries
            DB::statement('SET optimizer_search_depth = 62');
            
            Log::info('MySQL optimizations applied successfully');
        } catch (\Exception $e) {
            Log::warning('Failed to apply MySQL optimizations: ' . $e->getMessage());
        }
    }

    /**
     * Apply PostgreSQL-specific optimizations.
     */
    protected function optimizePostgreSQL(): void
    {
        try {
            // Set timezone for consistent timestamps
            DB::statement("SET TIME ZONE 'UTC'");
            
            // Enable better JSON performance
            DB::statement('SET enable_hashjoin = on');
            DB::statement('SET enable_mergejoin = on');
            
            Log::info('PostgreSQL optimizations applied successfully');
        } catch (\Exception $e) {
            Log::warning('Failed to apply PostgreSQL optimizations: ' . $e->getMessage());
        }
    }

    /**
     * Apply SQLite-specific optimizations.
     */
    protected function optimizeSQLite(): void
    {
        try {
            // Enable foreign key support
            DB::statement('PRAGMA foreign_keys = ON');
            
            // Optimize for performance
            DB::statement('PRAGMA journal_mode = WAL');
            DB::statement('PRAGMA synchronous = NORMAL');
            DB::statement('PRAGMA cache_size = 1000000');
            
            Log::info('SQLite optimizations applied successfully');
        } catch (\Exception $e) {
            Log::warning('Failed to apply SQLite optimizations: ' . $e->getMessage());
        }
    }

    /**
     * Check if database supports Japanese characters properly.
     */
    public function supportsJapaneseCharacters(): bool
    {
        try {
            // Try to insert and retrieve Japanese characters
            $testTable = 'test_japanese_' . random_int(1000, 9999);
            
            DB::statement("CREATE TABLE {$testTable} (id INTEGER, text TEXT)");
            DB::table($testTable)->insert(['id' => 1, 'text' => 'あいうえお']);
            
            $result = DB::table($testTable)->where('id', 1)->first();
            $success = $result && $result->text === 'あいうえお';
            
            DB::statement("DROP TABLE {$testTable}");
            
            return $success;
        } catch (\Exception $e) {
            Log::error('Japanese character support test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get database information for debugging.
     */
    public function getDatabaseInfo(): array
    {
        $driver = DB::getDriverName();
        $info = [
            'driver' => $driver,
            'japanese_support' => $this->supportsJapaneseCharacters(),
        ];

        try {
            switch ($driver) {
                case 'mysql':
                    $version = DB::select('SELECT VERSION() as version')[0]->version;
                    $charset = DB::select('SELECT @@character_set_database as charset')[0]->charset ?? 'unknown';
                    $collation = DB::select('SELECT @@collation_database as collation')[0]->collation ?? 'unknown';
                    
                    $info = array_merge($info, [
                        'version' => $version,
                        'charset' => $charset,
                        'collation' => $collation,
                    ]);
                    break;

                case 'pgsql':
                    $version = DB::select('SELECT VERSION() as version')[0]->version;
                    $encoding = DB::select('SHOW client_encoding')[0]->client_encoding ?? 'unknown';
                    
                    $info = array_merge($info, [
                        'version' => $version,
                        'encoding' => $encoding,
                    ]);
                    break;

                case 'sqlite':
                    $version = DB::select('SELECT sqlite_version() as version')[0]->version;
                    
                    $info = array_merge($info, [
                        'version' => $version,
                    ]);
                    break;
            }
        } catch (\Exception $e) {
            $info['error'] = $e->getMessage();
        }

        return $info;
    }
}