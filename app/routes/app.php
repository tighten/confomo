<?php

Route::get('/', ['as' => 'home', 'before' => 'auth', function () {
    return Redirect::to('conferences');
}]);

//
//Route::get('/xdebug', function ()
//{
//	$a = array();
//
//	echo 'test';
//});

/** Conferences */
Route::group(['prefix' => 'conferences', 'before' => 'auth'], function () {
    Route::get('/', ['as' => 'conferences.index', 'uses' => 'Confomo\Http\Controllers\ConferencesController@index']);

    Route::get('add', ['as' => 'conferences.create', 'uses' => 'Confomo\Http\Controllers\ConferencesController@create']);

    Route::post('add', ['as' => 'conference.store', 'uses' => 'Confomo\Http\Controllers\ConferencesController@store']);

    Route::get('{conference_id}', ['as' => 'conferences.show', 'before' => 'authConf', 'uses' => 'Confomo\Http\Controllers\ConferencesController@show']);

    Route::get('{conference_id}/edit', ['as' => 'conferences.edit', 'before' => 'authConf', 'uses' => 'Confomo\Http\Controllers\ConferencesController@edit']);

    Route::post('{conference_id}/edit', ['as' => 'conferences.update', 'before' => 'authConf', 'uses' => 'Confomo\Http\Controllers\ConferencesController@update']);
});

/** Public view */
Route::post("users/{user_slug}/conferences/{conference_id}/friends/suggested", 'Confomo\Http\Controllers\PublicUsersController@suggested');

Route::get('users/{user_slug}/conferences/{conference_id}', 'Confomo\Http\Controllers\PublicUsersController@show');
