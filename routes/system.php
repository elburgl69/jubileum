<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SourceController;

Route::group(
    ['middleware' => ['auth', 'can:system-user']],
    function () {
        // System routes in this group
        Route::resources(['sources' => SourceController::class]);

        // Route::get('/sources', [SourceController::class, 'index'])->name('sources.index');
    }
);
