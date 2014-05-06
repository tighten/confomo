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

Route::get('/', function()
{
	$friends = Friend::all();
	return View::make('index')
		->with('friends', $friends);
});


Route::resource('friends', 'FriendsController');

/*

    $authority = App::make('authority');

    // If you added the alias to `app/config/app.php` then you can access Authority, from any Controller, View, or anywhere else in your Laravel app like so:
    if( Authority::can('create', 'User') ) {
        User::create(array(
            'username' => 'someuser@test.com'
        )); 
    }

 */
