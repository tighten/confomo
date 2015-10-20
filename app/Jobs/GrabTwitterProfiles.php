<?php

namespace App\Jobs;

use App\Friend;
use App\Jobs\Job;
use App\Jobs\PullTwitterUser;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Queue;

class GrabTwitterProfiles extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $this->info('Looking for any Friends with no pulled Twitter profile...');

        foreach (Friend::where('twitter_id', 0)->get() as $friend) {
            exit('todo: Figure out if we\'re pushing correctly for modern jobs; this was just copied from old app');
            Queue::push(
                PullTwitterUser::class,
                [
                    'twitterHandle' => $friend->twitter,
                    'friendId' => $friend->id
                ]
            );

            $this->info('Queued profile pull for @' . $friend->twitter);
        }

        $this->info('Done.');
    }
}
