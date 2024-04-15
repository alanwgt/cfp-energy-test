<?php

namespace App\Enum;

use App\Support\EnumHelpers;

enum AuthenticationMethod: string
{
    use EnumHelpers;

    case PASSWORD = 'password';
    case OTP = 'otp';
}
