<?php

namespace Database\Seeders;

use App\Enum\Role;
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

        User::factory()
            ->role(Role::ADMIN)
            ->create([
                'email' => 'contact@cgp.energy',
                'first_name' => 'CFP',
                'last_name' => 'Energy',
                'username' => 'cfpenergy',
                'date_of_birth' => '2006-01-01',
                'phone_number' => '+44 20 7348 3500',
            ]);
    }
}
