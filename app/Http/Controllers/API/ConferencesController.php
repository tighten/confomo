<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreConferenceRequest;

class ConferencesController extends Controller
{
    public function store(StoreConferenceRequest $request)
    {
        return Auth::user()->addConference($request->only([
            'name',
            'start_date',
            'end_date',
        ]));
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
