<?php

namespace App\Listeners;

use App\Events\FriendWasAdded;
use App\Jobs\FetchTwitterAvatar;
use Illuminate\Foundation\Bus\DispatchesJobs;

class FetchFriendAvatar
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
     * @param  FriendWasAdded  $event
     * @return void
     */
    public function handle(FriendWasAdded $event)
    {
        if (! file_exists(public_path($event->friend->avatar))) {
            $this->dispatch(new FetchTwitterAvatar($event->friend));
        }
    }
}
