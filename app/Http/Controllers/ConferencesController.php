<?php

namespace App\Http\Controllers;

use App\Conference;

class ConferencesController extends Controller
{
    public function show(Conference $conference)
    {
        return view('conferences.show', compact('conference'));
    }
}
