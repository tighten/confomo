<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConferenceNewFriendsController extends Controller
{
    public function store(Conference $conference)
    {
        $conference->meetNewFriend(request('username'));
    }

    public function index(Conference $conference)
    {
        return $conference->newFriends;
    }
}
