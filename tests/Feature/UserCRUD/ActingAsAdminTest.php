<?php

namespace Tests\Feature\UserCRUD;

use App\Enum\AuthenticationMethod;
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
        $this->user = $this->actingAsUser(Role::ADMIN);
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
        $user = User::factory()->role(Role::USER)->create();
        $this->deleteJson(route('api.v1.users.destroy', $user))->assertSuccessful();
        $this->assertUserMissing($user);
    }

    public function test_can_delete_manager(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $this->deleteJson(route('api.v1.users.destroy', $user))->assertSuccessful();
        $this->assertUserMissing($user);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($user);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertSuccessful();
        $this->assertUserHas($user, $userData);
    }

    public function test_can_create_account_with_otp(): void
    {
        $userData = $this->generateUserData();
        $userData['password'] = null;
        $userData['authentication_method'] = AuthenticationMethod::OTP->value;
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

    public function test_can_promote_to_admin(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($user, Role::ADMIN);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertOk();
        $this->assertUserHas($user, ['role' => Role::ADMIN]);
    }

    public function test_cannot_update_own_role(): void
    {
        $userData = $this->generateUserUpdateData($this->user, Role::MANAGER);
        $this->patchJson(route('api.v1.users.update', $this->user), $userData)->assertForbidden();
        $this->assertUserHas($this->user, ['role' => Role::ADMIN]);
    }

    public function test_can_demote_manager(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($user, Role::USER);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertOk();
        $this->assertUserHas($user, ['role' => Role::USER]);
    }
}
