<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\SubTask;
use App\Models\Task;
use App\Models\UnitManager;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        Gate::authorize('viewChild', Unit::class);

        $lastActive = $this->lastActive();
        $myUnit = $lastActive ? $lastActive->unit : null;
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
                    'parent' => $unit->parent ? $unit->parent->name : null,
                    'manager' => $unit->manager ? $unit->manager->user->name : null,
                ];
            });
    }

    public function myTeams(Request $request,)
    {
        $request->validate([
            'search' => 'string|nullable',
            'from' => 'nullable|date|before_or_equal:today',
            'to' => 'required_with:from|date|after_or_equal:from',
        ]);

        $perPage  = $request->per_page ?? 10;
        $lastActive = $this->lastActive();
        $myUnit = $lastActive ? $lastActive->unit : null;

        if ($myUnit) {
            $search = $request->search;

            $userIds = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })->pluck('id');

            $units = Unit::when(request('search'), function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })->where('parent_id', $myUnit->id)
                ->when(request('unit_type_id'), function ($query, $unit_type_id) {
                    return $query->where('unit_type_id', $unit_type_id);
                })->latest()->get();


            $managers = $units->pluck('manager.user.id');

            $employees = User::when($search, function ($query) use ($userIds) {
                $query->whereIn('id', $userIds);
            })
                ->where('id', '!=', Auth::id())
                ->whereIn('id', $managers)
                ->paginate($perPage)
                ->through(function ($employee) use ($request) {
                    if ($request->from && $request->to) {
                        $start = Carbon::parse($request->from);
                        $end = Carbon::parse($request->to);
                    } else {
                        $start = Carbon::now()->startOfWeek()->subDay();
                        $end = Carbon::now()->endOfWeek()->subDay();
                    }

                    $taskCounts = Task::where('user_id', $employee->id)->whereBetween('date', [$start, $end])
                        ->whereHas('plan')->count();

                    $subTaskCounts = SubTask::whereHas('task', function ($query) use ($employee, $start, $end) {
                        $query->where('user_id', $employee->id)->whereBetween('date', [$start, $end])
                            ->whereHas('plan');
                    })->count();

                    $pendingTasks = Task::where('user_id', $employee->id)->whereBetween('date', [$start, $end])
                        ->whereHas('plan')->where('status', 0)->count();

                    $units = $this->managerUnit($employee->id)->pluck('name')->toArray();
                    $units = implode(', ', $units);
                    $units = $units ? $units : 'No Unit Assigned';

                    return [
                        'id' => $employee->id,
                        'name' => $employee->name ?? null,
                        'unit' =>  $units,
                        'tasks_count' => $taskCounts,
                        'sub_tasks_count' => $subTaskCounts,
                        'pending_tasks_count' =>   $pendingTasks,
                    ];
                });
            return response()->json($employees);
        } else {
            return response()->json([
                'message' => 'You are not assigned to any unit',
            ], 403);
        }
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
