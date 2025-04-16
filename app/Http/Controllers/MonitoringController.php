<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

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
    
        // Use the fiscal year start date from the plan
        $plan = Plan::findOrFail($request->plan_id);
        $fiscalYear = $plan->fiscal_year;
    
        // Get fiscal year start date and extract year and month
        $fiscalYearStart = new \DateTime($fiscalYear->start_date);
        $fiscalYearStartYear = $fiscalYearStart->format('Y');
        $fiscalYearStartMonth = $fiscalYearStart->format('m');
    
        // Ensure month in request is a valid date (convert to Y-m format)
        $requestMonth = \DateTime::createFromFormat('F', $request->month);
    
        if (!$requestMonth) {
            return response()->json([
                'message' => 'Invalid month format',
            ], 422);
        }
    
        // Get year and month from the request
        $requestMonthYear = $requestMonth->format('Y');
        $requestMonthMonth = $requestMonth->format('m');
    
        // Check if the request month is within the fiscal year
        if ($requestMonthYear < $fiscalYearStartYear || ($requestMonthYear == $fiscalYearStartYear && $requestMonthMonth < $fiscalYearStartMonth)) {
            return response()->json([
                'message' => 'Month must be within fiscal year',
            ], 422);
        }
    
        // Get the current month for comparison
        $currentMonth = (int)date('m');
        $requestMonthMonthInt = (int)$requestMonthMonth;
    
        // Ensure month is before or equal to current month
        if ($requestMonthMonthInt > $currentMonth) {
            return response()->json([
                'message' => 'Month must be before today',
            ], 422);
        }
    
        try {
            // Store the monitoring record
            $monitoring = Monitoring::create([
                'plan_id' => $request->plan_id,
                'actual_value' => $request->actual_value,
                'month' => $request->month, 
            ]);
    
            return response()->json($monitoring);
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
        try {
            $monitoring->update([
                'plan_id' => $request->plan_id ?? $monitoring->plan_id,
                'actual_value' => $request->actual_value ?? $monitoring->actual_value,
                'month' => $request->month ?? $monitoring->month,
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
