<?php

namespace App\QueryBuilders;

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
}
