<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use App\Http\Requests\StoreUnitTypeRequest;
use App\Http\Requests\UpdateUnitTypeRequest;
use Illuminate\Support\Facades\Gate;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', UnitType::class);
        return UnitType::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitTypeRequest $request)
    {
        Gate::authorize('create', UnitType::class);
        try {
            $unitType = UnitType::create([
                'name' => $request->name,
            ]);
            return response()->json($unitType, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitType $unitType)
    {
        Gate::authorize('view', $unitType);
        return $unitType;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitTypeRequest $request, UnitType $unitType)
    {
        Gate::authorize('update', $unitType);
        try {
            $unitType->update([
                'name' => $request->name ?? $unitType->name,
            ]);
            return response()->json($unitType, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitType $unitType)
    {
        //
    }
}
