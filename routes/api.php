<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'conferences', 'middleware' => 'auth:api|bindings'], function () {
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
