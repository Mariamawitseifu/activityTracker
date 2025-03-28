<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\UnitManager;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gate::authorize('viewAny', Unit::class);
        return Unit::when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->when(request('unit_type_id'), function ($query, $unit_type_id) {
            return $query->where('unit_type_id', $unit_type_id);
        })->with('unitType', 'manager', 'parent')->latest()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        try {

            $unit = Unit::create([
                'name' => $request->name,
                'unit_type_id' => $request->unit_type_id,
                'parent_id' => $request->parent_id,
            ]);
            UnitManager::create([
                'unit_id' => $unit->id,
                'manager_id' => $request->manager_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return response()->json($unit, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return $unit->load(['unitType', 'manager']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        return 'not implemented';
    }
}
