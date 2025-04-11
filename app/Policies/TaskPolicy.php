<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->hasPermissionTo('read:task')) {
            return Response::allow();
        }
        
        return $user->hasPermissionTo('read:task')
            ? Response::allow()
            : Response::deny('You do not have permission to view any tasks.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): Response
    {
        return $user->hasPermissionTo('read:task')
            ? Response::allow()
            : Response::deny('You do not have permission to view this task.');
    }

    public function pendingTasks(User $user, Task $task): Response
    {
        return $user->hasPermissionTo('read:pendingtask')
            ? Response::allow()
            : Response::deny('You do not have permission to view pending tasks.');
    }
    
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:task')
            ? Response::allow()
            : Response::deny('You do not have permission to create tasks.');
    }
    public function approveTask(User $user): Response
    {
        return $user->hasPermissionTo('create:approvetask')
            ? Response::allow()
            : Response::deny('You do not have permission to approve tasks.');
    }


    public function changeStatus(User $user): Response
    {
        return $user->hasPermissionTo('create:changestatus')
            ? Response::allow()
            : Response::deny('You do not have permission to change status.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        return $user->hasPermissionTo('update:task')
            ? Response::allow()
            : Response::deny('You do not have permission to update this task.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        return $user->hasPermissionTo('delete:task')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this task.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
