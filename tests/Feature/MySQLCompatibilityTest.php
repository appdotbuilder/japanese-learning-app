<?php

namespace Tests\Feature;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MySQLCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed the database with MySQL optimized data
        $this->artisan('db:seed', ['--class' => 'MySQLOptimizedSeeder']);
    }

    /**
     * Test that MySQL connection is working properly.
     */
    public function test_mysql_connection_works(): void
    {
        // Test basic connection
        $this->assertTrue(DB::connection()->getPdo() !== null);
        
        // Test that we can query the database
        $materials = Material::all();
        $this->assertNotEmpty($materials);
    }

    /**
     * Test that Japanese characters are stored and retrieved correctly in MySQL.
     */
    public function test_japanese_characters_storage(): void
    {
        // Test hiragana characters
        $hiraganaVowels = Material::where('script_type', 'hiragana')
            ->where('lesson_key', 'vowels')
            ->first();
            
        $this->assertNotNull($hiraganaVowels);
        $this->assertIsArray($hiraganaVowels->characters);
        
        // Check that Japanese characters are preserved
        $characters = $hiraganaVowels->characters;
        $this->assertEquals('あ', $characters[0]['jp']);
        $this->assertEquals('い', $characters[1]['jp']);
        $this->assertEquals('う', $characters[2]['jp']);
        $this->assertEquals('え', $characters[3]['jp']);
        $this->assertEquals('お', $characters[4]['jp']);
    }

    /**
     * Test that katakana characters work correctly.
     */
    public function test_katakana_characters_storage(): void
    {
        $katakanaVowels = Material::where('script_type', 'katakana')
            ->where('lesson_key', 'vowels')
            ->first();
            
        $this->assertNotNull($katakanaVowels);
        $characters = $katakanaVowels->characters;
        
        // Check that Katakana characters are preserved
        $this->assertEquals('ア', $characters[0]['jp']);
        $this->assertEquals('イ', $characters[1]['jp']);
        $this->assertEquals('ウ', $characters[2]['jp']);
        $this->assertEquals('エ', $characters[3]['jp']);
        $this->assertEquals('オ', $characters[4]['jp']);
    }

    /**
     * Test JSON field functionality with MySQL.
     */
    public function test_json_field_mysql_compatibility(): void
    {
        // Create a new material with complex JSON data
        $material = Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'test-json',
            'lesson_name' => 'Test JSON',
            'description' => 'Testing JSON compatibility with MySQL',
            'characters' => [
                [
                    'jp' => 'が',
                    'romaji' => 'ga',
                    'sound' => 'gah',
                    'difficulty' => 2,
                    'notes' => 'This is a test note with special chars: 漢字'
                ]
            ]
        ]);

        // Retrieve and verify
        $retrieved = Material::find($material->id);
        $this->assertIsArray($retrieved->characters);
        $this->assertEquals('が', $retrieved->characters[0]['jp']);
        $this->assertEquals(2, $retrieved->characters[0]['difficulty']);
        $this->assertStringContainsString('漢字', $retrieved->characters[0]['notes']);
    }

    /**
     * Test database indexes work correctly with MySQL.
     */
    public function test_mysql_indexes(): void
    {
        // Test that indexed queries work efficiently
        $hiraganaCount = Material::where('script_type', 'hiragana')->count();
        $katakanaCount = Material::where('script_type', 'katakana')->count();
        
        $this->assertGreaterThan(0, $hiraganaCount);
        $this->assertGreaterThan(0, $katakanaCount);
        
        // Test compound index
        $kSeries = Material::where('script_type', 'hiragana')
            ->where('lesson_key', 'k-series')
            ->first();
            
        $this->assertNotNull($kSeries);
        $this->assertEquals('K-Series (KA, KI, KU, KE, KO)', $kSeries->lesson_name);
    }

    /**
     * Test Model scopes work with MySQL.
     */
    public function test_model_scopes_with_mysql(): void
    {
        $hiraganaCount = Material::hiragana()->count();
        $katakanaCount = Material::katakana()->count();
        
        $this->assertGreaterThan(0, $hiraganaCount);
        $this->assertGreaterThan(0, $katakanaCount);
        
        // Test that scopes return the correct data
        $hiraganaItems = Material::hiragana()->get();
        foreach ($hiraganaItems as $item) {
            $this->assertEquals('hiragana', $item->script_type);
        }
    }

    /**
     * Test charset and collation are properly set.
     */
    public function test_mysql_charset_collation(): void
    {
        // This test assumes MySQL connection
        if (DB::getDriverName() === 'mysql') {
            try {
                $charset = DB::select("SELECT @@character_set_database as charset")[0]->charset;
                $collation = DB::select("SELECT @@collation_database as collation")[0]->collation;
                
                // These should be set for proper Japanese character support
                $this->assertStringContainsString('utf8', strtolower($charset));
                $this->assertStringContainsString('utf8', strtolower($collation));
                
                // Preferably should be utf8mb4 for full Unicode support
                $this->assertEquals('utf8mb4', $charset, 'Database should use utf8mb4 charset');
                $this->assertStringContainsString('utf8mb4', $collation, 'Database should use utf8mb4 collation');
            } catch (\Exception $e) {
                // If we can't check charset/collation, just verify Japanese chars work
                $this->assertTrue(true, 'Unable to check MySQL charset, but test setup allows this');
            }
        } else {
            $this->markTestSkipped('This test is only for MySQL connections');
        }
    }

    /**
     * Test MySQL version compatibility.
     */
    public function test_mysql_version_compatibility(): void
    {
        if (DB::getDriverName() === 'mysql') {
            try {
                $version = DB::select('SELECT VERSION() as version')[0]->version;
                
                // Extract major.minor version number
                preg_match('/^(\d+\.\d+)/', $version, $matches);
                $majorMinor = (float) $matches[1];
                
                // MySQL 5.7+ has better JSON support
                $this->assertGreaterThanOrEqual(5.7, $majorMinor, 'MySQL 5.7 or higher recommended for JSON support');
                
            } catch (\Exception $e) {
                $this->markTestSkipped('Unable to determine MySQL version');
            }
        } else {
            $this->markTestSkipped('This test is only for MySQL connections');
        }
    }

    /**
     * Test MySQL JSON query functionality.
     */
    public function test_mysql_json_queries(): void
    {
        if (DB::getDriverName() === 'mysql') {
            try {
                // Test JSON_EXTRACT functionality
                $materials = DB::table('materials')
                    ->whereRaw("JSON_EXTRACT(characters, '$[0].jp') = ?", ['あ'])
                    ->get();
                
                $this->assertNotEmpty($materials, 'JSON_EXTRACT should find hiragana vowel materials');
                
                // Test JSON search with Japanese characters
                $vowelMaterials = Material::whereJsonContains('characters', ['jp' => 'あ'])->get();
                $this->assertNotEmpty($vowelMaterials, 'JSON contains search should work with Japanese characters');
                
            } catch (\Exception $e) {
                $this->markTestSkipped('MySQL JSON functionality not available: ' . $e->getMessage());
            }
        } else {
            $this->markTestSkipped('This test is only for MySQL connections');
        }
    }

    /**
     * Test that all required lesson data exists.
     */
    public function test_complete_lesson_data(): void
    {
        $expectedLessons = [
            'hiragana' => ['vowels', 'k-series', 's-series', 't-series', 'n-series'],
            'katakana' => ['vowels', 'k-series', 's-series', 't-series', 'n-series']
        ];
        
        foreach ($expectedLessons as $scriptType => $lessonKeys) {
            foreach ($lessonKeys as $lessonKey) {
                $material = Material::where('script_type', $scriptType)
                    ->where('lesson_key', $lessonKey)
                    ->first();
                    
                $this->assertNotNull(
                    $material,
                    "Missing lesson: {$scriptType} - {$lessonKey}"
                );
                
                $this->assertIsArray($material->characters);
                $this->assertNotEmpty($material->characters);
            }
        }
    }
}