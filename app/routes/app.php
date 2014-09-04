<?php

Route::get('/', ['as' => 'home', 'before' => 'auth', function() {
	return Redirect::to('conferences');
}]);

Route::get('todo', ['as' => 'todo', 'before' => 'auth', function() {
	return View::make('todo');
}]);

/** Friends */
Route::group(['prefix' => 'friends', 'before' => 'auth'], function() {
	Route::get('/', ['as' => 'friends.index', function () {
		$friends = Auth::user()->friends;

		return View::make('index')
			->with('friends', $friends);
	}]);
});

/** Conferences */
// @todo: Move these into ConferencesController
Route::group(['prefix' => 'conferences', 'before' => 'auth'], function() {
	Route::get('/', ['as' => 'conferences.index', function() {
		$conferences = Auth::user()->conferences;

		return View::make('conferences.index')
			->with('conferences', $conferences);
	}]);

	Route::get('add', ['as' => 'conferences.create', function() {
		return View::make('conferences.add');
	}]);

	Route::post('add', ['as' => 'conference.store', function() {
		$conference = new \Confomo\Entities\Conference(Input::get());
		$conference->user_id = Auth::user()->id;
		$conference->save();

		return Redirect::route('conferences.index');
	}]);

	Route::get('{conference_id}', ['as' => 'conferences.show', 'before' => 'authConf', function($conference_id) {
		$conference = \Confomo\Entities\Conference::findOrFail($conference_id);
		$public_url = URL::to('/users/' . Auth::user()->username . '/conferences/' . $conference->id . '/');

		if ($conference->list_is_public && Auth::user()->username == '')
		{
			throw new Exception('User must have username to make conference public.');
		}

		return View::make('conferences.show')
			->with('conference', $conference)
			->with('public_url', $public_url);
	}]);

	Route::get('{conference_id}/edit', ['as' => 'conferences.edit', 'before' => 'authConf', function($conference_id) {
		$conference = \Confomo\Entities\Conference::findOrFail($conference_id);

		return View::make('conferences.edit')
			->with('conference', $conference);
	}]);

	Route::post('{conference_id}/edit', ['as' => 'conferences.update', 'before' => 'authConf', function($conference_id) {
		try
		{
			$conference = \Confomo\Entities\Conference::findOrFail($conference_id);
		}
		catch (Exception $e)
		{
			exit('Havent programmed this page yet.');
		}

		$conference->name = Input::get('name');
		$conference->list_is_public = Input::get('list_is_public');
		$conference->save();

		return Redirect::route('conferences.index');
	}]);
});

/** Public view */
Route::post("users/{user_slug}/conferences/{conference_id}/friends/suggested", 'Confomo\Http\Controllers\PublicUsersController@suggested');
Route::get('users/{user_slug}/conferences/{conference_id}', 'Confomo\Http\Controllers\PublicUsersController@show');
