<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Http\Controllers\Controller;

class ConferenceOnlineFriendsController extends Controller
{
    public function store(Conference $conference)
    {
        $conference->meetOnlineFriend(request('username'));
    }

    public function index(Conference $conference)
    {
        return $conference->onlineFriends;
    }
}
