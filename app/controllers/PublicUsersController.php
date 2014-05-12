<?php

class PublicUsersController extends \BaseController
{
	/**
	 * Display the public page for this user
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		try {
			$user = User
				::where('username', $slug)
				->where('public_list', true)
				->firstOrFail();
		} catch (Exception $e) {
			App::abort(404);
		}

		return View::make('users.publicShow')
			->with('user', $user);
	}

	// @todo: Allow suggesting
	// @todo: Allow turning on for each user (and creating username)
}