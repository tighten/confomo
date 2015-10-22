<?php

Route::get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);

Route::get('dashboard', ['middleware' => 'auth', function () {
    return view('dashboard');
}]);

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::post('conferences/{conference}/new-friends', 'ConferenceNewFriendsController@store');
    Route::get('conferences/{conference}/new-friends', 'ConferenceNewFriendsController@index');
});

Route::get('auth', 'Auth\AuthController@authenticate');
Route::get('auth/callback', 'Auth\AuthController@handleTwitterCallback');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
