<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConferenceOnlineFriendsController extends Controller
{
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
