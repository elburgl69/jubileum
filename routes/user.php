<?php

use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['auth']],
    function () {
        // user routes below...
        //Route::get('/users/profiel', 'UserController@profiel')->name('users.profiel');
    }
);