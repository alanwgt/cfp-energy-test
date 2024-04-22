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

    public function test_allowed_roles_should_include_all_lower_roles(): void
    {
        $this->assertContains(Role::USER->value, Role::ADMIN->getAllowedRoles());
        $this->assertContains(Role::MANAGER->value, Role::ADMIN->getAllowedRoles());
        $this->assertContains(Role::USER->value, Role::MANAGER->getAllowedRoles());
    }

    public function test_allowed_roles_should_not_contain_current_role(): void
    {
        $this->assertNotContains(Role::ADMIN->value, Role::ADMIN->getAllowedRoles());
        $this->assertNotContains(Role::MANAGER->value, Role::MANAGER->getAllowedRoles());
        $this->assertNotContains(Role::USER->value, Role::USER->getAllowedRoles());
    }
}
