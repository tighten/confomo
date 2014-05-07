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
	$friends = Auth::user()->friends;

	return View::make('index')
		->with('friends', $friends);
}]);

Route::get('login', ['as' => 'login', 'before' => 'guest', function() {
	return View::make('users.login');
}]);

Route::post('login', ['before' => 'guest', function() {
	$user = array(
		'email' => Input::get('email'),
		'password' => Input::get('password')
	);

	if (Auth::attempt($user)) {
		return Redirect::route('home')
			->with('flash_notice', 'You are successfully logged in.');
	}

	return Redirect::route('login')
		->with('flash_error', 'Your email/password combination was incorrect.')
		->withInput();
}]);

Route::get('logout', ['as' => 'logout', function() {
	Auth::logout();
	return Redirect::route('home');
}]);

Route::get('signup', ['as' => 'signup', 'before' => 'guest', function() {
	return View::make('users.create');
}]);

Route::post('signup', ['before' => 'guest', function() {
	// @todo: send verification email
	// @todo: timeouts/rate limiting
	$validator = Validator::make(
		Input::all(),
		[
			'email' => 'required|min:5|email|unique:users',
			'password' => 'required|min:5'
		]
	);

	if ($validator->fails())
	{
		return Redirect::route('signup')
			->with('flash_error', 'Sorry, but there was a problem signing you up.')
			->withErrors($validator)
			->withInput();
	}

	$user = User::create([
		'email' => Input::get('email'),
		'password' => Hash::make(Input::get('password'))
	]);

	if (Auth::attempt([
		'email' => Input::get('email'),
		'password' => Input::get('password')
	])) {
		return Redirect::route('home')
			->with('flash_notice', 'You have successfully created a user account.');
	}

	return Redirect::route('signup')
		->with('flash_error', 'Sorry, but there was a problem signing you up.')
		->withInput();
}]);

Route::group(array('before' => 'auth'), function()
{
	Route::resource('friends', 'FriendsController');
});
