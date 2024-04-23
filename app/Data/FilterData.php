<?php

namespace App\Data;

use App\Enum\FilterOperator;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public function __construct(
        public string $field,
        public string $value,
        #[WithCast(EnumCast::class, type: FilterOperator::class)]
        public FilterOperator $operator,
    ) {
    }
}
