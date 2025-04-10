<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
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

            $myUnit = $this->getMyUnit();

            if (!$myUnit != null) {
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
        return $task->load('plan.mainActivity', 'subTasks', 'user');
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

    // public function approveTask(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'status' => 'required|in:approved,rejected',
    //     ]);

    //     $loggedInUser = User::where('id', Auth::id())->first();
    //     $myUnit = $this->getMyUnit();

    //     if ($myUnit == null) {
    //         return response()->json(
    //             ['message' => 'You are not authorized to approve task'],
    //             422
    //         );
    //     }

    //     $task = User::find($task->id);

    //     $userName = $task->user->name;

    //     $userUnit = $task->unit->unit->id;

    //     if ($task->status === 'pending') {

    //         $task->update([
    //             'status' => $request->status === 'approved' ? 'todo' : 'rejected',
    //         ]);
    //     } else {
    //         return response()->json(
    //             ['message' => 'Task is already approved '],
    //             422
    //         );
    //     }

    //     $loggedInUser = User::where('id', Auth::id())->first();
    //     $data = [
    //         'title' =>  'Your task has been ' . $request->status,
    //         'body' => [
    //             'message' =>  'Your task has been ' . $request->status,
    //             'type' => 'task',
    //             'id' => $task->id,
    //             'from' => [
    //                 'id' => $loggedInUser->id,
    //                 'name' => $loggedInUser->user->name,
    //                 'profile_image' => User::find($loggedInUser->id)->user->profile_image,
    //             ],
    //         ],
    //     ];

    //     // $this->notify($data, User::find($task->user_id));

    //     return $task;
    // }
    // public function pendingTasks(Request $request)
    // {

    //     $request->validate([
    //         // 'fiscal_year_id' => 'required|uuid|exists:fiscal_years,id',
    //         'from' => 'nullable|date|before_or_equal:today',
    //         'to' => 'required_with:from|date|after_or_equal:from|before_or_equal:today',
    //         // 'kpi_tracker_id' => 'nullable|uuid|exists:k_p_i_trackers,id',
    //     ]);

    //     $perPage = request('per_page') ?? 50;
    //     $loggedInUser = User::where('id', Auth::id())->first();
    //     $myUnit = $this->getMyUnit();

    //     $tasks = Task::latest()
    //         ->when(! $request->has(['from', 'to']), function ($query) {
    //             $start = Carbon::now()->startOfWeek()->subDay();
    //             $end = Carbon::now()->endOfWeek()->subDay();
    //             $query->whereBetween('date', [$start, $end]);
    //         }, function ($query) use ($request) {
    //             $from = $request->from ?: Carbon::now()->startOfWeek();
    //             $to = $request->to ?: Carbon::now()->endOfWeek();
    //             $query->whereBetween('date', [$from, $to]);
    //         })
    //         // ->whereHas('plan', function ($query) use ($request) {
    //         //     $query->where('fiscal_year_id', $request->fiscal_year_id);
    //         // })
    //         ->whereHas('user', function ($query) use ($myUnit) {
    //             $query->whereHas('unit', function ($query) use ($myUnit) {
    //                 $query->where('unit_id', $myUnit->id);
    //             });
    //         })->with('user')
    //         ->where('status', 0)
    //         ->paginate($perPage);

    //     return response()->json($tasks);
    // }
    // public function updateStatus(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'status' =>  'required|in:todo,done,blocked,inprogress',
    //     ]);
    //     if ($task->status == 'pending') {
    //         return response()->json([
    //             'message' => 'Task is not approved yet'],
    //             422
    //         );
    //     $loggedInUser = User::where('id', Auth::id())->first();

    //     $data = [
    //         'title' => $loggedInUser->user->name . 'has updated a task',
    //         'body' => [
    //             'message' => $loggedInUser->user->name . ' has updated a task',
    //             'type' => 'task_update',
    //             'id' => $task->id,
    //             'from' => [
    //                 'id' => $loggedInUser->id,
    //                 'name' => $loggedInUser->user->name,
    //                 'profile_image' => User::find($loggedInUser->id)->user->profile_image,
    //             ],
    //         ],
    //     ];
    //     $myParentUnit = $this->getMyParentUnit();

    //     if ($myParentUnit != null) {
    //         $manager = User::find($myParentUnit->manager_id);

    //         // $this->notify($data, User::find($manager->user_id));


    //     }
    //     $task->update([
    //         'status' => $request->status,
    //     ]);
    //     return $task;
    // }
    // }

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
}
