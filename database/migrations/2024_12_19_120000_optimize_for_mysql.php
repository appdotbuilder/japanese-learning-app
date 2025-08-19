<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Optimize materials table for MySQL
        Schema::table('materials', function (Blueprint $table) {
            // Add character set and collation for Japanese text support
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
            
            // Optimize JSON field for MySQL
            if (Schema::hasColumn('materials', 'characters')) {
                // MySQL handles JSON natively, no changes needed
            }
        });
        
        // Ensure users table uses proper charset for international names
        Schema::table('users', function (Blueprint $table) {
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
        });
        
        // Optimize cache table for MySQL
        Schema::table('cache', function (Blueprint $table) {
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
        });
        
        // Optimize sessions table for MySQL
        Schema::table('sessions', function (Blueprint $table) {
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse charset optimizations
    }
};