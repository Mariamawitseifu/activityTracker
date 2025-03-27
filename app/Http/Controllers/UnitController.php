<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Unit::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        try {
        return Unit::create([
            'name' => $request->name,
            'unit_type_id' => $request->unit_type_id
        ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return $unit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $unit->update([
                'name' => $request->name ?? $unit->name,
                'unit_type_id' => $request->unit_type_id ?? $unit->unit_type_id
            ]);
            return response()->json($unit, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        return 'not implemented';
    }
}
