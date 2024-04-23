<?php

namespace App\QueryFilters;

use App\Data\FilterData;
use App\Enum\FilterOperator;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Http\Request;

abstract class BaseQueryFilter
{
    /** @var array<FilterData> */
    protected readonly array $filters;

    public function __construct(
        protected readonly Request $request
    ) {
        /** @var array<FilterData> filters */
        $filters = FilterData::collect($this->request->input('filters', []));
        $this->filters = $filters;
    }

    protected function has(string $key): bool
    {
        /** @var FilterData $filterData */
        foreach ($this->filters as $filterData) {
            if ($filterData->field === $key) {
                return true;
            }
        }

        return false;
    }

    protected function getFilter(string $key): ?FilterData
    {
        /** @var FilterData $filterData */
        foreach ($this->filters as $filterData) {
            if ($filterData->field === $key) {
                return $filterData;
            }
        }

        return null;
    }

    protected function scopeFilter(UserQueryBuilder $query, FilterData $filter, ?string $field = null): UserQueryBuilder
    {
        $field ??= $filter->field;

        return match ($filter->operator) {
            FilterOperator::CONTAINS => $query->whereLike($field, $filter->value),
            FilterOperator::ENDS_WITH => $query->where($field, 'like', "%$filter->value"),
            FilterOperator::STARTS_WITH => $query->where($field, 'like', "$filter->value%"),
            FilterOperator::EQUALS => $query->where($field, $filter->value),
        };
    }

    protected function scopeFilterIfPresent(UserQueryBuilder $query, string $key): UserQueryBuilder
    {
        if ($filter = $this->getFilter($key)) {
            return $this->scopeFilter($query, $filter);
        }

        return $query;
    }

    abstract public function handle(UserQueryBuilder $query, \Closure $next): UserQueryBuilder;
}
