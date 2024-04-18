<?php

use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);
    });
