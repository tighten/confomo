<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\File;

class AvatarController extends Controller
{
    public function show($username)
    {
        if (! $friend = Friend::where('username', $username)->first()) {
            return $this->showUser($username);
        }

        if (! file_exists(public_path($friend->avatar))) {
            return $this->defaultAvatarResponse();
        }

        $mimeType = File::mimeType($avatar_path = public_path($friend->avatar));

        return $this->fileResponse($avatar_path, ['Content-type' => $mimeType]);
    }

    private function defaultAvatarResponse()
    {
        return $this->fileResponse(public_path('assets/img/default_avatar.png'), ['Content-type' => 'image/png']);
    }

    private function showUser($username)
    {
        if (! $user = User::where('twitter_nickname', $username)->first()) {
            return $this->defaultAvatarResponse();
        }

        if (! file_exists(public_path($user->avatar))) {
            return $this->defaultAvatarResponse();
        }

        $mimeType = File::mimeType($avatar_path = public_path($user->avatar));

        return $this->fileResponse($avatar_path, ['Content-type' => $mimeType]);
    }
}
