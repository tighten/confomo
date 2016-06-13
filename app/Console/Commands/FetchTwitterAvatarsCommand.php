<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Jobs\FetchTwitterAvatar;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Friend;

class FetchTwitterAvatarsCommand extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:fetch-avatars {--only-missing : Fetch only avatars that are missing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Twitter avatars for conference friends.';

    /**
     * Twitter OAuth client.
     *
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    private $twitter;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TwitterOAuth $twitter)
    {
        parent::__construct();

        $this->twitter = $twitter;
    }

    /**
     * Sort distinct Friend usernames, fetching any avatars we don't already
     * have cached first, then followed by any others that we are syncing.
     *
     * @return void
     */
    public function handle()
    {
        $friends = Friend::select('username')->distinct()->get();

        if ($this->option('only-missing')) {
            $friends = $friends->filter(function ($friend) {
                return ! file_exists(public_path($friend->avatar));
            });
        } else {
            $friends = $friends->sortByDesc(function ($friend) {
                return ! file_exists(public_path($friend->avatar));
            });
        }

        $friends->each(function ($friend) {
            $this->dispatch(new FetchTwitterAvatar($friend));
        });
    }
}
