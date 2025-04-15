<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use Illuminate\Support\Facades\Gate;

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

        try {
            $monitoring = Monitoring::create([
                'plan_id' => $request->plan_id,
                'actual_value' => $request->actual_value,
                'month' => $request->month,
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
