<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Inertia\Inertia;

class FlashcardController extends Controller
{
    /**
     * Display flashcard learning page.
     */
    public function show(string $scriptType, string $lessonKey)
    {
        if (!in_array($scriptType, ['hiragana', 'katakana'])) {
            abort(404);
        }

        $material = Material::where('script_type', $scriptType)
            ->where('lesson_key', $lessonKey)
            ->first();

        if (!$material) {
            abort(404);
        }

        return Inertia::render('flashcard', [
            'scriptType' => $scriptType,
            'material' => $material
        ]);
    }
}