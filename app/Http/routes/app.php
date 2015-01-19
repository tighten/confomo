<?php

Route::get('/', ['as' => 'home', 'before' => 'auth', function () {
    return Redirect::to('conferences');
}]);

/** Conferences */
Route::group(['prefix' => 'conferences', 'before' => 'auth'], function () {
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
