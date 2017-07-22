<?php

namespace App\Console\Commands;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Jobs\FetchTwitterInfo;
use App\Tweeter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class FetchTwitterInfoCommand extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:fetch-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Twitter info for conference friends.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Tweeter::where('updated_at', '<', Carbon::now()->subDay())->get()->each(function ($tweeter) {
            $this->dispatch(new FetchTwitterInfo($tweeter));
        });
    }
}
