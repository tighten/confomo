<?php

namespace App\Listeners;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Events\FriendWasSaved;
use App\Friend;

class FetchTwitterAvatar
{
    /**
     * Create the event listener.
     * 
     * @param  \Abraham\TwitterOAuth\TwitterOAuth  $twitter
     * @return void
     */
    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Handle the event.
     *
     * @param  FriendWasSaved  $event
     * @return void
     */
    public function handle(FriendWasSaved $event)
    {
        if ($this->friendAvatarExists($event->friend)) {
            return;
        }

        $this->fetchFriendAvatar($event->friend);
    }


    private function friendAvatarExists(Friend $friend)
    {
        return file_exists(public_path($friend->avatar));
    }


    private function fetchFriendAvatar(Friend $friend)
    {
        try {
            $details = app(TwitterOAuth::class)->get('users/show', ['screen_name' => $friend->username]);
            $url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($friend->avatar), @file_get_contents($url))) {
                return true;
            }
        } catch (Exception $e) {
            // No big deal
        }

        return false;
    }
}
