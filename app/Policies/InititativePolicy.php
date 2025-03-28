<?php

namespace App\Policies;

use App\Models\Inititative;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InititativePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {

return $user->hasPermissionTo(permission: 'view inititative')
            ? Response::allow()
            : Response::deny('You do not have permission to view inititatives.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inititative $inititative): Response
    {
        return $user->hasPermissionTo(permission: 'view inititative')
            ? Response::allow()
            : Response::deny('You do not have permission to view this inititative.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(permission: 'create inititative')
            ? Response::allow()
            : Response::deny('You do not have permission to create inititatives.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inititative $inititative): Response
    {
        return $user->hasPermissionTo(permission: 'update inititative')
            ? Response::allow()
            : Response::deny('You do not have permission to update this inititative.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inititative $inititative): Response
    {
        return $user->hasPermissionTo(permission: 'delete inititative')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this inititative.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inititative $inititative): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inititative $inititative): bool
    {
        return false;
    }
}
