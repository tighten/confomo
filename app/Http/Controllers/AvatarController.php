<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Friend;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AvatarController extends Controller
{
    public function show($username)
    {
        if (! $friend = Friend::where('username', $username)->first()) {
            return $this->defaultAvatarResponse();
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
}
