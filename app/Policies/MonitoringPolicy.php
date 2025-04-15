<?php

namespace App\Policies;

use App\Models\Monitoring;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MonitoringPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:monitoring')
            ? Response::allow()
            : Response::deny('You do not have permission to view any monitorings.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Monitoring $monitoring): Response
    {
        return  $user->hasPermissionTo('read:monitoring')
            ? Response::allow()
            : Response::deny('You do not have permission to view this monitoring.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:monitoring')
            ? Response::allow()
            : Response::deny('You do not have permission to create monitorings.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Monitoring $monitoring): Response
    {
        return $user->hasPermissionTo('update:monitoring')
            ? Response::allow()
            : Response::deny('You do not have permission to update this monitoring.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Monitoring $monitoring): Response
    {
        return $user->hasPermissionTo('delete:monitoring')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this monitoring.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Monitoring $monitoring): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Monitoring $monitoring): bool
    {
        return false;
    }
}
