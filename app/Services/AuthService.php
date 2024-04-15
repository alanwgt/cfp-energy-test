<?php

namespace App\Services;

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

    public function loginUser(User $user): void
    {
        auth()->login($user);
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
