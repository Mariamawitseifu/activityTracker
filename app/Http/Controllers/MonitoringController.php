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
        Gate::authorize('create', Monitoring::class);
    
        $plan = Plan::with('fiscalYear')->find($request->plan_id);
        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found',
            ], 404);
        }

        $fiscalYear = $plan->fiscalYear;

        $month = Carbon::parse($request->month . '-01');

        if($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
            return response()->json([
                'message' => 'Invalid year or month , must be between ' . $fiscalYear->start_date . ' and ' . $fiscalYear->end_date,
            ], 422);
        }
    
        try {
            $monitoring = Monitoring::create([
                'plan_id' => $request->plan_id,
                'month' => $month,
                'actual_value' => $request->actual_value,
            ]);
            return $monitoring;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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

        if($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
            return response()->json([
                'message' => 'Invalid year or month , must be between ' . $fiscalYear->start_date . ' and ' . $fiscalYear->end_date,
            ], 422);
        }

        try {
            foreach ($request->monitorings as $monitoring) {
                Monitoring::create([
                    'plan_id' => $monitoring['plan_id'],
                    'month' => $month,
                    'actual_value' => $monitoring['actual_value'],
                ]);
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

        $fiscalYear = $plan->fiscalYear;

        $month = Carbon::parse($request->month . '-01');

        if($month < Carbon::parse($fiscalYear->start_date) || $month > Carbon::parse($fiscalYear->end_date)) {
            return response()->json([
                'message' => 'Invalid month',
            ], 422);
        }

        try {
            $monitoring->update([
                'actual_value' => $request->actual_value ?? $monitoring->actual_value,
                'month' => $month ?? $monitoring->month,
                'plan_id' => $request->plan_id ?? $monitoring->plan_id
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
