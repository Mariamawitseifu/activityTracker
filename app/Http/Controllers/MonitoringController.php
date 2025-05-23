<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArrayMonitoringsRequest;
use App\Models\Monitoring;
use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Monitoring::class);
        return Monitoring::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonitoringRequest $request)
    {
        // Gate::authorize('create', Monitoring::class);

        $plan = Plan::with('fiscalYear')->find($request->plan_id);
        $lastActive = $this->lastActive();
        $myUnit = $lastActive ? $lastActive->unit : null;
        $myPlan = Plan::where('id', $request->plan_id)
            ->where('unit_id', $myUnit->id)->first();

        if ($myPlan) {
            return response()->json([
                'message' => 'You are not allowed to monitor your plan',
            ], 403);
        }

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found',
            ], 404);
        }

        $fiscalYear = $plan->fiscalYear;

        $month = Carbon::parse($request->month . '-01');

        if ($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
            return response()->json([
                'message' => 'Invalid year or month , must be between ' . $fiscalYear->start_date . ' and ' . $fiscalYear->end_date,
            ], 422);
        }
        $this->createParentMonitoring($plan, $month, $request->actual_value);
        try {
            $monitoring = Monitoring::updateOrCreate([
                'plan_id' => $request->plan_id,
                'month' => $month,
            ], [
                'actual_value' => $request->actual_value,
            ]);
            return $monitoring;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    private function createParentMonitoring($plan, $month, $actualValue)
    {
        $parentPlan = $plan->parent_id ? Plan::find($plan->parent_id) : null;
    
        if ($parentPlan) {
            $parentMonitoring = Monitoring::where('plan_id', $parentPlan->id)
                ->where('month', $month)
                ->first();
    
            if (!$parentMonitoring) {
                try {
                    $parentMonitoring = Monitoring::create([
                        'plan_id' => $parentPlan->id,
                        'month' => $month,
                        'actual_value' => $actualValue, 
                    ]);
                } catch (\Exception $e) {
                    throw new \Exception('Failed to create parent monitoring: ' . $e->getMessage());
                }
            }
    
            $this->createParentMonitoring($parentPlan, $month, $actualValue);
        }
    }

    //create array monitorings

public function storeArrayMonitorings(StoreArrayMonitoringsRequest $request)
{
    Gate::authorize('create', Monitoring::class);

    $plan = Plan::with('fiscalYear')->find($request->monitorings[0]['plan_id']);
    if (!$plan) {
        return response()->json([
            'message' => 'Plan not found',
        ], 404);
    }

    $fiscalYear = $plan->fiscalYear;
    $month = Carbon::parse($request->month . '-01');

    if ($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
        return response()->json([
            'message' => 'Invalid year or month, must be between ' . $fiscalYear->start_date . ' and ' . $fiscalYear->end_date,
        ], 422);
    }

    try {
        foreach ($request->monitorings as $monitoringData) {
            $currentPlan = Plan::with('fiscalYear')->find($monitoringData['plan_id']);
            $lastActive = $this->lastActive();
            $myUnit = $lastActive ? $lastActive->unit : null;
            $myPlan = Plan::where('id', $monitoringData['plan_id'])
                ->where('unit_id', $myUnit->id)->first();

            if ($myPlan) {
                return response()->json([
                    'message' => 'You are not allowed to monitor your plan',
                ], 403);
            }

            if (!$currentPlan) {
                return response()->json([
                    'message' => 'Plan not found',
                ], 404);
            }

            $this->createParentMonitoring($currentPlan, $month, $monitoringData['actual_value']);

            Monitoring::updateOrCreate(
                ['plan_id' => $monitoringData['plan_id'], 'month' => $month],
                ['actual_value' => $monitoringData['actual_value']]
            );
        }

        return response()->json(['message' => 'Monitorings created successfully'], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        Gate::authorize('view', $monitoring);
        return $monitoring;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMonitoringRequest $request, Monitoring $monitoring)
    {
        Gate::authorize('update', $monitoring);
    
        $plan = Plan::with('fiscalYear')->find($request->plan_id);
        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found',
            ], 404);
        }
    
        $lastActive = $this->lastActive();
        $myUnit = $lastActive ? $lastActive->unit : null;
    
        if ($plan->unit_id !== $myUnit->id) {
            return response()->json([
                'message' => 'You are not allowed to update monitoring for this plan',
            ], 403);
        }
    
        $fiscalYear = $plan->fiscalYear;
        $month = Carbon::parse($request->month . '-01');
    
        if ($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
            return response()->json([
                'message' => 'Invalid month, it must be between ' . $fiscalYear->start_date . ' and ' . $fiscalYear->end_date,
            ], 422);
        }
    
        $this->createParentMonitoring($plan, $month, $request->actual_value);
    
        try {
            $monitoring->update([
                'actual_value' => $request->actual_value ?? $monitoring->actual_value,
            ]);
    
            return $monitoring;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        Gate::authorize('delete', $monitoring);
        return ("not implemented");
    }

}
