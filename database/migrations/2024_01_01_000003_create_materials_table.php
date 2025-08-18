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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('script_type')->comment('hiragana or katakana');
            $table->string('lesson_key')->comment('Unique lesson identifier like vowels, k-series');
            $table->string('lesson_name')->comment('Display name for the lesson');
            $table->text('description')->comment('Description of the lesson');
            $table->json('characters')->comment('Array of character objects with jp, romaji, sound');
            $table->timestamps();
            
            $table->index('script_type');
            $table->index('lesson_key');
            $table->index(['script_type', 'lesson_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};