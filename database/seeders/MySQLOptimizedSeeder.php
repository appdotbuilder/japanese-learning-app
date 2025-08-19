<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Services\DatabaseOptimizationService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MySQLOptimizedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Apply database optimizations
        $optimizer = new DatabaseOptimizationService();
        $optimizer->optimize();
        
        // Clear existing materials to avoid duplicates
        Material::truncate();
        
        // Hiragana materials optimized for MySQL
        $hiraganaData = [
            [
                'script_type' => 'hiragana',
                'lesson_key' => 'vowels',
                'lesson_name' => 'Vokal (A, I, U, E, O)',
                'description' => 'Pelajari 5 huruf vokal dasar dalam hiragana',
                'characters' => [
                    ['jp' => 'あ', 'romaji' => 'a', 'sound' => 'ah'],
                    ['jp' => 'い', 'romaji' => 'i', 'sound' => 'ee'],
                    ['jp' => 'う', 'romaji' => 'u', 'sound' => 'oo'],
                    ['jp' => 'え', 'romaji' => 'e', 'sound' => 'eh'],
                    ['jp' => 'お', 'romaji' => 'o', 'sound' => 'oh'],
                ]
            ],
            [
                'script_type' => 'hiragana',
                'lesson_key' => 'k-series',
                'lesson_name' => 'K-Series (KA, KI, KU, KE, KO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi K',
                'characters' => [
                    ['jp' => 'か', 'romaji' => 'ka', 'sound' => 'kah'],
                    ['jp' => 'き', 'romaji' => 'ki', 'sound' => 'kee'],
                    ['jp' => 'く', 'romaji' => 'ku', 'sound' => 'koo'],
                    ['jp' => 'け', 'romaji' => 'ke', 'sound' => 'keh'],
                    ['jp' => 'こ', 'romaji' => 'ko', 'sound' => 'koh'],
                ]
            ],
            [
                'script_type' => 'hiragana',
                'lesson_key' => 's-series',
                'lesson_name' => 'S-Series (SA, SHI, SU, SE, SO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi S',
                'characters' => [
                    ['jp' => 'さ', 'romaji' => 'sa', 'sound' => 'sah'],
                    ['jp' => 'し', 'romaji' => 'shi', 'sound' => 'shee'],
                    ['jp' => 'す', 'romaji' => 'su', 'sound' => 'soo'],
                    ['jp' => 'せ', 'romaji' => 'se', 'sound' => 'seh'],
                    ['jp' => 'そ', 'romaji' => 'so', 'sound' => 'soh'],
                ]
            ],
            [
                'script_type' => 'hiragana',
                'lesson_key' => 't-series',
                'lesson_name' => 'T-Series (TA, CHI, TSU, TE, TO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi T',
                'characters' => [
                    ['jp' => 'た', 'romaji' => 'ta', 'sound' => 'tah'],
                    ['jp' => 'ち', 'romaji' => 'chi', 'sound' => 'chee'],
                    ['jp' => 'つ', 'romaji' => 'tsu', 'sound' => 'tsoo'],
                    ['jp' => 'て', 'romaji' => 'te', 'sound' => 'teh'],
                    ['jp' => 'と', 'romaji' => 'to', 'sound' => 'toh'],
                ]
            ],
            [
                'script_type' => 'hiragana',
                'lesson_key' => 'n-series',
                'lesson_name' => 'N-Series (NA, NI, NU, NE, NO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi N',
                'characters' => [
                    ['jp' => 'な', 'romaji' => 'na', 'sound' => 'nah'],
                    ['jp' => 'に', 'romaji' => 'ni', 'sound' => 'nee'],
                    ['jp' => 'ぬ', 'romaji' => 'nu', 'sound' => 'noo'],
                    ['jp' => 'ね', 'romaji' => 'ne', 'sound' => 'neh'],
                    ['jp' => 'の', 'romaji' => 'no', 'sound' => 'noh'],
                ]
            ]
        ];

        // Katakana materials optimized for MySQL
        $katakanaData = [
            [
                'script_type' => 'katakana',
                'lesson_key' => 'vowels',
                'lesson_name' => 'Vokal (A, I, U, E, O)',
                'description' => 'Pelajari 5 huruf vokal dasar dalam katakana',
                'characters' => [
                    ['jp' => 'ア', 'romaji' => 'a', 'sound' => 'ah'],
                    ['jp' => 'イ', 'romaji' => 'i', 'sound' => 'ee'],
                    ['jp' => 'ウ', 'romaji' => 'u', 'sound' => 'oo'],
                    ['jp' => 'エ', 'romaji' => 'e', 'sound' => 'eh'],
                    ['jp' => 'オ', 'romaji' => 'o', 'sound' => 'oh'],
                ]
            ],
            [
                'script_type' => 'katakana',
                'lesson_key' => 'k-series',
                'lesson_name' => 'K-Series (KA, KI, KU, KE, KO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi K',
                'characters' => [
                    ['jp' => 'カ', 'romaji' => 'ka', 'sound' => 'kah'],
                    ['jp' => 'キ', 'romaji' => 'ki', 'sound' => 'kee'],
                    ['jp' => 'ク', 'romaji' => 'ku', 'sound' => 'koo'],
                    ['jp' => 'ケ', 'romaji' => 'ke', 'sound' => 'keh'],
                    ['jp' => 'コ', 'romaji' => 'ko', 'sound' => 'koh'],
                ]
            ],
            [
                'script_type' => 'katakana',
                'lesson_key' => 's-series',
                'lesson_name' => 'S-Series (SA, SHI, SU, SE, SO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi S',
                'characters' => [
                    ['jp' => 'サ', 'romaji' => 'sa', 'sound' => 'sah'],
                    ['jp' => 'シ', 'romaji' => 'shi', 'sound' => 'shee'],
                    ['jp' => 'ス', 'romaji' => 'su', 'sound' => 'soo'],
                    ['jp' => 'セ', 'romaji' => 'se', 'sound' => 'seh'],
                    ['jp' => 'ソ', 'romaji' => 'so', 'sound' => 'soh'],
                ]
            ],
            [
                'script_type' => 'katakana',
                'lesson_key' => 't-series',
                'lesson_name' => 'T-Series (TA, CHI, TSU, TE, TO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi T',
                'characters' => [
                    ['jp' => 'タ', 'romaji' => 'ta', 'sound' => 'tah'],
                    ['jp' => 'チ', 'romaji' => 'chi', 'sound' => 'chee'],
                    ['jp' => 'ツ', 'romaji' => 'tsu', 'sound' => 'tsoo'],
                    ['jp' => 'テ', 'romaji' => 'te', 'sound' => 'teh'],
                    ['jp' => 'ト', 'romaji' => 'to', 'sound' => 'toh'],
                ]
            ],
            [
                'script_type' => 'katakana',
                'lesson_key' => 'n-series',
                'lesson_name' => 'N-Series (NA, NI, NU, NE, NO)',
                'description' => 'Pelajari huruf-huruf dengan bunyi N',
                'characters' => [
                    ['jp' => 'ナ', 'romaji' => 'na', 'sound' => 'nah'],
                    ['jp' => 'ニ', 'romaji' => 'ni', 'sound' => 'nee'],
                    ['jp' => 'ヌ', 'romaji' => 'nu', 'sound' => 'noo'],
                    ['jp' => 'ネ', 'romaji' => 'ne', 'sound' => 'neh'],
                    ['jp' => 'ノ', 'romaji' => 'no', 'sound' => 'noh'],
                ]
            ]
        ];

        // Insert data using Eloquent to ensure proper JSON encoding for MySQL
        foreach ($hiraganaData as $data) {
            Material::create($data);
        }

        foreach ($katakanaData as $data) {
            Material::create($data);
        }
        
        $this->command->info('MySQL-optimized materials seeded successfully with Japanese characters.');
    }
}