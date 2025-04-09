<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\UnitManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Unit::class);
        return Unit::when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->when(request('unit_type_id'), function ($query, $unit_type_id) {
            return $query->where('unit_type_id', $unit_type_id);
        })->with('unitType', 'manager.user', 'parent')->latest()->paginate();
    }

    public function all()
    {
        // Gate::authorize('viewAny', Unit::class);
        return Unit::when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->when(request('unit_type_id'), function ($query, $unit_type_id) {
            return $query->where('unit_type_id', $unit_type_id);
        })->latest()->get()->map(function ($unit) {
            return [
                'id' => $unit->id,
                'name' => $unit->name,
                'manager' => $unit->manager ? $unit->manager->user->name : null,
            ];
        });
    }

    public function myChildUnits()
    {
        $lastActive = $this->lastActive();
        $myUnit = Unit::find($lastActive->unit_id);

        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
        return Unit::when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->where('parent_id', $myUnit->id)
            ->when(request('unit_type_id'), function ($query, $unit_type_id) {
                return $query->where('unit_type_id', $unit_type_id);
            })->latest()->get()->map(function ($unit) {
                return [
                    'id' => $unit->id,
                    'name' => $unit->name,
                    'unit_type' => $unit->unitType->name,
                ];
            });
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        Gate::authorize('create', Unit::class);
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
        Gate::authorize('view', $unit);
        return $unit->load(['unitType', 'manager', 'parent']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        Gate::authorize('update', $unit);
        try {
            $unit->update([
                'name' => $request->name ?? $unit->name,
                'unit_type_id' => $request->unit_type_id ?? $unit->unit_type_id,
                'parent_id' => $request->parent_id ?? $unit->parent_id,
            ]);


            UnitManager::updateOrCreate([
                'unit_id' => $unit->id,
            ], [
                'manager_id' => $request->manager_id ?? $unit->manager->manager_id,
                'start_date' => $request->start_date ?? now(),
            ]);
            return response()->json($unit->load('manager.user'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        Gate::authorize('delete', $unit);
        return 'not implemented';
    }
}
