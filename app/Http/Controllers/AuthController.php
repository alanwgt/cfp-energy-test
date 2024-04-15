<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Requests\GetAuthenticationMethodRequest;
use App\Services\AuthService;
use App\Services\UserService;
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

    public function store(StoreUserData $request, UserService $userService, AuthService $authService): JsonResponse
    {
        $user = $userService->upsert($request);
        $authService->loginUser($user);

        return response()->ok([
            'ok' => true,
        ]);
    }
}
