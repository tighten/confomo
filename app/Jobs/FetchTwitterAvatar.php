<?php

namespace App\Jobs;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Friend;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;

class FetchTwitterAvatar extends Job implements SelfHandling
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
            $url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($this->friend->avatar), @file_get_contents($url))) {
                Log::info('Synced avatar for ' . $this->friend->username);
                return true;
            }
        } catch (Exception $e) {
            Log::error('Failed syncing avatar for ' . $this->friend->username);
            // No big deal, as we have a default avatar
        }

        return false;
    }
}
