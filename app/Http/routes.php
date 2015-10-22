<?php

Route::get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);

Route::get('dashboard', ['middleware' => 'auth', function () {
    return view('dashboard');
}]);

Route::group(['prefix' => 'api', 'namespace' => 'API', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'conferences'], function () {
        Route::get('/', 'ConferencesController@index');
        Route::post('/', 'ConferencesController@store');
        Route::delete('{conference}', 'ConferencesController@delete');

        Route::post('{conference}/new-friends', 'ConferenceNewFriendsController@store');
        Route::get('{conference}/new-friends', 'ConferenceNewFriendsController@index');

        Route::post('{conference}/online-friends', 'ConferenceOnlineFriendsController@store');
        Route::get('{conference}/online-friends', 'ConferenceOnlineFriendsController@index');
        Route::get('{conference}/online-friends/{friend}', 'ConferenceOnlineFriendsController@show');
        Route::patch('{conference}/online-friends/{friend}', 'ConferenceOnlineFriendsController@update');
    });
});

Route::get('local-login', 'Auth\AuthController@localLogin');
Route::get('auth', 'Auth\AuthController@authenticate');
Route::get('auth/callback', 'Auth\AuthController@handleTwitterCallback');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
