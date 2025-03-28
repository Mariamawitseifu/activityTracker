<?php

namespace App\Policies;

use App\Models\MeasuringUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MeasuringUnitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'view:measuringunit')
            ? Response::allow()
            : Response::deny('You do not have permission to view measuringunit.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MeasuringUnit $measuringUnit): Response
    {
        return $user->hasPermissionTo(permission: 'view:measuringunit')
            ? Response::allow()
            : Response::deny('You do not have permission to view this measuring unit.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create:measuringunit')
            ? Response::allow()
            : Response::deny('You do not have permission to create measuring unit.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MeasuringUnit $measuringUnit): Response
    {
        return $user->hasPermissionTo(permission: 'update:measuringunit')
            ? Response::allow()
            : Response::deny('You do not have permission to update measuring unit.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MeasuringUnit $measuringUnit): Response
    {
        return $user->hasPermissionTo(permission: 'delete:measuringunit')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this measuring unit.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MeasuringUnit $measuringUnit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MeasuringUnit $measuringUnit): bool
    {
        return false;
    }
}
