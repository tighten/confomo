<?php

Route::get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);
