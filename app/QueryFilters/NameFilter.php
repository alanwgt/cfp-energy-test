<?php

namespace App\QueryFilters;

use App\QueryBuilders\UserQueryBuilder;

class NameFilter extends BaseQueryFilter
{
    public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder
    {
        if ($name = $this->getFilter('name')) {
            $this->scopeFilter($query, $name, 'first_name');
        }

        return $next($this->scopeFilterIfPresent($query, 'name'));
    }
}
