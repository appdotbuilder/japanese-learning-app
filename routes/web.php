<?php

use App\Http\Controllers\DatabaseInfoController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ScriptController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Japanese learning app routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scripts', [ScriptController::class, 'index'])->name('scripts.index');
Route::get('/lessons/{scriptType}', [LessonController::class, 'index'])->name('lessons.index');
Route::get('/flashcard/{scriptType}/{lessonKey}', [FlashcardController::class, 'show'])->name('flashcard.show');

// Database configuration routes (for development/admin)
Route::prefix('admin/database')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DatabaseInfoController::class, 'index'])->name('database.index');
    Route::post('/', [DatabaseInfoController::class, 'store'])->name('database.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
