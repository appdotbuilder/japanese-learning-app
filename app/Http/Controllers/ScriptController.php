<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ScriptController extends Controller
{
    /**
     * Display script selection page.
     */
    public function index()
    {
        return Inertia::render('script-selection');
    }
}