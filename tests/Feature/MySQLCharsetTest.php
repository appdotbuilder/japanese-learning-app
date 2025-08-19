<?php

namespace Tests\Feature;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MySQLCharsetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the database is properly configured for MySQL with UTF8MB4.
     */
    public function test_database_uses_utf8mb4_charset(): void
    {
        // Skip if not using MySQL
        if (DB::getDriverName() !== 'mysql') {
            $this->markTestSkipped('This test is only for MySQL databases.');
        }

        // Test database charset
        $charset = DB::select("SELECT @@character_set_database as charset")[0]->charset;
        $this->assertEquals('utf8mb4', $charset, 'Database should use utf8mb4 charset for Japanese character support');
    }

    /**
     * Test that the database can properly store and retrieve Japanese characters.
     */
    public function test_can_store_japanese_characters(): void
    {
        $material = Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'test-japanese',
            'lesson_name' => 'テスト - Japanese Test',
            'description' => 'これは日本語のテストです。Testing Japanese characters: ひらがな、カタカナ、漢字',
            'characters' => [
                ['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah'],
                ['jp' => 'か', 'romaji' => 'ka', 'sound' => 'kah'],
                ['jp' => 'さ', 'romaji' => 'sa', 'sound' => 'sah'],
                ['jp' => 'ア', 'romaji' => 'a', 'sound' => 'ah'],
                ['jp' => 'カ', 'romaji' => 'ka', 'sound' => 'kah'],
                ['jp' => 'サ', 'romaji' => 'sa', 'sound' => 'sah'],
                ['jp' => '愛', 'romaji' => 'ai', 'sound' => 'love'],
            ]
        ]);

        $this->assertDatabaseHas('materials', [
            'lesson_name' => 'テスト - Japanese Test',
        ]);

        // Retrieve and verify Japanese characters are preserved
        $retrieved = Material::find($material->id);
        $this->assertEquals('テスト - Japanese Test', $retrieved->lesson_name);
        $this->assertStringContainsString('これは日本語のテストです', $retrieved->description);
        $this->assertStringContainsString('ひらがな、カタカナ、漢字', $retrieved->description);
        
        // Test JSON field with Japanese characters
        $characters = $retrieved->characters;
        $this->assertIsArray($characters);
        $this->assertEquals('あ', $characters[0]['jp']);
        $this->assertEquals('愛', $characters[6]['jp']);
    }

    /**
     * Test that complex Japanese text is properly handled.
     */
    public function test_complex_japanese_text_storage(): void
    {
        $complexText = '私の名前は田中です。私は東京に住んでいます。日本語を勉強しています。🇯🇵';
        
        $material = Material::create([
            'script_type' => 'mixed',
            'lesson_key' => 'complex-test',
            'lesson_name' => '複雑なテスト',
            'description' => $complexText,
            'characters' => [
                ['jp' => '私', 'romaji' => 'watashi', 'sound' => 'I/me'],
                ['jp' => '東京', 'romaji' => 'tokyo', 'sound' => 'Tokyo'],
                ['jp' => '日本語', 'romaji' => 'nihongo', 'sound' => 'Japanese language'],
            ]
        ]);

        $retrieved = Material::find($material->id);
        $this->assertEquals($complexText, $retrieved->description);
        $this->assertEquals('私', $retrieved->characters[0]['jp']);
        $this->assertEquals('東京', $retrieved->characters[1]['jp']);
        $this->assertEquals('日本語', $retrieved->characters[2]['jp']);
    }

    /**
     * Test that the materials table uses the correct charset and collation.
     */
    public function test_materials_table_charset_and_collation(): void
    {
        // Skip if not using MySQL
        if (DB::getDriverName() !== 'mysql') {
            $this->markTestSkipped('This test is only for MySQL databases.');
        }

        $tableInfo = DB::select("
            SELECT TABLE_COLLATION 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'materials'
        ");

        if (!empty($tableInfo)) {
            $collation = $tableInfo[0]->TABLE_COLLATION;
            $this->assertEquals('utf8mb4_unicode_ci', $collation, 
                'Materials table should use utf8mb4_unicode_ci collation for proper Japanese character sorting');
        }
    }

    /**
     * Test MySQL JSON field functionality with Japanese characters.
     */
    public function test_mysql_json_field_with_japanese(): void
    {
        // Skip if not using MySQL
        if (DB::getDriverName() !== 'mysql') {
            $this->markTestSkipped('This test is only for MySQL databases.');
        }

        $material = Material::create([
            'script_type' => 'hiragana',
            'lesson_key' => 'json-test',
            'lesson_name' => 'JSON Test',
            'description' => 'Testing MySQL JSON functionality',
            'characters' => [
                ['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah', 'notes' => '基本的な母音'],
                ['jp' => 'か', 'romaji' => 'ka', 'sound' => 'kah', 'notes' => 'カ行の最初'],
            ]
        ]);

        // Test JSON query functionality
        $results = Material::whereJsonContains('characters', [
            'jp' => 'あ',
            'romaji' => 'a',
            'sound' => 'ah',
            'notes' => '基本的な母音'
        ])->get();

        $this->assertCount(1, $results);
        $this->assertEquals($material->id, $results->first()->id);
    }
}