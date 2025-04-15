<?php

namespace App\Policies;

use App\Models\FiscalYear;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FiscalYearPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('read:fiscalyear')
            ? Response::allow()
            : Response::deny('You do not have permission to view any fiscal years.');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FiscalYear $fiscalYear): Response
    {
        return $user->hasPermissionTo('read:fiscalyear')
            ? Response::allow()
            : Response::deny('You do not have permission to view this fiscal year.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:fiscalyear')
            ? Response::allow()
            : Response::deny('You do not have permission to create fiscal years.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FiscalYear $fiscalYear): Response
    {
        return $user->hasPermissionTo('update:fiscalyear')
            ? Response::allow()
            : Response::deny('You do not have permission to update this fiscal year.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FiscalYear $fiscalYear): Response
    {
        return $user->hasPermissionTo('delete:fiscalyear')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this fiscal year.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FiscalYear $fiscalYear): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FiscalYear $fiscalYear): bool
    {
        return false;
    }
}
