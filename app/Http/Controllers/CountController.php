<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Task;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function index()
    {
        $tasks = Task::count();
        $plans = Plan::count();


        return response()->json([
            'tasks' => $tasks,
            'plans' => $plans,
        ]);
    }
}
