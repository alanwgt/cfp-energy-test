<?php

namespace Tests\Feature;

use App\Enum\Role;
use App\Models\User;
use Tests\TestCase;

class ActingAsAdminTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsUser(Role::ADMIN);
    }

    public function test_can_create_another_user(): void
    {
        $userData = $this->generateUserData();
        $this->postJson(route('users.store'), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_cannot_create_user_with_invalid_data(): void
    {
        $this->postJson(route('users.store'), [
            'email' => 'invalid-email',
            'password' => 'short',
        ])->assertBadRequest();
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();
        $this->deleteJson(route('users.destroy', $user))->assertSuccessful();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('users.update', $user), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_created_user_without_password_uses_otp(): void
    {
        $userData = $this->generateUserData();
        $userData['password'] = null;
        $response = $this->postJson(route('users.store'), $userData)
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $response->json('data.id'),
            'authentication_method' => 'otp',
        ]);
    }
}
