<?php

namespace Tests\Feature\UserCRUD;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActingAsManagerTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->actingAsUser(Role::MANAGER);
    }

    public function test_can_create_user(): void
    {
        $userData = $this->generateUserData();
        $this->postJson(route('api.v1.users.store'), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $userData = $this->generateUserUpdateData($user);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertSuccessful();
        $this->assertUserHas($user, $userData);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $this->deleteJson(route('api.v1.users.destroy', $user))->assertSuccessful();
        $this->assertUserMissing($user);
    }

    public function test_can_fetch_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $this->getJson(route('api.v1.users.show', $user))->assertSuccessful();
    }

    public function test_can_fetch_all_users(): void
    {
        $this->getJson(route('api.v1.users.index'))->assertSuccessful();
    }

    public function test_cannot_delete_manager(): void
    {
        $manager = User::factory()->role(Role::MANAGER)->create();
        $this->deleteJson(route('api.v1.users.destroy', $manager))->assertForbidden();
        $this->assertUserHas($manager);
    }

    public function test_cannot_delete_admin(): void
    {
        $admin = User::factory()->role(Role::ADMIN)->create();
        $this->deleteJson(route('api.v1.users.destroy', $admin))->assertForbidden();
        $this->assertUserHas($admin);
    }

    public function test_cannot_update_manager(): void
    {
        $manager = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($manager);
        $this->patchJson(route('api.v1.users.update', $manager), $userData)->assertForbidden();
        $this->assertUserMissing($manager, $userData);
    }

    public function test_cannot_see_admins(): void
    {
        $admin = User::factory()->role(Role::ADMIN)->create();
        $this->getJson(route('api.v1.users.show', $admin))->assertForbidden();
    }

    public function test_can_promote_user_to_manager(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $userData = $this->generateUserUpdateData($user, Role::MANAGER);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertOk();
        $this->assertUserHas($user, ['role' => Role::MANAGER]);
    }

    public function test_cannot_promote_manager_to_admin(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($user, Role::ADMIN);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        $this->assertUserMissing($user, ['role' => Role::ADMIN]);
    }

    public function test_cannot_demote_manager_to_user(): void
    {
        $user = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserUpdateData($user, Role::USER);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        $this->assertUserHas($user, ['role' => Role::MANAGER]);
    }

    public function test_cannot_promote_self(): void
    {
        $user = $this->user;
        $userData = $this->generateUserDataForUpdate(Role::ADMIN);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        $this->assertUserHas($user, ['role' => Role::MANAGER]);
    }
}
