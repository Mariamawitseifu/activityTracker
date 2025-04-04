<?php

namespace App\Traits;

use App\Models\Unit;
use App\Models\UnitManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UnitTrait
{
    public function getMyUnit()
    {
        // $lastActive = $this->lastActive();

      $user =   User::where('username', Auth::user()->username)
            ->latest()
            ->first(); 

            dd($user->id);
//         $myUnit = UnitManager::where('manager_id', Auth::id())
//         ->latest()->first();
// dd(Auth::user()->name);
//         return $myUnit ?? null;
    }

    public function getMyParentUnit()
    {
        $user = $this->loggedInUser();

        $unit = $this->getMyUnit();
        $parentUnit = Unit::where('id', $unit->parent_id)->first();

        return $parentUnit ?? null;
    }
    // public function lastActive()
    // {

    //     $user = $this->loggedInUser();

    //     if ($user) {
    //         $lastActive = UnitManager::whereHas('unit', function ($query) use ($user) {
    //             $query->where('manager_id', $user->id);
    //         })->latest()->first();

    //         return $lastActive ? $lastActive : null;
    //     }

    //     return null;
    // }

    // user
    // public function loggedInUser()
    // {
    //     $user = User::where('user_id', Auth::id())
    //         ->whereHas('unit')
    //         ->latest()
    //         ->first();

    //     return $user;
    // }
}
