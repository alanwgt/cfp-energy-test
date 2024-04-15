<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('auth.')
    ->prefix('auth')
    ->group(function () {
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::delete('/session', [SessionController::class, 'destroy'])
                    ->name('session.destroy');
            });

        Route::middleware('throttle:auth')
            ->group(function () {
                Route::post('/', [AuthController::class, 'store'])
                    ->name('store');

                Route::post('/session', [SessionController::class, 'store'])
                    ->name('session.store');

                Route::post('/authentication-method', [AuthController::class, 'authenticationMethod'])
                    ->name('authentication-method');
            });
    });

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);
    });
