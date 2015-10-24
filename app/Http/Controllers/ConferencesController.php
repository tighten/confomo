<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ConferencesController extends Controller
{
    public function show(Conference $conference)
    {
        return view('conferences.show')
            ->with('conference', $conference);
    }
}
