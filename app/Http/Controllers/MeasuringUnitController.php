<?php

namespace App\Http\Controllers;

use App\Models\MeasuringUnit;
use App\Http\Requests\StoreMeasuringUnitRequest;
use App\Http\Requests\UpdateMeasuringUnitRequest;
use Illuminate\Support\Facades\Gate;

class MeasuringUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', MeasuringUnit::class);
        return MeasuringUnit::all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeasuringUnitRequest $request)
    {
        Gate::authorize('create', MeasuringUnit::class);
        try {
            $measuringUnit = MeasuringUnit::create([
                'name' => $request->name,
            ]);
            return $measuringUnit;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MeasuringUnit $measuringUnit)
    {
        Gate::authorize('view', $measuringUnit);
        return $measuringUnit;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeasuringUnitRequest $request, MeasuringUnit $measuringUnit)
    {
        Gate::authorize('update', $measuringUnit);
        try {
            $measuringUnit->update([
                'name' => $request->name,
            ]);
            return $measuringUnit;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeasuringUnit $measuringUnit)
    {
        Gate::authorize('delete', $measuringUnit);
        return response()->json(['message' => 'not implemented'], 501);
    }
}
