<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferencesController extends Controller
{
    public function store(Request $request)
    {
        Auth::user()->addConference(['name' => $request->input('name')]);
    }

    public function index()
    {
        return Auth::user()->conferences()->get();
    }
}
