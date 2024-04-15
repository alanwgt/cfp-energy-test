<?php

namespace App\Services;

use App\Data\StoreUserData;
use App\Enum\AuthenticationMethod;
use App\Enum\Role;
use App\Exceptions\DomainLogicException;
use App\Exceptions\Http\UnauthorizedException;
use App\Models\User;

class AuthService
{
    public function getAuthenticationMethod(string $email): string
    {
        $user = User::query()
            ->where('email', $email)
            ->first();

        //        if ($user?->usesOtp()) {
        // TODO:
        // generate OTP and save to cache
        // send OTP to user
        //        }

        return $user?->authentication_method->value ?? 'password';
    }

    public function register(StoreUserData $userData): User
    {
        $user = new User();
        $user->email = $userData->email;
        $user->password = $userData->password;
        $user->authentication_method = $userData->usesOtp() ? AuthenticationMethod::OTP : AuthenticationMethod::PASSWORD;
        $user->first_name = $userData->first_name;
        $user->last_name = $userData->last_name;
        $user->phone_number = $userData->phone_number;
        $user->date_of_birth = $userData->date_of_birth;
        $user->username = $userData->username;
        $user->role = Role::USER;
        $user->save();

        return $user;
    }

    public function login(string $email, ?string $password, ?string $otp): void
    {
        if (! $password && ! $otp) {
            throw new DomainLogicException('Either password or OTP must be provided');
        }

        if ($password) {
            $this->loginWithPassword($email, $password);

            return;
        }

        // TODO:
        throw new \RuntimeException('Not implemented');
    }

    public function logout(): void
    {
        auth('web')->logout();
    }

    private function loginWithPassword(string $email, string $password): void
    {
        if (! auth()->attempt([
            'email' => $email,
            'password' => $password,
        ])) {
            throw new UnauthorizedException('Invalid credentials');
        }
    }
}
