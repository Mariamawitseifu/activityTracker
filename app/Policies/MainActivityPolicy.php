<?php

namespace App\Policies;

use App\Models\MainActivity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MainActivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'read:mainactivity')
            ? Response::allow()
            : Response::deny('You do not have permission to view main activities.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MainActivity $mainActivity): Response
    {
        return $user->hasPermissionTo(permission: 'read:mainactivity')
            ? Response::allow()
            : Response::deny('You do not have permission to view this main activity.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create:mainactivity')
            ? Response::allow()
            : Response::deny('You do not have permission to create main activities.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MainActivity $mainActivity): Response
    {
        return $user->hasPermissionTo(permission: 'update:mainactivity')
            ? Response::allow()
            : Response::deny('You do not have permission to update this main activity.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MainActivity $mainActivity): Response
    {
        return $user->hasPermissionTo(permission: 'delete:mainactivity')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this main activity.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MainActivity $mainActivity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MainActivity $mainActivity): bool
    {
        return false;
    }
}
