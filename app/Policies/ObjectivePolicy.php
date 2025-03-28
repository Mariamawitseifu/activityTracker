<?php

namespace App\Policies;

use App\Models\Objective;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ObjectivePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
return $user->hasPermissionTo(permission: 'view objective')
            ? Response::allow()
            : Response::deny('You do not have permission to view objectives.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Objective $objective): Response
    {
        return $user->hasPermissionTo(permission: 'view objective')
            ? Response::allow()
            : Response::deny('You do not have permission to view this objective.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create objective')
            ? Response::allow()
            : Response::deny('You do not have permission to create objectives.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Objective $objective): Response
    {

        return $user->hasPermissionTo(permission: 'update objective')
            ? Response::allow()
            : Response::deny('You do not have permission to update this objective.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Objective $objective): Response
    {

        return $user->hasPermissionTo(permission: 'delete objective')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this objective.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Objective $objective): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Objective $objective): bool
    {
        return false;
    }
}
