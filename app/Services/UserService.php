<?php

namespace App\Services;

use App\Data\StoreUserData;
use App\Enum\AuthenticationMethod;
use App\Exceptions\Http\BadRequestException;
use App\Exceptions\Http\ForbiddenException;
use App\Models\User;
use Illuminate\Auth\Access\Gate;

class UserService
{
    public function upsert(StoreUserData $userData, ?User $user = null): User
    {
        // the user cannot change their username
        if ($user !== null && $user->username !== $userData->username) {
            throw new BadRequestException('Username cannot be changed');
        }

        if ($userData->authentication_method === AuthenticationMethod::PASSWORD && $user === null && empty($userData->password)) {
            throw new BadRequestException('Password is required when using password authentication');
        }

        // check if current user has permission to update the role
        if ($user !== null && $userData->role !== $user->role) {
            /** @var User $currentUser */
            $currentUser = request()->user();
            /** @var Gate $gate */
            $gate = \Gate::forUser($currentUser);
            $canUpdateRole = $gate->inspect('updateProperty', [$user, 'role']);
            if ($canUpdateRole->denied()) {
                throw new ForbiddenException($canUpdateRole->message() ?? '');
            }
        }

        $user ??= new User();
        $user->email = $userData->email;
        $user->username = $userData->username;
        $user->authentication_method = $userData->usesOtp() ? AuthenticationMethod::OTP : AuthenticationMethod::PASSWORD;
        $user->first_name = $userData->first_name;
        $user->last_name = $userData->last_name;
        $user->phone_number = $userData->phone_number;
        $user->date_of_birth = $userData->date_of_birth;
        $user->role = $userData->role;

        if (
            $userData->authentication_method === AuthenticationMethod::PASSWORD
            && filled($userData->password)
            && ! $this->isSamePassword($userData, $user)
        ) {
            $user->password = \Hash::make($userData->password);
        } elseif ($userData->authentication_method === AuthenticationMethod::OTP) {
            $user->password = null;
        }

        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    private function isSamePassword(StoreUserData $userData, ?User $user): bool
    {
        if ($user === null || ! $user->exists) {
            return false;
        }

        if ($userData->password === null) {
            throw new \RuntimeException('Password is required');
        }

        return \Hash::check($userData->password, $user->password);
    }
}
