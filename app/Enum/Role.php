<?php

namespace App\Enum;

use App\Support\EnumHelpers;

enum Role: string
{
    use EnumHelpers;

    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    public const ROLE_LEVEL = [
        self::ADMIN->value => 1000,
        self::MANAGER->value => 100,
        self::USER->value => 1,
    ];

    public function isGreaterThan(Role $role): bool
    {
        return self::ROLE_LEVEL[$this->value] > self::ROLE_LEVEL[$role->value];
    }
}
