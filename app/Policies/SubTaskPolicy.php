<?php

namespace App\Policies;

use App\Models\SubTask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubTaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:subtask')
            ? Response::allow()
            : Response::deny('You do not have permission to view any subtasks.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SubTask $subTask): Response
    {
        return $user->hasPermissionTo('read:subtask')
            ? Response::allow()
            : Response::deny('You do not have permission to view this subtask.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return  $user->hasPermissionTo('create:subtask')
            ? Response::allow()
            : Response::deny('You do not have permission to create subtasks.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SubTask $subTask): Response
    {
        return $user->hasPermissionTo('update:subtask')
            ? Response::allow()
            : Response::deny('You do not have permission to update this subtask.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SubTask $subTask): Response
    {
        return $user->hasPermissionTo('delete:subtask')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this subtask.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SubTask $subTask): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SubTask $subTask): bool
    {
        return false;
    }
}
