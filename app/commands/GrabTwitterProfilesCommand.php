<?php

use Illuminate\Console\Command;

/**
 * Class GrabTwitterProfilesCommand
 *
 * Grab Twitter profiles for any friends with no linked Twitter profile
 */
class GrabTwitterProfilesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twitter:grabprofiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab Twitter Profiles.';

    /**
     * Create a new command instance.
     *
     * @return self
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        foreach (Friend::where('twitter_id', 0)->get() as $friend) {
            Queue::push(
                'Confomo\Twitter\SyncProfile',
                array(
                    'twitterHandle' => $friend->twitter,
                    'friendId' => $friend->id
                )
            );

            $this->info('Queued profile pull for @' . $friend->twitter);
        }
    }
}
