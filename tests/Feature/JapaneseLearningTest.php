<?php

namespace Tests\Feature;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JapaneseLearningTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_correctly(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
        );
    }

    public function test_script_selection_page_displays_correctly(): void
    {
        $response = $this->get('/scripts');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('script-selection')
        );
    }

    public function test_lesson_selection_displays_materials_for_hiragana(): void
    {
        Material::factory()->create([
            'script_type' => 'hiragana',
            'lesson_key' => 'vowels',
            'lesson_name' => 'Vowels',
        ]);

        $response = $this->get('/lessons/hiragana');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('lesson-selection')
                ->has('materials', 1)
                ->where('scriptType', 'hiragana')
        );
    }

    public function test_lesson_selection_displays_materials_for_katakana(): void
    {
        Material::factory()->create([
            'script_type' => 'katakana',
            'lesson_key' => 'vowels',
            'lesson_name' => 'Vowels',
        ]);

        $response = $this->get('/lessons/katakana');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('lesson-selection')
                ->has('materials', 1)
                ->where('scriptType', 'katakana')
        );
    }

    public function test_lesson_selection_returns_404_for_invalid_script(): void
    {
        $response = $this->get('/lessons/invalid');

        $response->assertStatus(404);
    }

    public function test_flashcard_page_displays_correctly(): void
    {
        $material = Material::factory()->create([
            'script_type' => 'hiragana',
            'lesson_key' => 'vowels',
        ]);

        $response = $this->get('/flashcard/hiragana/vowels');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('flashcard')
                ->where('scriptType', 'hiragana')
                ->has('material')
        );
    }

    public function test_flashcard_returns_404_for_invalid_script(): void
    {
        $response = $this->get('/flashcard/invalid/vowels');

        $response->assertStatus(404);
    }

    public function test_flashcard_returns_404_for_nonexistent_material(): void
    {
        $response = $this->get('/flashcard/hiragana/nonexistent');

        $response->assertStatus(404);
    }
}