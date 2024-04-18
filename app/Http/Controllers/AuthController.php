<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Requests\GetAuthenticationMethodRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\PreludeResource;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function check(): JsonResponse
    {
        return response()->ok(PreludeResource::make(auth()->user()));
    }

    public function method(GetAuthenticationMethodRequest $request, AuthService $authService): JsonResponse
    {
        return response()->ok([
            'authentication_method' => $authService->getAuthenticationMethod($request->getEmail()),
        ]);
    }

    public function signIn(LoginRequest $request, AuthService $authService): JsonResponse
    {
        $authService->login($request->getEmail(), $request->getPassword(), $request->getOtp());

        return response()->ok(PreludeResource::make(auth()->user()));
    }

    public function signUp(StoreUserData $request, UserService $userService, AuthService $authService): JsonResponse
    {
        $user = $userService->upsert($request);
        $authService->loginUser($user);

        return response()->ok([
            'ok' => true,
        ]);
    }

    public function signOut(AuthService $authService): Response
    {
        $authService->logout();

        return response()->noContent();
    }
}
