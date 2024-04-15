<?php

namespace App\Enum;

use App\Support\EnumHelpers;

enum Role: string
{
    use EnumHelpers;

    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';
}
