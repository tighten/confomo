<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferenceOnlineFriendsController extends Controller
{
    public function __construct(Request $request)
    {
        abort_if(! Auth::user()->owns($request->conference), 404);
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
        foreach (request()->all() as $key => $value) {
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
