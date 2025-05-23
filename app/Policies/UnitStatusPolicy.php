<?php

namespace App\Policies;

use App\Models\UnitStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UnitStatus $unitStatus): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo('create:unitstatus')
            ? Response::allow()
            : Response::deny('You do not have permission to create unit statuses.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UnitStatus $unitStatus): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UnitStatus $unitStatus): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UnitStatus $unitStatus): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UnitStatus $unitStatus): bool
    {
        return false;
    }
}
