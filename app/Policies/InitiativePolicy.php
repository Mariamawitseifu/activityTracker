<?php

namespace App\Policies;

use App\Models\Initiative;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InitiativePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:initiative')
            ? Response::allow()
            : Response::deny('You do not have permission to view any initiatives.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Initiative $initiative): Response
    {
        return $user->hasPermissionTo('read:initiative')
            ? Response::allow()
            : Response::deny('You do not have permission to view this initiative.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:initiative')
            ? Response::allow()
            : Response::deny('You do not have permission to create initiatives.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Initiative $initiative): Response
    {
        return $user->hasPermissionTo('update:initiative')
            ? Response::allow()
            : Response::deny('You do not have permission to update this initiative.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Initiative $initiative): Response
    {
        return $user->hasPermissionTo('delete:initiative')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this initiative.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Initiative $initiative): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Initiative $initiative): bool
    {
        return false;
    }
}
