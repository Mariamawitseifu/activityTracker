<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Plan::class);
        return response('not implemented', 501);
        // return Plan::when(request('search'), function ($query, $search) {
        //     return $query->where('main_activity_id', 'like', "%$search%")
        //         ->orWhere('unit_id', 'like', "%$search%");
        // })->with(['mainActivity', 'unit'])->latest()->paginate(15);
    }

    public function myPlansPaginated()
    {
        $lastActive = $this->lastActive();

        if (!$lastActive) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
        $myUnit = Unit::find($lastActive->unit_id);

        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }

        $search = request('search');
        $plans = $this->getPlansWithSearchAndUnit($search, $myUnit);

        return $plans;
    }

    public function myPlans()
    {
        $lastActive = $this->lastActive();

        if (!$lastActive) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
        $myUnit = Unit::find($lastActive->unit_id);

        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }

        $search = request('search');
        return Plan::when($search, function ($query) use ($search) {
            return $query->where('main_activity_id', 'like', "%$search%")
                ->orWhere('unit_id', 'like', "%$search%");
        })->latest()
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'title' => $plan->mainActivity->title,
                    'initiative' => $plan->mainActivity->initiative->title,
                    'objective' => $plan->mainActivity->initiative->objective->title,
                    'weight' => $plan->mainActivity->weight,
                    'unit' => $plan->unit->name,
                    'target' => $plan->mainActivity->target,
                    'fiscal_year' => $plan->fiscalYear->name,
                ];
            });
    }

    public function unitPlan(Unit $unit)
    {

        if (!$unit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }

        return Plan::when(request('search'), function ($query, $search) {
            return $query->where('main_activity_id', 'like', "%$search%")
                ->orWhere('unit_id', 'like', "%$search%");
        })
            ->where('unit_id', $unit->id)->latest()->paginate()->through(function ($plan) {
                return [
                    'id' => $plan->id,
                    'title' => $plan->mainActivity->title,
                    'initiative' => $plan->mainActivity->initiative->title,
                    'objective' => $plan->mainActivity->initiative->objective->title,
                    'weight' => $plan->mainActivity->weight,
                    'unit' => $plan->unit->name,
                    'target' => $plan->mainActivity->target,
                    'fiscal_year' => $plan->fiscalYear->name,
                ];
            });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        Gate::authorize('create', Plan::class);
        try {
            DB::beginTransaction();

            $lastActive = $this->lastActive();
            $myUnit = $lastActive->unit;

            if (!$myUnit) {
                return response()->json(['message' => 'You are not a manager of any unit'], 403);
            }

            foreach ($request->main_activities as $value) {

                $parent =  Plan::findOrFail($value);
                Plan::create([
                    'main_activity_id' => $parent->main_activity_id,
                    'fiscal_year_id' => $request->fiscal_year_id,
                    'unit_id' => $request->unit_id,
                    'parent_id' => $value,
                ]);
            }
            DB::commit();
            return "success";
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function removePlan(StorePlanRequest $request)
    {
        try {
            DB::beginTransaction();
            $lastActive = $this->lastActive();
            $myUnit = $lastActive->unit;

            if (!$myUnit) {
                return response()->json(['message' => 'You are not a manager of any unit'], 403);
            }

            foreach ($request->main_activities as $value) {
                $plan = Plan::where('id', $value)
                    ->where('unit_id', $request->unit_id)
                    ->first();

                if ($plan) {
                    $plan->delete();
                }
            }
            DB::commit();

            return "success";
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        Gate::authorize('view', $plan);
        return $plan->load(['mainActivity', 'unit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        Gate::authorize('delete', $plan);
        return response('not implemented', 501);
    }

    public function getPlansWithSearchAndUnit($search, $unit)
    {
        return Plan::when($search, function ($query) use ($search) {
            return $query->where('main_activity_id', 'like', "%$search%")
                ->orWhere('unit_id', 'like', "%$search%");
        })
            ->where('unit_id', $unit->id)
            ->latest()
            ->paginate()
            ->through(function ($plan) {
                return [
                    'id' => $plan->id,
                    'title' => $plan->mainActivity->title,
                    'initiative' => $plan->mainActivity->initiative->title,
                    'objective' => $plan->mainActivity->initiative->objective->title,
                    'weight' => $plan->mainActivity->weight,
                    'unit' => $plan->unit->name,
                    'target' => $plan->mainActivity->target,
                    'fiscal_year' => $plan->fiscalYear->name,
                ];
            });
    }
}
