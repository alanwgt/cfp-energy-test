<?php

namespace Tests;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * @param  string[]  $abilites
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null, array $abilites = []): self
    {
        Sanctum::actingAs($user, $abilites, $guard ?? 'sanctum');

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function generateUserData(): array
    {
        return [
            'email' => fake()->email,
            'password' => fake()->password(8),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'date_of_birth' => fake()->date,
            'username' => fake()->userName,
        ];
    }

    protected function actingAsUser(Role $role = Role::USER): UserContract
    {
        $user = User::factory()->role($role)->create();
        $this->actingAs($user);

        return $user;
    }
}
