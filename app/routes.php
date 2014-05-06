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

Route::get('SEEDSUCKA', function() {
	User::create([
		'username' => 'matt',
		'password' => Hash::make('password')
	]);
});

Route::get('login', ['as' => 'login', function() {
	return View::make('sessions.login');
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

Route::resource('friends', 'FriendsController');
