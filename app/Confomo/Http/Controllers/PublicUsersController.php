<?php namespace Confomo\Http\Controllers;

use App;
use Confomo\Entities\Conference;
use Confomo\Entities\Friend;
use Confomo\Entities\User;
use Exception;
use Queue;
use Response;
use View;

class PublicUsersController extends BaseController
{
	/**
	 * Display the public page for this user
	 *
	 * @param  string  $username
	 * @param  int     $conference_id
	 * @return Response
	 */
	public function show($username, $conference_id)
	{
		$user = $this->getUser($username);

		$conference = Conference::findOrFail($conference_id);

		if ($conference->user_id != $user->id) {
			App::abort(404);
		}

		return View::make('users.publicShow')
			->with('conference', $conference)
			->with('user', $user);
	}

	/**
	 * Add suggested friends for this user
	 *
	 * @param  string $username
	 * @param  int    $conference_id
	 * @return string json
	 * @todo  Abstract this creation logic to share between this and the friendscontroller
	 */
	public function suggested($username, $conference_id)
	{
		$this->validateSuggested($_POST);

		$user = $this->getUser($username);

		$friend = new Friend([
			'twitter' => $_POST['twitter'],
			'type' => $_POST['type'] . '_suggested'
		]);
		$friend->user_id = $user->id;
		$friend->save();

		Queue::push(
			'Confomo\Queue\API\TwitterProfilePic',
			array(
				'twitter_handle' => $friend->twitter,
				'friend_id' => $friend->id
			)
		);

		return Response::json(['status' => 'success']);
	}

	/**
	 * Get the user for the current user based on username
	 *
	 * @param  username $username
	 * @return User
	 */
	protected function getUser($username)
	{
		try {
			return User
				::where('username', $username)
				->firstOrFail();
		} catch (Exception $e) {
			App::abort(404);
		}
	}

	/**
	 * Validate suggested post
	 *
	 * @param  array $post $_POST
	 * @throws Exception If Invalid post type
	 * @throws Exception If Invalid post property submitted
	 * @return boolean
	 */
	protected function validateSuggested($post)
	{
		// @todo Make a real validation lazy
		// Validate type
		if ( ! in_array($post['type'], ['new', 'old'])) {
			throw new Exception('Invalid post type');
		}

		foreach ($_POST as $key => $value) {
			if ( ! in_array($key, ['twitter', 'type'])) {
				throw new Exception('Invalid key ' . $key);
			}
		}

		return true;
	}

	// @todo: Allow turning on for each user (and creating username)
}
