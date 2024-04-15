<?php

namespace App\Http\Controllers;

use App\Exceptions\Http\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\PreludeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if ($request->hasOtp()) {
            // TODO:
            throw new \RuntimeException('Not implemented');
        } elseif (auth()->attempt($credentials)) {
            return response()->ok(PreludeResource::make([]));
        }

        throw new UnauthorizedException();
    }

    public function destroy(): Response
    {
        auth('web')->logout();

        return response()->noContent();
    }
}
