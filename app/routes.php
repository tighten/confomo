<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'before' => 'auth', function() {
//	$friends = Friend::all();
	$friends = Auth::user()->friends;
	return View::make('index')
		->with('friends', $friends);
}]);

// Route::get('SEEDSUCKA', function() {
	// User::create([
		// 'username' => 'matt',
		// 'password' => Hash::make('password')
	// ]);
// });

Route::get('login', ['as' => 'login', function() {
	return View::make('users.login');
}]);

Route::post('login', function() {
	$user = array(
		'username' => Input::get('username'),
		'password' => Input::get('password')
	);

	if (Auth::attempt($user)) {
		return Redirect::route('home')
			->with('flash_notice', 'You are successfully logged in.');
	}

	return Redirect::route('login')
		->with('flash_error', 'Your username/password combination was incorrect.')
		->withInput();
});

Route::get('logout', ['as' => 'logout', function() {
	Auth::logout();
	return Redirect::route('home');
}]);

Route::get('signup', ['as' => 'signup', function() {
	if ( ! Auth::guest()) {
		return Redirect::route('home');
	}

	return View::make('users.create');
}]);

Route::post('signup', function() {
	if ( ! Auth::guest()) {
		return Redirect::route('home');
	}

	// @todo: Verify username uniqueness
	// @todo: collect email and send verification email
	// @todo: timeouts/rate limiting
	$user = User::create([
		'username' => Input::get('username'),
		'password' => Hash::make(Input::get('password'))
	]);

	if (Auth::attempt([
		'username' => Input::get('username'),
		'password' => Input::get('password')
	])) {
		return Redirect::route('home')
			->with('flash_notice', 'You have successfully created a user account.');
	}

	return Redirect::route('signup')
		->with('flash_error', 'Sorry, but there was a problem signing you up.')
		->withInput();
});

Route::resource('friends', 'FriendsController');
