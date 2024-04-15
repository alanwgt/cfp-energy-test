<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'otp' => 'required_without:password|string',
            'password' => 'required_without:otp|string',
        ];
    }

    public function getEmail(): string
    {
        return $this->validated('email');
    }

    public function getOtp(): string
    {
        return $this->validated('otp');
    }

    public function getPassword(): string
    {
        return $this->validated('password');
    }

    public function hasOtp(): bool
    {
        return $this->has('otp');
    }

    public function hasPassword(): bool
    {
        return $this->has('password');
    }
}
