<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Unit;
use App\Models\UnitManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response('not implemented', 501);
        // return Plan::when(request('search'), function ($query, $search) {
        //     return $query->where('main_activity_id', 'like', "%$search%")
        //         ->orWhere('unit_id', 'like', "%$search%");
        // })->with(['mainActivity', 'unit'])->latest()->paginate(15);
    }

    public function myPlans()
    {
        $lastActive = $this->lastActive();
        $myUnit = Unit::find($lastActive->unit_id);

        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }

        return Plan::when(request('search'), function ($query, $search) {
            return $query->where('main_activity_id', 'like', "%$search%")
                ->orWhere('unit_id', 'like', "%$search%");
        })
            ->where('unit_id', $myUnit->id)
            ->with(['mainActivity', 'unit'])->latest()->get()->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'title' => $plan->mainActivity->title,
                ];
            });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        try {
            DB::beginTransaction();

            $myUnit = UnitManager::where('manager_id', Auth::id())
                ->whereNot('end_date', null)
                ->latest()->first();

            if (!$myUnit) {
                return response()->json(['message' => 'You are not a manager of any unit'], 403);
            }

            foreach ($request->main_activities as $key => $value) {

                $parent =  Plan::findOrFail($value);
                Plan::create([
                    'main_activity_id' => $parent->main_activity_id,
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

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
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
        return response('not implemented', 501);
    }
}
