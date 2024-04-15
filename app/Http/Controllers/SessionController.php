<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\PreludeResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SessionController extends Controller
{
    public function store(LoginRequest $request, AuthService $authService): JsonResponse
    {
        $authService->login($request->getEmail(), $request->getPassword(), $request->getOtp());

        return response()->ok(PreludeResource::make([]));
    }

    public function destroy(AuthService $authService): Response
    {
        $authService->logout();

        return response()->noContent();
    }
}
