<?php

namespace App\Traits;

use App\Models\UnitManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UnitTrait
{
    public function getMyUnit(){
        $lastActive = $this->lastActive();

        return $lastActive ? $lastActive->unit : null;
    }

    public function getMyParentUnit()
    {
        $user = $this->loggedInUser();


        $parentUnit = $user->unit->unit;


        return $parentUnit ?? null;
    }
    public function lastActive()
    {

        $user = $this->loggedInUser();

        if ($user) {
            $lastActive = UnitManager::whereHas('unit', function ($query) use ($user) {
                $query->where('manager_id', $user->id);
            })->latest()->first();

            return $lastActive ? $lastActive : null;
        }

        return null;
    }

    // user
    public function loggedInUser()
    {
        $user = User::where('user_id', Auth::id())
            ->whereHas('unit')
            ->latest()
            ->first();

        return $user;
    }
}
