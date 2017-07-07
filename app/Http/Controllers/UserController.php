<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('users.show')
            ->with('user', $user);
    }

    public function settings()
    {
        return view('users.settings')
            ->with('user', Auth::user());
    }
}
