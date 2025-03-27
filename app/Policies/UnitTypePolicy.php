<?php

namespace App\Policies;

use App\Models\UnitType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::deny('You do not have permission to view unit types.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UnitType $unitType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UnitType $unitType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UnitType $unitType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UnitType $unitType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UnitType $unitType): bool
    {
        return false;
    }
}
