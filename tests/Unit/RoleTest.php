<?php

namespace Tests\Unit;

use App\Enum\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function test_role_levels(): void
    {
        $this->assertTrue(Role::ADMIN->isGreaterThan(Role::MANAGER));
        $this->assertTrue(Role::ADMIN->isGreaterThan(Role::USER));
        $this->assertTrue(Role::MANAGER->isGreaterThan(Role::USER));
        $this->assertFalse(Role::USER->isGreaterThan(Role::ADMIN));
    }

    public function test_lower_roles_are_not_greater_than_higher_roles(): void
    {
        $this->assertFalse(Role::USER->isGreaterThan(Role::USER));
        $this->assertFalse(Role::USER->isGreaterThan(Role::MANAGER));
        $this->assertFalse(Role::USER->isGreaterThan(Role::ADMIN));
        $this->assertFalse(Role::MANAGER->isGreaterThan(Role::MANAGER));
        $this->assertFalse(Role::MANAGER->isGreaterThan(Role::ADMIN));
        $this->assertFalse(Role::ADMIN->isGreaterThan(Role::ADMIN));
    }
}
