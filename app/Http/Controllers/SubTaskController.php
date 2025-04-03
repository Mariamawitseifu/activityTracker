<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Http\Requests\StoreSubTaskRequest;
use App\Http\Requests\UpdateSubTaskRequest;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Task $task)
    {
        $subTasks = $task->subTasks->groupBy(function ($subTask) {
            return Carbon::parse($subTask->date)->format('1');
        });
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $groupedSubTasks = [];
        foreach ($weekDays as $index => $day) {
            $groupedSubTasks[$day] = $subTasks->get($day, collect())->values();
        }

        return response()->json($groupedSubTasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubTaskRequest $request, Task $task)
    {
        try {
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
                'date' => $request->$requestedDate,
                'task_id' => $request->task_id,
                'status' => 'todo',
            ]);

            $loggedInUser = User::where('user_id', Auth::id())->first();

            $loggedInUserId = $loggedInUser->id;
            $data = [
                'title' => $loggedInUser->user->name . ' has created a sub task',
                'body' => [
                    'message' => $loggedInUser->user->name . ' has created a sub task',
                    'type' => 'task_approval',
                    'id' => $task->id,
                    'from' => [
                        'id' => $loggedInUserId,
                        'name' => $loggedInUser->user->name,
                        'profile_image' => User::find($loggedInUserId)->user->profile_image,
                    ],
                ],
            ];

            $myParentUnit = $this->getMyParentUnit();

            if ($myParentUnit != null) {
                $manager = User::find($myParentUnit->manager_id);

                // $this->notify($data, User::find($unit_manager->user_id));
            }

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
        return $subTask->load('task');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubTaskRequest $request, SubTask $subTask)
    {
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
        return response('not implemented', 501);
    }
}
