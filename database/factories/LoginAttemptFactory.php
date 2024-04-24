<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoginAttempt>
 */
class LoginAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'attempted_at' => $this->faker->dateTime,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'succeeded' => $this->faker->boolean,
        ];
    }

    public function forUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
            'identification' => $user->username,
        ]);
    }
}
