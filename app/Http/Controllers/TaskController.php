<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return Auth::user()->roles->load('permissions');
        Gate::authorize('viewAny', Task::class);
        return $this->getTasks($request, Auth::id());
    }

    private function getTasks(Request $request, $userId)
    {
        Gate::authorize('viewAny', Task::class);
        $perPage = 50;

        if ($request->from && $request->to) {
            $start = Carbon::parse($request->from);
            $end = Carbon::parse($request->to);
        } else {
            $start = Carbon::now()->startOfWeek()->subDay();
            $end = Carbon::now()->endOfWeek()->subDay();
        }


        $tasks = Task::latest()
            ->whereBetween('date', [$start, $end])
            ->when($request->plan_id, function ($query) use ($request) {
                $query->where('plan_id', $request->plan_id);
            })
            ->whereHas('plan')
            ->with('plan.mainActivity', 'subTasks')
            ->where('user_id', $userId)
            ->paginate($perPage);

        $tasks->getCollection()->transform(function ($task) {
            $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $groupedSubTasks = [];

            foreach ($weekDays as $day) {
                $groupedSubTasks[$day] = $task->subTasks->filter(function ($subTask) use ($day) {
                    return Carbon::parse($subTask->date)->format('l') === $day;
                })->values();
            }

            $task->sub_tasks = $groupedSubTasks;

            return $task;
        });

        $tasks->makeHidden('subTasks');

        return response()->json($tasks);
    }


    //     /**
    //      * Store a newly created resource in storage.
    //      */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);
        try {
            DB::beginTransaction();

            $isMyPlan = Plan::where('id', $request->plan_id)
                ->whereHas('unit', function ($query) {
                    $query->whereHas('manager', function ($query) {
                        $query->where('manager_id', Auth::id());
                    });
                })->exists();

            if (!$isMyPlan) {
                return response()->json([
                    'message' => 'You are not allowed to create task for this plan',
                ], 403);
            }


            $myUnit = $this->getMyUnit();

            if (!$myUnit != null && Auth::user()->username == 'MOH00003') {
                $status = 'todo';
            } else {
                $status = 'pending';
            }

            $task = Task::create([
                'plan_id' => $request->plan_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'date' => Carbon::today(),
                'status' => $status,
            ]);

            DB::commit();


            return $task;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        return $task->load('plan.mainActivity', 'subTasks', 'user', 'remarks');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        try {
            $task->update([
                'title' => $request->title ?? $task->title,
                'description' => $request->description ?? $task->description,
                'date' => $request->date ?? $task->date,
                'plan_id' => $request->plan_id ?? $task->plan_id,
            ]);
            return $task;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function approveTask(Request $request, Task $task)
    {
        Gate::authorize('approveTask', $task);

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);


        $isMyChild = $this->isMyChild($task->user_id);

        if (!$isMyChild) {
            return response()->json([
                'message' => 'You are not allowed to approve this task',
            ], 403);
        }

        if ($task->status === 'pending') {

            $task->update([
                'status' => $request->status === 'approved' ? 'todo' : 'rejected',
            ]);
        } else {
            return response()->json(
                ['message' => 'Task is already approved '],
                422
            );
        }


        return $task;
    }
    
    public function pendingTasks(Request $request)
    {
        Gate::authorize('pendingTasks', Task::class);

        $request->validate([
            'from' => 'nullable|date|before_or_equal:today',
            'to' => 'required_with:from|date|after_or_equal:from|before_or_equal:today',
            'plan' => 'nullable|uuid|exists:plans,id',
        ]);

        $perPage = request('per_page') ?? 50;
        $myUnit = $this->lastActive();
        $tasks = Task::latest()
            ->when(! $request->has(['from', 'to']), function ($query) {
                $start = Carbon::now()->startOfWeek()->subDay();
                $end = Carbon::now()->endOfWeek()->subDay();
                $query->whereBetween('date', [$start, $end]);
            }, function ($query) use ($request) {
                $from = $request->from ?: Carbon::now()->startOfWeek();
                $to = $request->to ?: Carbon::now()->endOfWeek();
                $query->whereBetween('date', [$from, $to]);
            })
            ->whereHas('plan', function ($query) use ($myUnit) {
                $query->whereHas('parent', function ($query) use ($myUnit) {
                    $query->where('unit_id', $myUnit->unit->id);
                });
            })
            // ->whereHas('user', function ($query) use ($myUnit) {
            //     $query->whereHas('unit', function ($query) use ($myUnit) {
            //         $query->where('unit_id', $myUnit->id);
            //     });
            // })
            ->where('status', 0)
            ->paginate($perPage);

        return response()->json($tasks);
    }
    public function changeTaskStatus(Request $request, Task $task)
    {
        Gate::authorize('changeStatus', $task);
        $request->validate([
            'status' =>  'required|in:done,blocked,inprogress',
        ]);
        if ($task->status == 'pending') {
            return response()->json([
                'message' => 'Task is not approved yet'
            ], 422);
        }

        $task->update([
            'status' => $request->status,
        ]);
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        try {
            DB::beginTransaction();

            if ($task->subTasks()->exists()) {
                return response()->json([
                    'message' => 'Cannot delete task because it has ' . $task->subTasks()->count() . ' sub task' . ($task->subTasks()->count() > 1 ? 's' : ''),
                ], 400);
            }

            $task->delete();

            DB::commit();

            return response()->json([
                'message' => 'Employee task deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addRemark(Request $request, Task $task)
    {
        Gate::authorize('addRemark', $task);

        $request->validate([
            'remark' => 'required|string',
            // 'remarkable_type' => 'required|in:task',
        ]);

        $task->remarks()->create([
            'remark' => $request->remark,
            'remarkable_type' => Task::class
        ]);

        return $task->load('remarks');
    }
}
