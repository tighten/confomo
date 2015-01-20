<?php
/* API */
Route::group(['before' => 'auth', 'prefix' => 'api'], function () {
    Route::group(['prefix' => 'conferences/{conference_id}', 'before' => 'authConf'], function ($conference_id) {
        Route::resource('friends', 'API\FriendsController');
    });
});

/* USER */
Route::get('login', ['as' => 'login', 'before' => 'guest', 'uses' => 'UsersController@login']);

Route::post('login', ['before' => 'guest', 'uses' => 'UsersController@postLogin']);

Route::get('logout', ['as' => 'logout', 'uses' => 'UsersController@logout']);

Route::get('account', ['as' => 'account', 'before' => 'auth', 'uses' => 'UsersController@account']);

Route::post('account', ['as' => 'update_account', 'before' => 'auth', 'uses' => 'UsersController@postAccount']);

Route::get('signup', ['as' => 'signup', 'before' => 'guest', 'uses' => 'UsersController@signup']);

Route::post('signup', ['before' => 'guest', 'uses' => 'UsersController@postSignup']);

/* APP */
Route::get('/', ['as' => 'home', 'before' => 'auth', function () {
    return Redirect::to('conferences');
}]);

/** Conferences */
Route::group(['prefix' => 'conferences', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'conferences.index', 'uses' => 'ConferencesController@index']);

    Route::get('add', ['as' => 'conferences.create', 'uses' => 'ConferencesController@create']);

    Route::post('add', ['as' => 'conference.store', 'uses' => 'ConferencesController@store']);

    Route::get('{conference_id}', ['as' => 'conferences.show', 'before' => 'authConf', 'uses' => 'ConferencesController@show']);

    Route::get('{conference_id}/edit', ['as' => 'conferences.edit', 'before' => 'authConf', 'uses' => 'ConferencesController@edit']);

    Route::post('{conference_id}/edit', ['as' => 'conferences.update', 'before' => 'authConf', 'uses' => 'ConferencesController@update']);
});

/** Public view */
Route::post("users/{user_slug}/conferences/{conference_id}/friends/suggested", 'PublicUsersController@suggested');

Route::get('users/{user_slug}/conferences/{conference_id}', 'PublicUsersController@show');
