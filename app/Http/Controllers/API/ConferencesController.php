<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferencesController extends Controller
{
    public function store(Request $request)
    {
        return Auth::user()->addConference(['name' => $request->input('name')]);
    }

    public function index()
    {
        return Auth::user()->conferences()->get();
    }

    public function delete(Conference $conference)
    {
        if ($conference->user_id !== Auth::user()->id) {
            abort(404);
        }

        $conference->delete();
    }
}
