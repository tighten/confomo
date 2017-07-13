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

Route::group(['prefix' => 'api', 'namespace' => 'API', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'conferences'], function () {
        Route::get('/', 'ConferencesController@index');
        Route::post('/', 'ConferencesController@store');
        Route::delete('{conference}', 'ConferencesController@delete');
        Route::get('{conference}/new-friends', 'ConferenceNewFriendsController@index');
        Route::post('{conference}/new-friends', 'ConferenceNewFriendsController@store');
        Route::delete('{conference}/new-friends/{friend}', 'ConferenceNewFriendsController@delete');
        Route::get('{conference}/online-friends', 'ConferenceOnlineFriendsController@index');
        Route::get('{conference}/online-friends/{friend}', 'ConferenceOnlineFriendsController@show');
        Route::post('{conference}/online-friends', 'ConferenceOnlineFriendsController@store');
        Route::patch('{conference}/online-friends/{friend}', 'ConferenceOnlineFriendsController@update');
        Route::delete('{conference}/online-friends/{friend}', 'ConferenceOnlineFriendsController@delete');
    });
});

Route::get('local-login', 'Auth\LoginController@localLogin');
Route::get('auth', 'Auth\LoginController@authenticate');
Route::get('auth/callback', 'Auth\LoginController@handleTwitterCallback');
Route::get('auth/logout', 'Auth\LoginController@logout');
Route::get('avatar/{username}', 'AvatarController@show');
Route::get('conferences/{conferenceSlug}/introduce', 'ConferenceIntroductionController@index');
Route::post('api/conferences/{conferenceSlug}/introduction', 'ConferenceIntroductionController@store');
