<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Requests\GetAuthenticationMethodRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function authenticationMethod(GetAuthenticationMethodRequest $request, AuthService $authService): JsonResponse
    {
        return response()->ok([
            'authentication_method' => $authService->getAuthenticationMethod($request->getEmail()),
        ]);
    }

    public function store(StoreUserData $request, AuthService $authService): JsonResponse
    {
        $user = $authService->register($request);
        auth()->login($user);

        return response()->ok([
            'ok' => true,
        ]);
    }
}
