<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'script_type' => $this->faker->randomElement(['hiragana', 'katakana']),
            'lesson_key' => $this->faker->slug(2),
            'lesson_name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'characters' => [
                [
                    'jp' => 'あ',
                    'romaji' => 'a',
                    'sound' => 'ah'
                ],
                [
                    'jp' => 'い',
                    'romaji' => 'i',
                    'sound' => 'ee'
                ]
            ],
        ];
    }
}