<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferencesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);


        // Note: Placeholders show YYYY-mm-dd, but Chrome/etc. will localize.
        // Hopefully Carbon can always handle the diffs. Bears investigation.

        return Auth::user()->addConference([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);
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
