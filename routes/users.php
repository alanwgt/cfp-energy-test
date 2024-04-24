<?php

use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('users/me', [UserController::class, 'me'])->name('users.me');
        Route::get('users/{user}/login-attempts', [UserController::class, 'loginAttempts'])->name('users.login-attempts');
        Route::apiResource('users', UserController::class);
    });
