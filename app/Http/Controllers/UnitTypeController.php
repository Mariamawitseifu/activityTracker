<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use App\Http\Requests\StoreUnitTypeRequest;
use App\Http\Requests\UpdateUnitTypeRequest;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UnitType::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitTypeRequest $request)
    {
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
        return $unitType;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitTypeRequest $request, UnitType $unitType)
    {
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
