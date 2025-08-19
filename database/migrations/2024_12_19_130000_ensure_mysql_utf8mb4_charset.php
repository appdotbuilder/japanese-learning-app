<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run this migration for MySQL
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Ensure all text columns in materials table use utf8mb4
        if (Schema::hasTable('materials')) {
            DB::statement('ALTER TABLE materials CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure all text columns in users table use utf8mb4
        if (Schema::hasTable('users')) {
            DB::statement('ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure cache table uses utf8mb4 for proper session handling
        if (Schema::hasTable('cache')) {
            DB::statement('ALTER TABLE cache CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure cache_locks table uses utf8mb4
        if (Schema::hasTable('cache_locks')) {
            DB::statement('ALTER TABLE cache_locks CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure sessions table uses utf8mb4
        if (Schema::hasTable('sessions')) {
            DB::statement('ALTER TABLE sessions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure job tables use utf8mb4
        if (Schema::hasTable('jobs')) {
            DB::statement('ALTER TABLE jobs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        if (Schema::hasTable('job_batches')) {
            DB::statement('ALTER TABLE job_batches CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        if (Schema::hasTable('failed_jobs')) {
            DB::statement('ALTER TABLE failed_jobs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Ensure migrations table uses utf8mb4
        if (Schema::hasTable('migrations')) {
            DB::statement('ALTER TABLE migrations CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        // Add indexes for better performance with Japanese text
        if (Schema::hasTable('materials')) {
            Schema::table('materials', function (Blueprint $table) {
                // Add full-text index for Japanese text search (MySQL 5.7+)
                try {
                    DB::statement('ALTER TABLE materials ADD FULLTEXT(lesson_name, description)');
                } catch (\Exception $e) {
                    // Ignore if fulltext index already exists or not supported
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as it's a character set optimization
        // Reverting would potentially cause data loss for Japanese characters
    }
};