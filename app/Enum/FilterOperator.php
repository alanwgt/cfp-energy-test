<?php

namespace App\Enum;

enum FilterOperator: string
{
    case EQUALS = 'equals';
    case CONTAINS = 'contains';
    case STARTS_WITH = 'startsWith';
    case ENDS_WITH = 'endsWith';
}
