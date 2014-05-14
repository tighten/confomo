<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GrabTwitterProfilePicsCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'twitter:grabpics';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Grab Twitter Profile Pics.';

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
	public function fire()
	{
		// @todo: Can we make this be null, not 0? ugh.
		foreach (Friend::where('twitter_id', 0)->get() as $friend) {
			Queue::push(
				'Confomo\Queue\API\TwitterProfilePic',
				array(
					'twitter_handle' => $friend->twitter,
					'friend_id' => $friend->id
				)
			);

			$this->info('Queued profile pull for @' . $friend->twitter);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
