<?php
Route::group(['before' => 'auth', 'prefix' => 'api'], function () {
    Route::group(['prefix' => 'conferences/{conference_id}', 'before' => 'authConf'], function ($conference_id) {
        Route::resource('friends', 'API\FriendsController');
    });
});
