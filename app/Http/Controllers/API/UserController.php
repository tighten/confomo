<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserConferences(User $user)
    {
        if (! $user->conferenceListIsPublic) {
            return response('no_content', 204);
        }
        $conferences = $user->conferences()->orderBy('start_date', 'desc')->get();
        $conferences->transform(function ($conference) {
            $conference->timeframe = ($conference->isUpcoming()) ? "future" : "past";

            return $conference;
        });

        return $conferences->groupBy('timeframe');
    }

    public function delete(Conference $conference)
    {
        abort_if($conference->user_id !== Auth::user()->id, 404);

        $conference->delete();
    }

    public function settings()
    {
        $user = Auth::user();

        return [
            "userIsSearchable" => isset($user->userIsSearchable) ? $user->userIsSearchable : false ,
            "conferenceListIsPublic" => isset($user->conferenceListIsPublic) ? $user->conferenceListIsPublic : false,
        ];
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->replace([
            'userIsSearchable' => (boolean) $request->userIsSearchable,
            'conferenceListIsPublic' => (boolean) $request->conferenceListIsPublic,
        ]);

        $this->validate($request, [
            'userIsSearchable' => 'required|boolean',
            'conferenceListIsPublic' => 'required|boolean',
        ]);

        $user->userIsSearchable = $request->userIsSearchable;
        $user->conferenceListIsPublic = $request->conferenceListIsPublic;
        $user->save();
    }
}
