<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Resources\UserDetailedResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\QueryFilters\EmailFilter;
use App\QueryFilters\IdFilter;
use App\QueryFilters\NameFilter;
use App\QueryFilters\OrderBy;
use App\QueryFilters\QuickSearchFilter;
use App\QueryFilters\UsernameFilter;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
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
        /** @var User $user */
        $user = auth()->user();

        $query = User::query()
            ->whereCanView($user->role)
            ->where('id', '!=', $user->id);

        $users = app(Pipeline::class)
            ->send($query)
            ->through([
                OrderBy::class,
                NameFilter::class,
                EmailFilter::class,
                UsernameFilter::class,
                IdFilter::class,
                QuickSearchFilter::class,
            ])
            ->thenReturn();

        return response()->ok(UserResource::collection($users->paginate()));
    }

    public function store(StoreUserData $userData, UserService $userService): JsonResponse
    {
        $user = $userService->upsert($userData);

        return response()->ok(UserResource::make($user));
    }

    public function update(User $user, StoreUserData $userData, UserService $userService, AuthService $authService): JsonResponse
    {
        $user = $userService->upsert($userData, user: $user);

        // If the user is updating their own user, we need to re-login the user
        if ($user->is(auth()->user())) {
            $authService->loginUser($user);
        }

        return response()->ok(UserDetailedResource::make($user));
    }

    public function show(User $user): JsonResponse
    {
        return response()->ok(UserDetailedResource::make($user));
    }

    public function destroy(User $user, UserService $userService): Response
    {
        $userService->delete($user);

        return response()->noContent();
    }

    public function me(): JsonResponse
    {
        return response()->ok(UserDetailedResource::make(auth()->user()));
    }
}
