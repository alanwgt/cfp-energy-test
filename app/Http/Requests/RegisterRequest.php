<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
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

    public function usesOtp(): bool
    {
        return ! $this->has('password');
    }
}
