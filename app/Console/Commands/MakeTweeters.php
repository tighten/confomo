<?php

namespace App\Console\Commands;

use App\Friend;
use App\Tweeter;
use Illuminate\Console\Command;

class MakeTweeters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:tweeters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Tweeters from Friends';

    /**
     * Create a new command instance.
     *
     * @return void
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
    public function handle()
    {
        // Ugh.. lost the other fields because I'm an idiot and deleted them before the migration
        Friend::all()->each(function ($friend) {
            Tweeter::create([
                'username' => $friend->username,
                'name' => $friend->name,
            ]);
        });
    }
}
