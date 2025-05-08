<?php

namespace App\Http\Controllers;

use App\Models\FiscalYear;
use App\Models\MainActivity;
use App\Models\Monitoring;
use App\Models\Plan;
use App\Models\SubTask;
use App\Models\Task;
use App\Models\Unit;
use App\Traits\UnitTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CountController extends Controller
{
    use UnitTrait;
    public function taskCount(Request $request)
    {
        $request->validate([
            'plan_id' => 'nullable|exists:plans,id',
            'from' => 'nullable|date|before_or_equal:today',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        // Default date range (this week)
        $start = $request->from ? Carbon::parse($request->from) : Carbon::now()->startOfWeek()->subDay();
        $end = $request->to ? Carbon::parse($request->to) : Carbon::now()->endOfWeek()->subDay();

        // Prepare base task query
        $tasksQuery = Task::where('user_id', Auth::id())
            ->whereBetween('date', [$start, $end]);

        if ($request->plan_id) {
            $tasksQuery->where('plan_id', $request->plan_id);
        }

        // Get counts using one query for different statuses
        $taskCounts = $tasksQuery->selectRaw('
            count(*) as total_count,
            sum(status = 0) as pending_count,
            sum(status = 1) as todo_count,
            sum(status = 2) as achieved_count,
            sum(status = 3) as blocked_count,
            sum(status = 4) as inprogress_count,
            sum(status = 5) as rejected_count
        ')->first();

        // Prepare subtask query
        $subTasksQuery = SubTask::whereHas('task', function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });

        if ($request->plan_id) {
            $subTasksQuery->whereHas('task', function ($query) use ($request) {
                $query->where('plan_id', $request->plan_id);
            });
        }

        // Get counts for subtasks
        $subTaskCounts = $subTasksQuery->selectRaw('
            count(*) as total_count,
            sum(status = 2) as achieved_count
        ')->first();

        return [
            'tasks' => [
                'total_count' => (int)$taskCounts->total_count,
                'achieved_count' => (int)$taskCounts->achieved_count,
                'pending_count' => (int)$taskCounts->pending_count,
                'todo_count' => (int)$taskCounts->todo_count,
                'blocked_count' => (int)$taskCounts->blocked_count,
                'inprogress_count' => (int)$taskCounts->inprogress_count,
                'rejected_count' => (int)$taskCounts->rejected_count
            ],
            'subtasks' => [
                'total_count' => (int) $subTaskCounts->total_count,
                'achieved_count' => (int)$subTaskCounts->achieved_count,
            ],
        ];
    }


    //count monitorings actual value change to percentage 'total_actual' => $plan->total_actual, use this for the sum of the actual values
    public function monitoringCount(Request $request)
    {
        return [
            "Monthly" => [
                [
                    "month" => 'Jan',
                    "value" => 30,
                ],
                [
                    "month" => 'Feb',
                    "value" => 60,
                ],
                [
                    "month" => 'Mar',
                    "value" => 45,
                ],
                [
                    "month" => 'Apr',
                    "value" => 80,
                ],
                [
                    "month" => 'May',
                    "value" => 120,
                ],
                [
                    "month" => 'Jun',
                    "value" => 95,
                ],
                [
                    "month" => 'Jul',
                    "value" => 110,
                ],
                [
                    "month" => 'Aug',
                    "value" => 75,
                ],
                [
                    "month" => 'Sep',
                    "value" => 90,
                ],
                [
                    "month" => 'Oct',
                    "value" => 100,
                ],
                [
                    "month" => 'Nov',
                    "value" => 65,
                ],
                [
                    "month" => 'Dec',
                    "value" => 150,
                ],
            ],

            // Quarterly values
            "Quarterly" => [
                [
                    "quarter" => 'Q1',
                    "value" => 135,  // Sum of Jan, Feb, Mar
                ],
                [
                    "quarter" => 'Q2',
                    "value" => 295,  // Sum of Apr, May, Jun
                ],
                [
                    "quarter" => 'Q3',
                    "value" => 275,  // Sum of Jul, Aug, Sep
                ],
                [
                    "quarter" => 'Q4',
                    "value" => 315,  // Sum of Oct, Nov, Dec
                ],
            ],

            // Overall Performance
            "Overall Performance" => [
                "Overall Performance" => 'Overall',
                "value" => 820, // Sum of all months
            ],
        ];
    }

    public function quarterlyCount()
    {
        $lastActive = $this->lastActive();

        if (!$lastActive) {
            return response()->json(['message' => 'You are not associated with any active unit'], 403);
        }

        // Retrieve user's associated unit.
        $myUnit = Unit::find($lastActive->unit_id);

        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }

        // Get all plans for the current user's unit.
        $plans = Plan::where('unit_id', $myUnit->id)->get();

        if ($plans->isEmpty()) {
            return response()->json(['message' => 'No plans found for your unit'], 404);
        // Initialize aggregates.
        $aggregate = 0;
        $totalPlans = $plans->count();
        // Loop through plans and calculate monitoring performance.
        foreach ($plans as $plan) {
            $target = $plan->mainActivity->target;
            $actual = $plan->total_actual;
            if ($target > 0) {
                $aggregate += ($target/$actual ) * 100;
            }
        }

        // Calculate the monitoring percentage across all plans.
        $monitoringPercentage = $aggregate / $totalPlans;

        return response()->json([
            'monitoring_percentage' => $monitoringPercentage,
            'total_plans' => $totalPlans,
        ]);
    }

    }

    public function countChildUnits() {
        // My child unit performance
        $lastActive = $this->lastActive();
        if (!$lastActive) {
            return response()->json(['message' => 'You are not associated with any active unit'], 403);
        }
    
        // Retrieve user's associated unit.
        $myUnit = Unit::find($lastActive->unit_id);
        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
    
        // Query child units by parent_id, similar to the myChildUnits() method.
        $childUnits = Unit::where('parent_id', $myUnit->id)
            ->when(request('search'), function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->when(request('unit_type_id'), function ($query, $unit_type_id) {
                return $query->where('unit_type_id', $unit_type_id);
            })
            ->get();
    
        if ($childUnits->isEmpty()) {
            return response()->json(['message' => 'No child units found for your unit'], 404);
        }
    
        // Initialize an array to store the results for each child unit
        $results = [];
    
        // Loop through child units and calculate monitoring performance.
        foreach ($childUnits as $childUnit) {
            $plans = Plan::where('unit_id', $childUnit->id)->get();
            $totalPlans = $plans->count();  // Count the number of plans for this child unit
            $aggregate = 0;
    
            if ($totalPlans > 0) {
                foreach ($plans as $plan) {
                    $target = $plan->mainActivity->target;
                    $actual = $plan->total_actual;
                    if ($target > 0) {
                        $aggregate += ($actual / $target) * 100;
                    }
                }
                // Calculate the monitoring percentage for this unit
                $monitoringPercentage = $aggregate / $totalPlans;
            } else {
                // No plans, set percentage to 0
                $monitoringPercentage = 0;
            }
    
            // Store the result for this child unit with its name and monitoring percentage
            $results[] = [
                'unit_name' => $childUnit->name,
                'value' => $monitoringPercentage
            ];
        }
    
        // Return the response with the child units and their corresponding values
        return response()->json([
            'data' => $results
        ]);
    }
    
    public function kpiGradeCount() {
        //search by unit and month 
        $search = request('search');
        $month = request('month');
        $lastActive = $this->lastActive();
        if (!$lastActive) {
            return response()->json(['message' => 'You are not associated with any active unit'], 403);
        }
        // Retrieve user's associated unit.
        $myUnit = Unit::find($lastActive->unit_id);
        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
        // Get all plans for the current user's unit.
        $plans = Plan::where('unit_id', $myUnit->id)->get();
        if ($plans->isEmpty()) {
            return response()->json(['message' => 'No plans found for your unit'], 404);
        }
        // Initialize aggregates.
        $aggregate = 0;
        $totalPlans = $plans->count();
        // Loop through plans and calculate monitoring performance.
        foreach ($plans as $plan) {
            $target = $plan->mainActivity->target;
            $actual = $plan->total_actual;
            if ($target > 0) {
                $aggregate += ($actual / $target) * 100;
            }
        }

        // Calculate the monitoring percentage across all plans.
        $monitoringPercentage = $aggregate / $totalPlans;
        if ($search) {
            return [
                'kpi' => [
                    ['Very Good' => 50,
                    'value' => 100],
                    ['Good' => 40,
                    'value' => 80],
                    ['Acceptable' => 30,
                    'value' => 60],
                    ['Low' => 20,
                    'value' => 40],
                    ['Very Low' => 10,
                    'value' => 20],
                ],
            ];
        } else {
            return [
                'kpi' => [
                    ['Very Good' => 50,
                    'value' => 100],
                    ['Good' => 40,
                    'value' => 80],
                    ['Acceptable' => 30,
                    'value' => 60],
                    ['Low' => 20,
                    'value' => 40],
                    ['Very Low' => 10,
                    'value' => 20],
                ],
            ];
            

        }
    }

    public function keyPerformanceIndicator()
    {
        $lastActive = $this->lastActive();
        if (!$lastActive) {
            return response()->json(['message' => 'You are not associated with any active unit'], 403);
        }
    
        // Retrieve user's associated unit.
        $myUnit = Unit::find($lastActive->unit_id);
        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
    
        // Get all plans for the current user's unit.
        $plans = Plan::where('unit_id', $myUnit->id)->get();
        if ($plans->isEmpty()) {
            return response()->json(['message' => 'No plans found for your unit'], 404);
        }
    
        $results = [];
    
        foreach ($plans as $plan) {
            $mainActivity = $plan->mainActivity;
    
            if ($mainActivity && $mainActivity->target > 0) {
                $target = $mainActivity->target;
                $actual = $plan->total_actual;
    
                $monitoringPercentage = ( $target /$actual ) * 100;
    
                $results[] = [
                    'plan_name' => $mainActivity->title,
                    'target' => $target,
                    'weight' => $mainActivity->weight,
                    'actual' => $actual,
                    'monitoring_percentage' => round($monitoringPercentage, 2) . '%',
                ];
            }
        }
    
        return response()->json([
            'total_plans' => count($results),
            'plans' => $results,
        ]);
    }
    

}