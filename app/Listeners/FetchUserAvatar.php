<?php

namespace App\Listeners;

use App\Events\UserWasAdded;
use App\Jobs\FetchUserAvatar as FetchJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class FetchUserAvatar
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasAdded  $event
     * @return void
     */
    public function handle(UserWasAdded $event)
    {
        if (! file_exists(public_path($event->user->avatar))) {
            $this->dispatch(new FetchJob($event->user));
        }
    }
}
