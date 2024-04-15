<?php

namespace App\Data;

use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;
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
    ) {
    }

    public function usesOtp(): bool
    {
        return ! $this->password;
    }

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => ['sometimes', Password::defaults()],
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'phone_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'username' => 'required|string|min:3|unique:users,username',
        ];
    }
}
