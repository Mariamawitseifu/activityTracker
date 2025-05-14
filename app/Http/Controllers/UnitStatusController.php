<?php

namespace App\Http\Controllers;

use App\Models\UnitStatus;
use App\Http\Requests\StoreUnitStatusRequest;
use App\Http\Requests\UpdateUnitStatusRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UnitStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Unit $unit)
    {
        // Gate::authorize('create', UnitStatus::class);
        $unitManagerId = $this->unitManagerId($unit->id);

        if ($unitManagerId != Auth::id()) {
            return response()->json([
                'message' => 'You are not allowed to change session for this unit.',
            ], 403);
        }

        $lastActives = UnitStatus::whereHas('unit', function ($query) {
            $query->whereHas('manager', function ($query) {
                $query->where('end_date', null)
                    ->where('manager_id', Auth::id());
            });
        })->latest()->get();

        foreach ($lastActives as $active) {
            $active->update([
                'status' => 0,
            ]);
        }

        UnitStatus::create([
            'unit_id' => $unit->id,
            'status' => 1,
        ]);

        return response()->json([
            'message' => 'Session started.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitStatusRequest $request, UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitStatus $unitStatus)
    {
        //
    }
}
