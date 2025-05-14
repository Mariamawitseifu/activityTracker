<?php

namespace App\Policies;

use App\Models\UnitEmployee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitEmployeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:unitemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to view unit employees.');
    }

    public function viewChild(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'read:childemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to view child employees.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UnitEmployee $unitEmployee): Response
    {
        return $user->hasPermissionTo('read:unitemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to view this unit employee.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:unitemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to create unit employees.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UnitEmployee $unitEmployee): Response
    {
        return $user->hasPermissionTo('update:unitemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to update this unit employee.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UnitEmployee $unitEmployee): Response
    {
        return $user->hasPermissionTo('delete:unitemployees')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this unit employee.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UnitEmployee $unitEmployee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UnitEmployee $unitEmployee): bool
    {
        return false;
    }
}
