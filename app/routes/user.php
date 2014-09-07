<?php

Route::get('login', ['as' => 'login', 'before' => 'guest', 'uses' => 'Confomo\Http\Controllers\UsersController@login']);

Route::post('login', ['before' => 'guest', 'uses' => 'Confomo\Http\Controllers\UsersController@postLogin']);

Route::get('logout', ['as' => 'logout', 'uses' => 'Confomo\Http\Controllers\UsersController@logout']);

Route::get('account', ['as' => 'account', 'before' => 'auth', 'uses' => 'Confomo\Http\Controllers\UsersController@account']);

Route::post('account', ['as' => 'update_account', 'before' => 'auth', 'uses' => 'Confomo\Http\Controllers\UsersController@postAccount']);

Route::get('signup', ['as' => 'signup', 'before' => 'guest', 'uses' => 'Confomo\Http\Controllers\UsersController@signup']);

Route::post('signup', ['before' => 'guest', 'uses' => 'Confomo\Http\Controllers\UsersController@postSignup']);
