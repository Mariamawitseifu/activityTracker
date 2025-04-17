<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Http\Requests\StoreSubTaskRequest;
use App\Http\Requests\UpdateSubTaskRequest;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', SubTask::class);
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $task = Task::findOrFail($request->task_id);

        $subTasks = $task->subTasks->groupBy(function ($subTask) {
            return Carbon::parse($subTask->date)->format('l');
        });

        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $groupedSubTasks = [];
        foreach ($weekDays as $day) {
            $groupedSubTasks[$day] = $subTasks->get($day, collect());
        }

        return $groupedSubTasks;
    }


    public function updateStatus(Request $request, SubTask $subTask)
    {
        $request->validate([
            'status' => 'required|in:todo,done',
        ]);

        $subTask->update([
            'status' => $request->status,
        ]);

        return $subTask;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubTaskRequest $request)
    {
        Gate::authorize('create', SubTask::class);
        try {
            $task = task::findOrFail($request->task_id);
            if ($task->status === 'done') {
                return response()->json(
                    ['message' => 'You cannot create a subtask for a completed task'],
                    422
                );
            }


            $taskDate = Carbon::parse($task->date);

            $currentStartOfWeek = Carbon::now()->startOfWeek()->subDay();
            $currentEndOfWeek = Carbon::now()->endOfWeek()->subDay();

            if ($taskDate->lessThan($currentStartOfWeek) || $taskDate->greaterThan($currentEndOfWeek)) {
                return response()->json([
                    'error' => 'The task date is not within the current week.',
                ], 400);
            }

            $startOfWeek = $taskDate->copy()->startOfWeek();
            $endOfWeek = $taskDate->copy()->endOfWeek();

            $requestedDate = $taskDate->copy()->next($request->date);

            if ($requestedDate->greaterThan($endOfWeek)) {
                $requestedDate = $requestedDate->subWeek();
            }

            if ($requestedDate->lessThan($startOfWeek)) {
                $requestedDate = $requestedDate->addWeek();
            }

            DB::beginTransaction();

            $subTask = $task->subTasks()->create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $requestedDate,
                'task_id' => $request->task_id,
                'status' => 'todo',
            ]);

            DB::commit();

            return response()->json(
                ['message' => 'Subtask created successfully.', 'subTask' => $subTask],
                201
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubTask $subTask)
    {
        Gate::authorize('view', $subTask);
        return $subTask->load('task');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubTaskRequest $request, SubTask $subTask)
    {
        Gate::authorize('update', $subTask);
        try {

            if ($subTask->parent->status === 'pending') {
                return response()->json(
                    ['message' => 'Task is is not approved yet'],
                    422
                );
            } elseif ($subTask->parent->status === 'rejected') {
                return response()->json(
                    ['message' => 'You can not update sub task for rejected task'],
                    422
                );
            } elseif ($subTask->parent->status === 'cancelled') {
                return response()->json(
                    ['message' => 'You can not update sub task for cancelled task'],
                    422
                );
            } elseif ($subTask->parent->status === 'done') {
                return response()->json(
                    ['message' => 'You can not update sub task for done task'],
                    422
                );
            } else {
                $subTask->update([
                    'title' => $request->title ?? $subTask->title,
                    'description' => $request->description ?? $subTask->description,
                    // 'task_id' => $request->task_id ?? $subTask->task_id,
                ]);
            }

            return $subTask;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubTask $subTask)
    {
        Gate::authorize('delete', $subTask);
        try {
            DB::beginTransaction();

            // $subTask->remarks()->delete();
            $subTask->delete();

            DB::commit();

            return response()->json([
                'message' => 'Employee sub task deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
