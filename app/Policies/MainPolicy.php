<?php

namespace App\Policies;

use App\Models\Main;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MainPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'view main')
            ? Response::allow()
            : Response::deny('You do not have permission to view mains.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Main $main): Response
    {

        return $user->hasPermissionTo(permission: 'view main')
            ? Response::allow()
            : Response::deny('You do not have permission to view this main.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create main')
            ? Response::allow()
            : Response::deny('You do not have permission to create mains.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Main $main): Response
    {
        return $user->hasPermissionTo(permission: 'update main')
            ? Response::allow()
            : Response::deny('You do not have permission to update this main.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Main $main): Response
    {

        return $user->hasPermissionTo(permission: 'delete main')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this main.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Main $main): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Main $main): bool
    {
        return false;
    }
}
