<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ConferenceOnlineFriendsController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->route('conference')->user_id !== Auth::user()->id) {
            abort(404);
        }
    }

    public function store(Conference $conference)
    {
        return $conference->planToMeetOnlineFriend(request('username'));
    }

    public function index(Conference $conference)
    {
        return $conference->onlineFriends;
    }

    public function update(Conference $conference, Friend $friend)
    {
        foreach (Input::all() as $key => $value) {
            $friend->$key = $value;
        }

        $friend->save();
    }

    public function show(Conference $conference, Friend $friend)
    {
        return $friend;
    }

    public function delete(Conference $conference, Friend $friend)
    {
        $friend->delete();
    }
}
