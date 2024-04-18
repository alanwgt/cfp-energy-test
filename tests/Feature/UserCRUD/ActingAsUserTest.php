<?php

namespace Tests\Feature\UserCRUD;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActingAsUserTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->actingAsUser();
    }

    public function test_user_cannot_create_another_user(): void
    {
        $userData = $this->generateUserData();
        $this->postJson(route('api.v1.users.store'), $userData)->assertForbidden();
        unset($userData['password']);
        $this->assertDatabaseMissing('users', $userData);
    }

    public function test_user_can_update_itself(): void
    {
        $userData = $this->generateUserData();
        $this->patchJson(route('api.v1.users.update', $this->user), $userData)->assertSuccessful();
        unset($userData['password']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_user_cannot_update_another_user(): void
    {
        $user = User::factory()->create();
        $userData = $this->generateUserData();
        $this->patchJson(route('api.v1.users.update', $user), $userData)->assertForbidden();
        unset($userData['password']);
        $this->assertDatabaseMissing('users', $userData);
    }

    public function test_user_can_delete_itself(): void
    {
        $this->deleteJson(route('api.v1.users.destroy', $this->user))->assertSuccessful();
        $this->assertDatabaseMissing('users', ['id' => $this->user?->id]);
    }

    public function test_user_can_fetch_itself(): void
    {
        $this->getJson(route('api.v1.users.show', $this->user))->assertSuccessful();
    }
}
