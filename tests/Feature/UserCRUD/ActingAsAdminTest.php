<?php

namespace Tests\Feature\UserCRUD;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActingAsAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsUser(Role::ADMIN);
    }

    public function test_can_create_another_user(): void
    {
        $userData = $this->generateUserData();
        $this->postJson(route('api.v1.users.store'), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_cannot_create_user_with_invalid_data(): void
    {
        $this->postJson(route('api.v1.users.store'), [
            'email' => 'invalid-email',
            'password' => 'short',
        ])->assertBadRequest();
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $this->deleteJson(route('api.v1.users.destroy', $user))->assertSuccessful();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_created_user_without_password_uses_otp(): void
    {
        $userData = $this->generateUserData();
        $userData['password'] = null;
        $response = $this->postJson(route('api.v1.users.store'), $userData)
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $response->json('data.id'),
            'authentication_method' => 'otp',
        ]);
    }

    public function test_cannot_update_another_admin(): void
    {
        $user = User::factory()->role(Role::ADMIN)->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        unset($userData['password']);
        $this->assertDatabaseMissing('users', $userData);
    }
}
