<?php

class PublicUsersController extends \BaseController
{
	/**
	 * Display the public page for this user
	 *
	 * @param  string  $username
	 * @return Response
	 */
	public function show($username)
	{
		$user = $this->getUser($username);

		return View::make('users.publicShow')
			->with('user', $user);
	}

	/**
	 * Add suggested friends for this user
	 *
	 * @param  string $username
	 * @return string json
	 */
	public function suggested($username)
	{
		$this->validateSuggested($_POST);

		$user = $this->getUser($username);

		$friend = new Friend([
			'twitter' => $_POST['twitter'],
			'type' => $_POST['type'] . '_suggested'
		]);
		$friend->user_id = $user->id;
		$friend->save();

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
				->where('public_list', true)
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