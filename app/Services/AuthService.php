<?php

namespace App\Services;

use App\Exceptions\DomainLogicException;
use App\Exceptions\Http\UnauthorizedException;
use App\Models\LoginAttempt;
use App\Models\User;
use App\QueryBuilders\UserQueryBuilder;

class AuthService
{
    public function getAuthenticationMethod(string $identification): string
    {
        $user = User::query()
            ->whereIdentification($identification)
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
        auth('web')->login($user);
    }

    public function login(string $identification, ?string $password, ?string $otp): void
    {
        if (! $password && ! $otp) {
            throw new DomainLogicException('Either password or OTP must be provided');
        }

        $loginAttempt = new LoginAttempt();
        $loginAttempt->identification = $identification;
        $loginAttempt->ip_address = request()->ip();
        $loginAttempt->user_agent = request()->userAgent();
        $loginAttempt->succeeded = false;

        /** @var ?User $user */
        $user = User::query()
            ->whereIdentification($identification)
            ->first();

        if ($user) {
            $loginAttempt->user_id = $user->id;
        }

        if ($password) {
            try {
                $this->loginWithPassword($identification, $password);
            } catch (\Throwable $e) {
                $loginAttempt->save();

                throw $e;
            }

            $loginAttempt->succeeded = true;
            $loginAttempt->save();

            return;
        }

        $loginAttempt->save();
        // TODO:
        throw new \RuntimeException('Not implemented');
    }

    public function logout(): void
    {
        request()->session()->invalidate();
        auth()->logout();
    }

    private function loginWithPassword(string $identification, string $password): void
    {
        if (! auth()->attempt([
            'identification' => fn (UserQueryBuilder $query) => $query->whereIdentification($identification),
            'password' => $password,
        ])) {
            throw new UnauthorizedException('Invalid credentials');
        }
    }
}
