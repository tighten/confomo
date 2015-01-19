<?php

Route::get('login', ['as' => 'login', 'before' => 'guest', 'uses' => 'UsersController@login']);

Route::post('login', ['before' => 'guest', 'uses' => 'UsersController@postLogin']);

Route::get('logout', ['as' => 'logout', 'uses' => 'UsersController@logout']);

Route::get('account', ['as' => 'account', 'before' => 'auth', 'uses' => 'UsersController@account']);

Route::post('account', ['as' => 'update_account', 'before' => 'auth', 'uses' => 'UsersController@postAccount']);

Route::get('signup', ['as' => 'signup', 'before' => 'guest', 'uses' => 'UsersController@signup']);

Route::post('signup', ['before' => 'guest', 'uses' => 'UsersController@postSignup']);
