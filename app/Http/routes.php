<?php

Route::get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);

Route::get('dashboard', ['middleware' => 'auth', function () {
    return view('dashboard');
}]);

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'conferences'], function () {
        Route::post('{conference}/new-friends', 'ConferenceNewFriendsController@store');
        Route::get('{conference}/new-friends', 'ConferenceNewFriendsController@index');
        Route::post('{conference}/online-friends', 'ConferenceOnlineFriendsController@store');
        Route::get('{conference}/online-friends', 'ConferenceOnlineFriendsController@index');
    });
});

Route::get('auth', 'Auth\AuthController@authenticate');
Route::get('auth/callback', 'Auth\AuthController@handleTwitterCallback');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
