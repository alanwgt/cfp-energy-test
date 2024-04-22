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
}
