<?php

namespace App\QueryFilters;

use App\QueryBuilders\UserQueryBuilder;

class IdFilter extends BaseQueryFilter
{
    public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder
    {
        return $next($this->scopeFilterIfPresent($query, 'id'));
    }
}
