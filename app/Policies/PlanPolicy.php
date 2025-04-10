<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:plan')
            ? Response::allow()
            : Response::deny('You do not have permission to view any plans.');
    }

    public function viewManagerPlans(User $user, Unit $unit): Response
    {
        if ($user->hasPermissionTo('read:plan')&& $user->id === $unit->manager_id) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to view this unit plans.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Plan $plan): Response
    {
        return $user->hasPermissionTo('read:plan')
            ? Response::allow()
            : Response::deny('You do not have permission to view this plan.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:plan')
            ? Response::allow()
            : Response::deny('You do not have permission to create plans.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Plan $plan): Response
    {
        return $user->hasPermissionTo('update:plan')
            ? Response::allow()
            : Response::deny('You do not have permission to update this plan.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plan $plan): Response
    {
        return $user->hasPermissionTo('delete:plan')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this plan.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Plan $plan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Plan $plan): bool
    {
        return false;
    }
}
