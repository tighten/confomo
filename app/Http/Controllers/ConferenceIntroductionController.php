<?php

namespace App\Http\Controllers;

use App\Conference;
use Illuminate\Http\Request;

class ConferenceIntroductionController extends Controller
{
    public function index($conferenceSlug)
    {
        return view('conferences.introduce')
            ->with('conference', Conference::where('slug', $conferenceSlug)->firstOrFail());
    }

    public function store($conferenceSlug, Request $request)
    {
        $this->validate($request, ['username' => 'required']);

        return Conference::where('slug', $conferenceSlug)
            ->firstOrFail()
            ->makeIntroduction($request->input('username'));
    }
}
