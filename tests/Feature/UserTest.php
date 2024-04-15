<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_unauthenticated_user_cannot_register(): void
    {
        $this->postJson(route('users.store'), $this->generateUserData())->assertUnauthorized();
    }
}
