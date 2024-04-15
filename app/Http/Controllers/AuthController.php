<?php

namespace App\Http\Controllers;

use App\Enum\AuthenticationMethod;
use App\Enum\Role;
use App\Http\Requests\GetAuthenticationMethodRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function authenticationMethod(GetAuthenticationMethodRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('email', $request->getEmail())
            ->first();

        //        if ($user?->usesOtp()) {
        // TODO:
        // generate OTP and save to cache
        // send OTP to user
        //        }

        return response()->ok([
            'authentication_method' => $user?->authentication_method ?? 'password', // we don't want to leak information about whether the user exists
        ]);
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->email = $request->validated('email');
        $user->password = $request->usesOtp() ? null : $request->validated('password');
        $user->authentication_method = $request->usesOtp() ? AuthenticationMethod::OTP : AuthenticationMethod::PASSWORD;
        $user->first_name = $request->validated('first_name');
        $user->last_name = $request->validated('last_name');
        $user->phone_number = $request->validated('phone_number');
        $user->date_of_birth = $request->validated('date_of_birth');
        $user->username = $request->validated('username');
        $user->role = Role::USER;
        $user->save();

        auth()->login($user);

        return response()->ok([
            'ok' => true,
        ]);
    }
}
