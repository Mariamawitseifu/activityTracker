<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Plan::when(request('search'), function ($query, $search) {
            return $query->where('main_activity_id', 'like', "%$search%")
                ->orWhere('unit_id', 'like', "%$search%")
                ->orWhere('parent_id', 'like', "%$search%");
        })->with(['mainActivity', 'unit'])->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        try {
            $plans = [];
            
            foreach ($request->main_activity_id as $mainActivityId) {
                $plans[] = Plan::create([
                    'main_activity_id' => $mainActivityId, 
                    'unit_id' => $request->unit_id,         
                    'parent_id' => $request->parent_id,     
                ]);
            }
            return $plans;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
