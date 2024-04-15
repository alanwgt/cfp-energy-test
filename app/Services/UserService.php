<?php

namespace App\Services;

use App\Data\StoreUserData;
use App\Enum\AuthenticationMethod;
use App\Enum\Role;
use App\Models\User;

class UserService
{
    public function upsert(StoreUserData $userData, Role $role = Role::USER, ?User $user = null): User
    {
        $user ??= new User();
        $user->email = $userData->email;
        $user->password = $userData->password;
        $user->authentication_method = $userData->usesOtp() ? AuthenticationMethod::OTP : AuthenticationMethod::PASSWORD;
        $user->first_name = $userData->first_name;
        $user->last_name = $userData->last_name;
        $user->phone_number = $userData->phone_number;
        $user->date_of_birth = $userData->date_of_birth;
        $user->username = $userData->username;
        $user->role = $role;
        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
