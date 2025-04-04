<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyUnitController extends Controller
{
    public function index()
    {
        $lastActive = $this->lastActive();
        $units = Unit::whereHas('manager', function ($query) {
            $query->where('end_date', null)
                ->where('manager_id', Auth::id());
        })->get()->map(function ($unit) use ($lastActive) {
            $isActive = $lastActive && $lastActive->unit_id == $unit->id ? true : false;

            return [
                'id' => $unit->id,
                'name' => $unit->name,
                'parent' => $unit->parent ? $unit->parent->name : null,
                'is_active' => $isActive,
            ];
        });

        if ($lastActive) {
            $last = [
                'id' => $lastActive->unit_id,
                'name' => $lastActive->unit->name,
            ];
        } else {
            $last = null;
        }

        return [
            'last_active' => $last ?? null,
            'units' => $units,
        ];
    }
}
