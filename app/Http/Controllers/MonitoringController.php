<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;


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
        $start = Carbon::parse($fiscalYear->start_date)->startOfMonth();
        $end = Carbon::parse($fiscalYear->end_date)->startOfMonth();
    
        // Parse the month name from request
        $inputMonthName = strtolower($request->month);
        $matchedMonth = null;
    
        // Iterate over each month in the fiscal year
        $current = $start->copy();
        while ($current <= $end) {
            if (strtolower($current->format('F')) === $inputMonthName) {
                $matchedMonth = $current->format('Y-m-01');
                break;
            }
            $current->addMonth();
        }
    
        if (!$matchedMonth) {
            return response()->json([
                'message' => 'The given month is not within the fiscal year range.',
            ], 422);
        }
    
        try {
            $monitoring = Monitoring::create([
                'plan_id' => $request->plan_id,
                'actual_value' => $request->actual_value,
                'month' => $matchedMonth,
            ]);
    
            return $monitoring;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating monitoring',
                'error' => $th->getMessage(),
            ], 500);
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
        $start = Carbon::parse($fiscalYear->start_date)->startOfMonth();
        $end = Carbon::parse($fiscalYear->end_date)->startOfMonth();

        // Parse the month name from request
        $inputMonthName = strtolower($request->month);
        $matchedMonth = null;

        // Iterate over each month in the fiscal year
        $current = $start->copy();
        while ($current <= $end) {
            if (strtolower($current->format('F')) === $inputMonthName) {
                $matchedMonth = $current->format('Y-m-01');
                break;
            }
            $current->addMonth();

        }
        if (!$matchedMonth) {
            return response()->json([
                'message' => 'The given month is not within the fiscal year range.',
            ], 422);
        }

        try {
            $monitoring->update([
                'plan_id' => $request->plan_id ?? $monitoring->plan_id,
                'actual_value' => $request->actual_value ?? $monitoring->actual_value,
                'month' => $matchedMonth ?? $monitoring->month,
            ]);

            return $monitoring;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating monitoring',
                'error' => $th->getMessage(),
            ], 500);
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
