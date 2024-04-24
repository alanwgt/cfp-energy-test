<?php

use App\Http\Controllers\AuthController;

Route::prefix('/auth')
    ->name('auth.')
    ->group(function () {
        Route::middleware('throttle:10,1')
            ->group(function () {
                Route::post('/sign-in', [AuthController::class, 'signIn'])
                    ->name('sign-in');

                Route::post('/sign-up', [AuthController::class, 'signUp'])
                    ->name('sign-up');

                Route::post('/method', [AuthController::class, 'method'])
                    ->name('authentication-method');
            });

        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::get('/check', [AuthController::class, 'check'])
                    ->name('check');
            });

        Route::middleware('auth:web')->post('/sign-out', [AuthController::class, 'signOut'])
            ->name('sign-out');
    });
