<?php

use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\MainActivityController;
use App\Http\Controllers\MeasuringUnitController;
use App\Http\Controllers\MyUnitController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanReportController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitStatusController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::resource('unit-types', UnitTypeController::class);
    Route::resource('units', UnitController::class);
    Route::get('all-units', [UnitController::class, 'all']);

    Route::get('units-i-manage', [MyUnitController::class, 'index']);
    Route::post('active-unit/{unit}', [UnitStatusController::class, 'store']);


    Route::resource('objectives', ObjectiveController::class);

    Route::resource('main-activities', MainActivityController::class);
    Route::resource('initiatives', InitiativeController::class);
    Route::resource('measuring-units', MeasuringUnitController::class);

    Route::post('plans', [PlanController::class, 'store']);
    Route::post('remove-plans', [PlanController::class, 'removePlan']);
    Route::get('plans/{plan}', [PlanController::class, 'show']);
    Route::get('my-plans', [PlanController::class, 'myPlans']);
    Route::get('unit-plan/{unit}', [PlanController::class, 'unitPlan']);


    Route::get('my-child-units', [UnitController::class, 'myChildUnits']);

    Route::resource('tasks', TaskController::class);
    Route::post('change-task-status/{task}', [TaskController::class, 'changeTaskStatus']);
    Route::post('approve-task/{task}', [TaskController::class, 'approveTask']);
    Route::get('pending-tasks', [TaskController::class, 'pendingTasks']);

    Route::resource('plan-reports', PlanReportController::class);
    
    Route::resource('sub-tasks', SubTaskController::class);

    Route::post('/tasks/{task}/remarks', [TaskController::class, 'addRemark']);
});
