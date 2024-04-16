<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(): JsonResponse
    {
        return response()->ok(UserResource::collection(User::get()));
    }

    public function store(StoreUserData $userData, UserService $userService): JsonResponse
    {
        $user = $userService->upsert($userData);

        return response()->ok(UserResource::make($user));
    }

    public function update(User $user, StoreUserData $userData, UserService $userService): JsonResponse
    {
        $user = $userService->upsert($userData, user: $user);

        return response()->ok(UserResource::make($user));
    }

    public function show(User $user): JsonResponse
    {
        return response()->ok(UserResource::make($user));
    }

    public function destroy(User $user, UserService $userService): Response
    {
        $userService->delete($user);

        return response()->noContent();
    }
}
