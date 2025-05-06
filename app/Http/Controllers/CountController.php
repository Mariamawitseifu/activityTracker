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
        $request->validate([
            'fiscal_year_id' => 'required|exists:fiscal_years,id',  
        ]);
    
        $fiscalYear = FiscalYear::find($request->fiscal_year_id);
        if (!$fiscalYear) {
            return response()->json([
                'message' => 'Fiscal year not found',
            ], 404);
        }
    
        $startDate = Carbon::parse($fiscalYear->start_date);
        $endDate = Carbon::parse($fiscalYear->end_date);
    
        // Generate an array of months for the fiscal year
        $monthsData = [];
        $currentMonth = $startDate;
    
        
        while ($currentMonth <= $endDate) {
            $monthNumber = $currentMonth->month;
            
            $monthName = $currentMonth->format('F Y');
            
            $monitoring = Monitoring::whereYear('month', $currentMonth->year)
            ->whereMonth('month', $monthNumber)
            ->sum('actual_value');
            
            $target = MainActivity::whereMonth('created_at', $monthNumber)->first()?->target ?? 0;

            $monthsData[] = [
                'month' => $monthName,
                'total_actual_value' => $monitoring,
                'target' => $target,  
            ];
    
            $currentMonth->addMonth();
        }
    
        return response()->json([
            'fiscal_year_months' => $monthsData,
        ]);
    }


public function countChildUnits()
{
    $units = Unit::all(); 

    $unitsData = $units->map(function ($unit) {
        $childUnitCount = Unit::where('parent_id', $unit->id)->count();
        return [
            'unit_name' => $unit->name, 
            'child_unit_count' => $childUnitCount,
        ];
    });

    return $unitsData;
}

}