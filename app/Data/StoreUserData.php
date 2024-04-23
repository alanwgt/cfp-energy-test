<?php

namespace App\Data;

use App\Enum\AuthenticationMethod;
use App\Enum\Role;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StoreUserData extends Data
{
    public function __construct(
        public string $email,
        public ?string $password,
        public string $first_name,
        public string $last_name,
        public string $phone_number,
        public string $date_of_birth,
        public string $username,
        public Role $role,
        public AuthenticationMethod $authentication_method,
    ) {
    }

    public function usesOtp(): bool
    {
        return $this->authentication_method === AuthenticationMethod::OTP;
    }

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        $isUpdating = request()->route('user') !== null;

        return [
            'email' => ['required', 'email', new Unique('users', ignore: $isUpdating ? new RouteParameterReference('user', 'email') : null, ignoreColumn: 'email')],
            'password' => ['sometimes', 'nullable', Password::defaults()],
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'phone_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'username' => ['required', 'string', 'min:3', new Unique('users', ignore: $isUpdating ? new RouteParameterReference('user', 'username') : null, ignoreColumn: 'username')],
            'role' => ['required', new Enum(Role::class)],
            'authentication_method' => ['required', new Enum(AuthenticationMethod::class)],
        ];
    }
}
