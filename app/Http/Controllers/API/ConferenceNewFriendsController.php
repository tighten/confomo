<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferenceNewFriendsController extends Controller
{
    public function store(Conference $conference, Request $request)
    {
        return $conference->meetNewFriend($request->input('username'));
    }

    public function index(Conference $conference)
    {
        return $conference->newFriends;
    }

    public function delete(Conference $conference, Friend $friend)
    {
        $friend->delete();
    }
}
