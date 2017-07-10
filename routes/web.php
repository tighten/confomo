<?php

Route::get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });

    Route::get('conferences/{conference}', 'ConferencesController@show');
});

Route::get('local-login', 'Auth\LoginController@localLogin');
Route::get('auth', 'Auth\LoginController@authenticate');
Route::get('auth/callback', 'Auth\LoginController@handleTwitterCallback');
Route::get('auth/logout', 'Auth\LoginController@getLogout');
Route::get('avatar/{username}', 'AvatarController@show');
Route::get('conferences/{conferenceSlug}/introduce', 'ConferenceIntroductionController@index');
Route::post('api/conferences/{conferenceSlug}/introduction', 'ConferenceIntroductionController@store');
