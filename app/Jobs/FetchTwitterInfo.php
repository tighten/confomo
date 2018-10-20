<?php

namespace App\Jobs;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Tweeter;
use Exception;
use Illuminate\Support\Facades\Log;

class FetchTwitterInfo extends Job
{
    /**
     * @var \App\Tweeter
     */
    private $tweeter;

    /**
     * Create a new job instance.
     *
     * @param  \App\Tweeter $tweeter
     * @return void
     */
    public function __construct(Tweeter $tweeter)
    {
        $this->tweeter = $tweeter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TwitterOAuth $twitter)
    {
        try {
            $details = $twitter->get('users/show', ['screen_name' => $this->tweeter->username]);

            if (isset($details->errors)) {
                // @todo: Handle if it's a non-existent tweeter?
                Log::error($details->errors[0]->message);

                return false;
            }

            $this->tweeter->name = $details->name;
            $this->tweeter->location = $details->location;
            $this->tweeter->description = $details->description;

            if (array_has($details->entities, 'url')) {
                $this->tweeter->url = $details->url;
                $this->tweeter->url_display = $details->entities->url->urls[0]->display_url;
            }

            $this->tweeter->save();
            Log::info('Synced tweeter details for ' . $this->tweeter->username);

            $avatar_url = str_replace('_normal', '', $details->profile_image_url_https);

            if (@file_put_contents(public_path($this->tweeter->avatar), @file_get_contents($avatar_url))) {
                Log::info('Synced avatar for ' . $this->tweeter->username);

                return true;
            }
        } catch (Exception $e) {
            Log::error('Failed syncing avatar/details for ' . $this->tweeter->username . '; exception: ' . $e->getMessage());
            // No big deal, as we have a default avatar
        }

        Log::error('Failed syncing avatar for ' . $this->tweeter->username);

        return false;
    }
}
