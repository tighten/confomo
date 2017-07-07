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
    public function handle(TwitterOAuth $twitter)
    {
        try {
            $details = $twitter->get('users/show', ['screen_name' => $this->friend->username]);

            $this->friend->name = $details->name;
            $this->friend->location = $details->location;
            $this->friend->description = $details->description;

            if (array_has($details->entities, 'url')) {
                $this->friend->url = $details->url;
                $this->friend->url_display = $details->entities->url->urls[0]->display_url;
            }

            $this->friend->save();
            Log::info('Synced friend details for ' . $this->friend->username);

            $avatar_url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($this->friend->avatar), @file_get_contents($avatar_url))) {
                Log::info('Synced avatar for ' . $this->friend->username);
                return true;
            }
        } catch (Exception $e) {
            Log::error('Failed syncing avatar/details for ' . $this->friend->username . '; exception: ' . $e->getMessage());
            // No big deal, as we have a default avatar
        }

        Log::error('Failed syncing avatar/details for ' . $this->friend->username);
        return false;
    }
}
