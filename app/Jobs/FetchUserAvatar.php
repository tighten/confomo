<?php

namespace App\Jobs;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\User;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;

class FetchUserAvatar extends Job implements SelfHandling
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param  \App\Friend $friend
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $details = app(TwitterOAuth::class)->get('users/show', ['screen_name' => $this->user->twitter_nickname]);
            $url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($this->user->avatar), @file_get_contents($url))) {
                return true;
            }
        } catch (Exception $e) {
            // No big deal, as we have a default avatar
        }

        return false;
    }
}
