<?php

namespace App\Policies;

use App\Models\PlanReport;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlanReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:planreport')
            ? Response::allow()
            : Response::deny('You do not have permission to view any plan reports.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanReport $planReport): Response
    {
        return $user->hasPermissionTo('read:planreport')
            ? Response::allow()
            : Response::deny('You do not have permission to view this plan report.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:planreport')
            ? Response::allow()
            : Response::deny('You do not have permission to create plan reports.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanReport $planReport): Response
    {
        return $user->hasPermissionTo('update:planreport')
            ? Response::allow()
            : Response::deny('You do not have permission to update this plan report.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanReport $planReport): Response
    {
        return $user->hasPermissionTo('delete:planreport')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this plan report.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanReport $planReport): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanReport $planReport): bool
    {
        return false;
    }
}
