<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferencesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:' . dayBefore($request->start_date),
        ]);

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
        abort_if($conference->user_id !== Auth::user()->id, 404);

        $conference->delete();
    }
}
