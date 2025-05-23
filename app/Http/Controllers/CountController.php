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
                    "value" => 20,
                ],
                [
                    "month" => 'Mar',
                    "value" => 15,
                ],
                [
                    "month" => 'Apr',
                    "value" => 30,
                ],
                [
                    "month" => 'May',
                    "value" => 10,
                ],
                [
                    "month" => 'Jun',
                    "value" => 45,
                ],
                [
                    "month" => 'Jul',
                    "value" => 10,
                ],
                [
                    "month" => 'Aug',
                    "value" => 65,
                ],
                [
                    "month" => 'Sep',
                    "value" => 20,
                ],
                [
                    "month" => 'Oct',
                    "value" => 10,
                ],
                [
                    "month" => 'Nov',
                    "value" => 65,
                ],
                [
                    "month" => 'Dec',
                    "value" => 15,
                ],
            ],

            // Quarterly values
            "Quarterly" => [
                [
                    "quarter" => 'Q1',
                    "value" => 65,  // Sum of Jan, Feb, Mar
                ],
                [
                    "quarter" => 'Q2',
                    "value" => 85,  // Sum of Apr, May, Jun
                ],
                [
                    "quarter" => 'Q3',
                    "value" => 95,  // Sum of Jul, Aug, Sep
                ],
                [
                    "quarter" => 'Q4',
                    "value" => 90,  // Sum of Oct, Nov, Dec
                ],
            ],

            // Overall Performance
            "OverallPerformance" => [
                "OverallPerformance" => 'Overall',
                "value" => (65 + 85 + 95 + 90) / 4,  // Sum of all months
            ],
        ];
    }

    public function montitorCount(Request $request)
    {
        $fiscalYearId = request('fiscal_year_id');
    
        if (!$fiscalYearId) {
            return response()->json(['message' => 'Fiscal year ID is required'], 422);
        }
    
        $fiscalYear = FiscalYear::find($fiscalYearId);
    
        if (!$fiscalYear || !$fiscalYear->start_date || !$fiscalYear->end_date) {
            return response()->json(['message' => 'Fiscal year not found or incomplete date range'], 404);
        }
    
        $user = Auth::user();
        $lastActive = $this->lastActive(); // Reuse from PlanController
        $myUnit = $lastActive?->unit ?? $this->employeeUnit($user->id);
    
        if (!$myUnit) {
            return response()->json(['message' => 'You are not a manager of any unit'], 403);
        }
    
        $plans = Plan::where('fiscal_year_id', $fiscalYear->id)
            ->where('unit_id', $myUnit->id)
            ->with(['mainActivity', 'monitorings'])
            ->get();
    
        $monthlyPerformance = [];
        $quarterlyBuckets = [[], [], [], []]; 
        $overallTotal = 0;
        $overallCount = 0;
    
        $start = Carbon::parse($fiscalYear->start_date)->startOfMonth();
        $end = Carbon::parse($fiscalYear->end_date)->endOfMonth();
    
        $current = $start->copy();
        $monthIndex = 0;
    
        while ($current->lte($end)) {
            $month = $current->month;
            $year = $current->year;
    
            $totalPerformance = 0;
            $planCount = 0;
    
            foreach ($plans as $plan) {
                $target = $plan->mainActivity->target;
    
                $monitoring = $plan->monitorings
                    ->first(function ($m) use ($month, $year) {
                        return $m->month->month == $month && $m->month->year == $year;
                    });
    
                if ($monitoring && $target > 0) {
                    $performance = ( $target / $monitoring->actual_value) * 100;
                    $totalPerformance += $performance;
                    $planCount++;
                }
            }
    
            $value = $planCount > 0 ? round($totalPerformance / $planCount, 2) : 0;
    
            $monthlyPerformance[] = [
                'month' => $current->format('M'),
                'value' => $value,
            ];
    
            if (!is_null($value)) {
                $quarterIndex = intdiv($monthIndex, 3); 
                $quarterlyBuckets[$quarterIndex][] = $value;
    
                $overallTotal += $value;
                $overallCount++;
            }
    
            // Move to the next month
            $current->addMonth();
            $monthIndex++;
        }
    
        // Calculate quarterly averages
        $quarterlyPerformance = [];
        foreach ($quarterlyBuckets as $i => $quarter) {
            $valid = array_filter($quarter, fn($v) => !is_null($v));
            $avg = count($valid) > 0 ? round(array_sum($valid) / count($valid), 2) : 0;
            $quarterlyPerformance[] = [
                'quarter' => 'Q' . ($i + 1),
                'value' => $avg,
            ];
        }
    
        // Overall performance
        $overall = $overallCount > 0 ? round($overallTotal / $overallCount, 2) : 0;
    
        return [
            'Monthly' => $monthlyPerformance,
            'Quarterly' => $quarterlyPerformance,
            'Overall' => $overall,
        ];
    }
    
    public function countChildUnits()
    {
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

    public function kpiGradeCount()
    {
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

                [
                    'Grade' => 'Very Good',
                    'value' => 100
                ],
                [
                    'Grade' => 'Good',
                    'value' => 80
                ],
                [
                    'Grade' => 'Acceptable',
                    'value' => 60
                ],
                [
                    'Grade' => 'Low',
                    'value' => 40
                ],
                [
                    'Grade' => 'Very Low',
                    'value' => 20
                ],
            ];
        } else {
            return [
                [
                    'Grade' => 'Very Good',
                    'value' => 100
                ],
                [
                    'Grade' => 'Good',
                    'value' => 80
                ],
                [
                    'Grade' => 'Acceptable',
                    'value' => 60
                ],
                [
                    'Grade' => 'Low',
                    'value' => 40
                ],
                [
                    'Grade' => 'Very Low',
                    'value' => 20
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

            if ($mainActivity && $mainActivity->target > 0 && $plan->total_actual > 0) {
                $target = $mainActivity->target;
                $actual = $plan->total_actual;

                $monitoringPercentage = ($target / $actual) * 100;

                $results[] = [
                    'plan_name' => $mainActivity->title,
                    'target' => $target,
                    'weight' => $mainActivity->weight,
                    'actual' => $actual,
                    'monitoring_percentage' => round($monitoringPercentage, 2) . '%',
                ];
            }
        }

        return $results;
    }
}
