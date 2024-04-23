<?php

namespace App\QueryFilters;

use App\QueryBuilders\UserQueryBuilder;

class OrderBy extends BaseQueryFilter
{
    public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder
    {
        $sortBy = $this->request->input('sort_by');
        $sortOrder = $this->request->input('sort_order');
        if ($sortBy && $sortOrder) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $next($query);
    }
}
