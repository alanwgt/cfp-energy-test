<?php

namespace App\QueryFilters;

use App\QueryBuilders\UserQueryBuilder;

class QuickSearchFilter extends BaseQueryFilter
{
    public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder
    {
        if ($this->request->has('quick_filter')) {
            $query->search($this->request->input('quick_filter'));
        }

        return $next($query);
    }
}
