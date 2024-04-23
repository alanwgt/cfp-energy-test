<?php

use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('users/me', [UserController::class, 'me'])->name('users.me');
        Route::apiResource('users', UserController::class);
    });
