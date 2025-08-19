<?php

namespace Tests\Feature;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the application works with the current database configuration.
     */
    public function test_database_connection_works(): void
    {
        // Test basic connection
        $this->assertTrue(DB::connection()->getPdo() !== null);
        
        // Test that we can create and retrieve data
        $material = Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'test',
            'lesson_name' => 'Test Lesson',
            'description' => 'Test description',
            'characters' => [
                ['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah']
            ]
        ]);

        $this->assertDatabaseHas('materials', [
            'script_type' => 'hiragana',
            'lesson_key' => 'test'
        ]);
        
        $retrieved = Material::find($material->id);
        $this->assertEquals('あ', $retrieved->characters[0]['jp']);
    }

    /**
     * Test that Japanese characters are preserved in the database.
     */
    public function test_japanese_character_preservation(): void
    {
        $testChars = [
            // Hiragana
            ['jp' => 'あ', 'romaji' => 'a'],
            ['jp' => 'か', 'romaji' => 'ka'],
            ['jp' => 'さ', 'romaji' => 'sa'],
            // Katakana
            ['jp' => 'ア', 'romaji' => 'a'],
            ['jp' => 'カ', 'romaji' => 'ka'],
            ['jp' => 'サ', 'romaji' => 'sa'],
            // Kanji (if supported)
            ['jp' => '漢', 'romaji' => 'kan'],
            ['jp' => '字', 'romaji' => 'ji'],
        ];

        $material = Material::create([
            'script_type' => 'mixed',
            'lesson_key' => 'unicode-test',
            'lesson_name' => 'Unicode Test',
            'description' => 'Testing Japanese character storage',
            'characters' => $testChars
        ]);

        $retrieved = Material::find($material->id);
        
        foreach ($testChars as $index => $char) {
            $this->assertEquals(
                $char['jp'], 
                $retrieved->characters[$index]['jp'],
                "Japanese character {$char['jp']} was not preserved correctly"
            );
        }
    }

    /**
     * Test that model relationships and queries work correctly.
     */
    public function test_model_queries_work(): void
    {
        // Create test data
        Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'vowels',
            'lesson_name' => 'Vowels',
            'description' => 'Basic vowels',
            'characters' => [['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah']]
        ]);

        Material::create([
            'script_type' => 'katakana',
            'lesson_key' => 'vowels',
            'lesson_name' => 'Vowels',
            'description' => 'Basic vowels',
            'characters' => [['jp' => 'ア', 'romaji' => 'a', 'sound' => 'ah']]
        ]);

        // Test queries
        $hiragana = Material::where('script_type', 'hiragana')->get();
        $katakana = Material::where('script_type', 'katakana')->get();
        
        $this->assertCount(1, $hiragana);
        $this->assertCount(1, $katakana);
        
        // Test scopes
        $hiraganaScoped = Material::hiragana()->get();
        $katakanaScoped = Material::katakana()->get();
        
        $this->assertCount(1, $hiraganaScoped);
        $this->assertCount(1, $katakanaScoped);
    }

    /**
     * Test JSON field functionality.
     */
    public function test_json_field_functionality(): void
    {
        $complexData = [
            [
                'jp' => 'あ',
                'romaji' => 'a',
                'sound' => 'ah',
                'difficulty' => 1,
                'examples' => ['ありがとう', 'あさ'],
                'notes' => 'Basic vowel sound'
            ]
        ];

        $material = Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'json-test',
            'lesson_name' => 'JSON Test',
            'description' => 'Testing complex JSON data',
            'characters' => $complexData
        ]);

        $retrieved = Material::find($material->id);
        $this->assertIsArray($retrieved->characters);
        $this->assertEquals(1, $retrieved->characters[0]['difficulty']);
        $this->assertIsArray($retrieved->characters[0]['examples']);
        $this->assertCount(2, $retrieved->characters[0]['examples']);
    }

    /**
     * Test database indexes are working (performance test).
     */
    public function test_database_indexes(): void
    {
        // Create multiple materials
        for ($i = 0; $i < 10; $i++) {
            Material::create([
                'script_type' => $i % 2 === 0 ? 'hiragana' : 'katakana',
                'lesson_key' => 'series-' . ($i % 3),
                'lesson_name' => 'Test Series ' . $i,
                'description' => 'Test description ' . $i,
                'characters' => [['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah']]
            ]);
        }

        // Test indexed queries
        $hiraganaCount = Material::where('script_type', 'hiragana')->count();
        $series0Count = Material::where('lesson_key', 'series-0')->count();
        
        $this->assertGreaterThan(0, $hiraganaCount);
        $this->assertGreaterThan(0, $series0Count);
        
        // Test compound index
        $specific = Material::where('script_type', 'hiragana')
                          ->where('lesson_key', 'series-0')
                          ->first();
        
        $this->assertNotNull($specific);
    }
}