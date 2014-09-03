<?php
// Move to user controller

Route::get('login', ['as' => 'login', 'before' => 'guest', function() {
	return View::make('users.login');
}]);

Route::get('account', ['as' => 'account', 'before' => 'auth', function() {
	return View::make('users.edit')
		->with('user', Auth::user());
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
	// Surprise, validating in controller = ugly and un-DRY @todo
	$validator = Validator::make(
		Input::all(),
		[
			'email' => 'required|min:5|email|unique:users',
			'password' => 'required|min:5',
			'username' => 'min:3|unique:users|alpha_dash'
		]
	);

	if ($validator->fails())
	{
		return Redirect::route('signup')
			->with('flash_error', 'Sorry, but there was a problem signing you up.')
			->withErrors($validator)
			->withInput();
	}

	$user = \Confomo\Entities\User::create([
		'email' => Input::get('email'),
		'password' => Hash::make(Input::get('password'))
	]);

	if (Auth::attempt([
		'email' => Input::get('email'),
		'password' => Input::get('password'),
		'username' => Input::get('username')
	])) {
		return Redirect::route('home')
			->with('flash_notice', 'You have successfully created a user account.');
	}

	return Redirect::route('signup')
		->with('flash_error', 'Sorry, but there was a problem signing you up.')
		->withInput();
}]);

Route::post('account', ['as' => 'update_account', 'before' => 'auth', function() {
	$current_user = Auth::user();

	// Surprise, validating in controller = ugly and un-DRY @todo
	$validator = Validator::make(
		Input::all(),
		[
			'email' => 'required|min:5|email|unique:users,email,' . $current_user->id,
			'username' => 'min:3|alpha_dash|unique:users,username,' . $current_user->id
		]
	);

	if ($validator->fails())
	{
		return Redirect::route('account')
			->with('flash_error', 'Sorry, but there was a problem with your edit.')
			->withErrors($validator)
			->withInput();
	}

	if (Input::get('password') != '')
	{
		$current_user->password = Hash::make(Input::get('password'));
	}

	$current_user->email = Input::get('email');
	$current_user->username = Input::get('username');

	$current_user->save();

	return Redirect::route('account');
}]);
