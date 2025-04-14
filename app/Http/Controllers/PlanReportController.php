<?php

namespace App\Http\Controllers;

use App\Models\PlanReport;
use App\Http\Requests\StorePlanReportRequest;
use App\Http\Requests\UpdatePlanReportRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class PlanReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', PlanReport::class);
        return PlanReport::latest()->with('plan', 'creator')->paginate(15);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanReportRequest $request)
    {
        Gate::authorize('create', PlanReport::class);
        try {
            // $dayOfWeek = date('l', strtotime($request->date));
            // if (!in_array($dayOfWeek, ['Friday', 'Saturday', 'Sunday'])) {
            //     return response()->json(['message' => 'You can only create a plan report on Friday, Saturday, or Sunday.'], 422);
            // }            
            $planReport = PlanReport::create([
                'plan_id' => $request->plan_id,
                'description' => $request->description,
                'creator_id' => Auth::id(),
            ]);
            return $planReport;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanReport $planReport)
    {
        Gate::authorize('view', $planReport);
        return $planReport->load('plan', 'creator');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanReportRequest $request, PlanReport $planReport)
    {
        Gate::authorize('update', $planReport);
        try {
            $dayOfWeek = date('l', strtotime($request->date));
            if (!in_array($dayOfWeek, ['Friday', 'Saturday', 'Sunday'])) {
                return response()->json(['message' => 'You can only create a plan report on Friday, Saturday, or Sunday.'], 422);
            }   
            $planReport->update([
                'plan_id' => $request->plan_id ?? $planReport->plan_id,
                'description' => $request->description ?? $planReport->description,
            ]);
            return $planReport;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanReport $planReport)
    {
        Gate::authorize('delete', $planReport);
        // try {
        //     $planReport->delete();
        //     return response()->json(['message' => 'Plan report deleted successfully.'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => $e->getMessage()], 500);
        // }

        return response()->json(['message' => 'not implemented.'], 200);
    }
}
