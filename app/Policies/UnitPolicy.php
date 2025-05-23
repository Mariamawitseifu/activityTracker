<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'read:unit')
            ? Response::allow()
            : Response::deny('You do not have permission to view units.');
    }
    public function viewChild(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'read:childunit')
            ? Response::allow()
            : Response::deny('You do not have permission to view child units.');
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Unit $unit): Response
    {
        return $user->hasPermissionTo(permission: 'read:unit')
            ? Response::allow()
            : Response::deny('You do not have permission to view this unit.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create:unit')
            ? Response::allow()
            : Response::deny('You do not have permission to create units.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Unit $unit): Response
    {

        return $user->hasPermissionTo(permission: 'update:unit')
            ? Response::allow()
            : Response::deny('You do not have permission to update this unit.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Unit $unit): Response
    {
        return $user->hasPermissionTo(permission: 'delete:unit')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this unit.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Unit $unit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Unit $unit): bool
    {
        return false;
    }
}
