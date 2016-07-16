<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConferenceIntroductionController extends Controller
{
    public function index(Conference $conference)
    {
        return view('conferences.introduce')->with('conference', $conference);
    }

    public function store(Conference $conference, Request $request)
    {
        return $conference->makeIntroduction($request->input('username'));
    }
}
