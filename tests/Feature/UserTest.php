<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_execute_user_actions(): void
    {
        $this->getJson(route('users.index'))->assertUnauthorized();
        $this->getJson(route('users.show', 1))->assertUnauthorized();
        $this->postJson(route('users.store'), $this->generateUserData())->assertUnauthorized();
        $this->patchJson(route('users.update', 1), $this->generateUserData())->assertUnauthorized();
        $this->deleteJson(route('users.destroy', 1))->assertUnauthorized();
    }
}
