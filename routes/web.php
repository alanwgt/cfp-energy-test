<?php

use App\Services\AuthService;
use Illuminate\Support\Facades\Route;

Route::get('/accept-invite/{token}', function (string $token, AuthService $authService) {
    $authService->acceptAdminInvite($token);

    return redirect()->to('/');
})->name('accept-invite');

Route::fallback(function () {
    return view('app');
});
