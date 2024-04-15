<?php

namespace App\Support;

trait EnumHelpers
{
    /**
     * @return array<mixed>
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }
}
