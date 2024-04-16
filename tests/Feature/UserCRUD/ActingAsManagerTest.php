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
        $this->postJson(route('users.store'), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('users.update', $user), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $this->deleteJson(route('users.destroy', $user))->assertSuccessful();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_fetch_user(): void
    {
        $user = User::factory()->role(Role::USER)->create();
        $this->getJson(route('users.show', $user))->assertSuccessful();
    }

    public function test_can_fetch_all_users(): void
    {
        $this->getJson(route('users.index'))->assertSuccessful();
    }

    public function test_cannot_delete_manager(): void
    {
        $manager = User::factory()->role(Role::MANAGER)->create();
        $this->deleteJson(route('users.destroy', $manager))->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $manager->id]);
    }

    public function test_cannot_delete_admin(): void
    {
        $admin = User::factory()->role(Role::ADMIN)->create();
        $this->deleteJson(route('users.destroy', $admin))->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_cannot_update_manager(): void
    {
        $manager = User::factory()->role(Role::MANAGER)->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('users.update', $manager), $userData)->assertForbidden();
        unset($userData['password']);
        $this->assertDatabaseMissing('users', $userData);
    }

    public function test_cannot_see_admins(): void
    {
        $admin = User::factory()->role(Role::ADMIN)->create();
        $this->getJson(route('users.show', $admin))->assertForbidden();
    }
}
