<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->create()
            ->each(function (User $user) {
                $user->loginAttempts()->saveMany(
                    \App\Models\LoginAttempt::factory(fake()->numberBetween(0, 25))
                        ->forUser($user->getKey())
                        ->create()
                );
            });
    }
}
