<?php

namespace App\Traits;

use App\Models\Unit;
use App\Models\UnitManager;
use App\Models\UnitStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UnitTrait
{
    public function getMyUnit()
    {
        // $lastActive = $this->lastActive();
        // $myUnit = UnitManager::where('manager_id', Auth::id())
        //     ->where('end_date', null)
        //     ->latest()->first()->unit;


        // return $myUnit ?? null;
    }

    public function getMyParentUnit()
    {
        $user = $this->loggedInUser();

        $unit = $this->getMyUnit();
        $parentUnit = Unit::where('id', $unit->parent_id)->first();

        return $parentUnit ?? null;
    }


    public function lastActive()
    {
        $lastActive = UnitStatus::whereHas('unit', function ($query) {
            $query->whereHas('manager', function ($query) {
                $query->where('end_date', null)
                    ->where('manager_id', Auth::id());
            });
        })->where('status', 1)
            ->latest()->first();


        return $lastActive ? $lastActive : null;
    }


    public function unitManagerId($unitId)
    {
        $unitManager = UnitManager::where('unit_id', $unitId)
            ->where('end_date', null)
            ->latest()->first();

        return $unitManager->manager_id;
    }
}
