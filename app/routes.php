<?php

if (isset($_SERVER['HTTP_HOST']) && false !== stripos($_SERVER['HTTP_HOST'], 'm347.co')) {
	header('Location: http://confomo.com/', true, 301);
}

Route::get('/', ['as' => 'home', 'before' => 'auth', function() {
	$friends = Auth::user()->friends;

	return View::make('index')
		->with('friends', $friends);
}]);

Route::group(array('before' => 'auth'), function()
{
	Route::resource('friends', 'FriendsController');
});

Route::post("users/{user_slug}/friends/suggested", 'PublicUsersController@suggested');
Route::get('users/{user_slug}', 'PublicUsersController@show');

// Move to user controller

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
