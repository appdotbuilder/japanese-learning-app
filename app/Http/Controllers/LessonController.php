<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Inertia\Inertia;

class LessonController extends Controller
{
    /**
     * Display lessons for a specific script type.
     */
    public function index(string $scriptType)
    {
        if (!in_array($scriptType, ['hiragana', 'katakana'])) {
            abort(404);
        }

        $materials = Material::where('script_type', $scriptType)
            ->orderBy('lesson_key')
            ->get();

        return Inertia::render('lesson-selection', [
            'scriptType' => $scriptType,
            'materials' => $materials
        ]);
    }
}