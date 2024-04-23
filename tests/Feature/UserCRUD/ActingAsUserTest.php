<?php

namespace Tests\Feature\UserCRUD;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActingAsUserTest extends TestCase
{
    use InteractsWithSession;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->startSession();
        $this->user = $this->actingAsUser();
    }

    public function test_user_cannot_create_another_user(): void
    {
        $userData = $this->generateUserData();
        $this->postJson(route('api.v1.users.store'), $userData)->assertForbidden();
        $this->assertDatabaseMissing('users', $userData);
    }

    public function test_user_can_update_self(): void
    {
        $userData = $this->generateUserUpdateData($this->user);
        $this->patchJson(route('api.v1.users.update', $this->user), $userData)->assertSuccessful();
        $this->assertUserHas($this->user, $userData);
    }

    public function test_user_cannot_change_own_username(): void
    {
        $userData = $this->generateUserUpdateData($this->user);
        $userData['username'] = 'new-username';
        $this->patchJson(route('api.v1.users.update', $this->user), $userData)->assertBadRequest();
        $this->assertUserHas($this->user);
        $this->assertDatabaseMissing('users', ['id' => $this->user?->id, 'username' => 'new-username']);
    }

    public function test_user_cannot_update_another(): void
    {
        $user = User::factory()->create();
        $userData = $this->generateUserUpdateData($user);
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        $this->assertUserMissing($user, $userData);
    }

    public function test_user_can_delete_itself(): void
    {
        $this->deleteJson(route('api.v1.users.destroy', $this->user))->assertSuccessful();
        $this->assertUserMissing($this->user);
    }

    public function test_user_can_fetch_itself(): void
    {
        $this->getJson(route('api.v1.users.show', $this->user))->assertSuccessful();
    }

    public function test_cannot_change_own_role(): void
    {
        $userData = $this->generateUserUpdateData($this->user, Role::ADMIN);
        $this->patchJson(route('api.v1.users.update', $this->user), $userData)->assertForbidden();
        $this->assertUserHas($this->user, ['role' => $this->user?->role->value]);
    }
}
