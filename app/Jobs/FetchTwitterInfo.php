<?php

namespace App\Jobs;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Friend;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;

class FetchTwitterInfo extends Job implements SelfHandling
{
    /**
     * @var \App\Friend
     */
    private $friend;

    /**
     * Create a new job instance.
     *
     * @param  \App\Friend $friend
     * @return void
     */
    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $details = app(TwitterOAuth::class)->get('users/show', ['screen_name' => $this->friend->username]);
            $this->friend->name = $details->name;
            $this->friend->location = $details->location;

            if (array_has($details->entities, 'url')) {
                $this->friend->url = $details->url;
                $this->friend->url_display = $details->entities->url->urls[0]->display_url;
            }

            $this->friend->description = $details->description;
            $this->friend->save();

            $avatar_url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($this->friend->avatar), @file_get_contents($avatar_url))) {
                return true;
            }
        } catch (Exception $e) {
            // No big deal, as we have a default avatar
        }

        return false;
    }
}
