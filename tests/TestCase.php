<?php

namespace Tests;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected ?User $user = null;

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
    protected function generateUserData(Role $role = Role::USER): array
    {
        return [
            'email' => fake()->email,
            'password' => 'password',
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'date_of_birth' => fake()->date,
            'username' => fake()->userName,
            'role' => $role->value,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function generateUserUpdateData(User $user, ?Role $role = null): array
    {
        return [
            'email' => fake()->email,
            'password' => 'password',
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'date_of_birth' => fake()->date,
            'username' => $user->username,
            'role' => $role->value ?? $user->role->value,
        ];
    }

    protected function generateUserDataForUpdate(Role $role = Role::USER): array
    {
        $data = $this->generateUserData($role);
        $data['username'] = $this->user?->username;

        return $data;
    }

    protected function actingAsUser(Role $role = Role::USER): User
    {
        $user = User::factory()->role($role)->create();
        $this->actingAs($user, 'web');

        return $user;
    }

    protected function assertUserHas(User $user, array $structure = []): void
    {
        if (array_key_exists('password', $structure)) {
            unset($structure['password']);
        }

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => $user->username,
            ...$structure,
        ]);
    }

    protected function assertUserMissing(User $user, array $structure = []): void
    {
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'username' => $user->username,
            ...$structure,
        ]);
    }
}
