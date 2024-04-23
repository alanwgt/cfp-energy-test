<?php

namespace App\QueryFilters;

use App\QueryBuilders\UserQueryBuilder;

class EmailFilter extends BaseQueryFilter
{
    public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder
    {
        return $next($this->scopeFilterIfPresent($query, 'email'));
    }
}
