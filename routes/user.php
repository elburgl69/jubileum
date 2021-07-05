<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;

Route::group(
    ['middleware' => ['auth']],
    function () {
        // user routes below...
        //Route::get('/users/profiel', 'UserController@profiel')->name('users.profiel');


    }
);

Route::group(
    ['middleware' => ['jubileum']],
    function () {
        // Jubileum protected routes here...
        Route::get('/subscribe/{token}/{email}/{event}', [SubscribeController::class, 'index'])
            ->name('subscribe');
    }
);
