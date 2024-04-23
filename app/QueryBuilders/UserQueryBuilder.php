<?php

namespace App\QueryBuilders;

use App\Enum\Role;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function whereIdentification(string $identification): self
    {
        return $this->where(function (self $query) use ($identification) {
            $query->where('username', '=', $identification)
                ->orWhere('email', '=', $identification);
        });
    }

    public function whereCanView(Role $role): self
    {
        return $this->whereIn('role', $role->getAllowedRoles());
    }

    public function whereLike(string $column, string $value): self
    {
        return $this->where($column, 'like', '%'.$value.'%');
    }

    public function orWhereLike(string $column, string $value): self
    {
        return $this->orWhere($column, 'like', '%'.$value.'%');
    }

    public function search(string $search): self
    {
        return $this->whereLike('username', $search)
            ->orWhereLike('email', $search)
            ->orWhereLike('first_name', $search)
            ->orWhereLike('last_name', $search);
    }
}
