<?php

namespace App\Policies;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->isGreaterThan(Role::USER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role->isGreaterThan($model->role)
            || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->isGreaterThan(Role::USER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role->isGreaterThan($model->role)
            || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role->isGreaterThan($model->role)
            || $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === Role::ADMIN;
    }

    public function updateProperty(User $user, User $model, string $property): Response
    {
        if ($property !== 'role') {
            return Response::allow();
        }

        if ($user->is($model)) {
            return Response::deny('You cannot change your own role');
        }

        if ($user->role->isGreaterThan($model->role)) {
            return Response::allow();
        }

        return Response::deny('You cannot update the role of a user with a higher or equal role.');
    }
}
