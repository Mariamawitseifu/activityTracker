<?php

use App\Http\Controllers\CountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\MainActivityController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MeasuringUnitController;
use App\Http\Controllers\MonitoringController;
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

    Route::resource('fiscal-years', FiscalYearController::class);
    Route::get('get-fiscal-year', [FiscalYearController::class, 'index']);


    Route::resource('unit-types', UnitTypeController::class);
    Route::resource('units', UnitController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('all-units', [UnitController::class, 'all']);

    Route::get('units-i-manage', [MyUnitController::class, 'index']);
    Route::post('active-unit/{unit}', [UnitStatusController::class, 'store']);


    Route::resource('objectives', ObjectiveController::class);

    Route::resource('main-activities', MainActivityController::class);
    Route::resource('initiatives', InitiativeController::class);

    Route::resource('measuring-units', MeasuringUnitController::class);
    Route::get('measuring-units-paginated', [MeasuringUnitController::class, 'indexPaginated']);

    Route::post('plans', [PlanController::class, 'store']);
    Route::post('remove-plans', [PlanController::class, 'removePlan']);
    Route::get('plans/{plan}', [PlanController::class, 'show']);
    Route::get('my-plans', [PlanController::class, 'myPlans']);
    Route::get('my-plans-paginated', [PlanController::class, 'myPlansPaginated']);
    Route::get('unit-plan/{unit}', [PlanController::class, 'unitPlan']);
    Route::get('plans-by-fiscal-year/{fiscal_year}', [PlanController::class, 'getPlansByFiscalYear']);


    Route::get('my-child-units', [UnitController::class, 'myChildUnits']);
    Route::get('my-child-employees', [EmployeeController::class, 'myChildEmployees']);

    Route::resource('tasks', TaskController::class);
    Route::post('change-task-status/{task}', [TaskController::class, 'changeTaskStatus']);
    Route::post('approve-task/{task}', [TaskController::class, 'approveTask']);
    Route::get('pending-tasks', [TaskController::class, 'pendingTasks']);
    Route::get('count-tasks/{user}', [TaskController::class, 'countByUser']);
    Route::get('task-by-fiscalyear/{fiscal_year}', [TaskController::class, 'getTasksByFiscalYear']);


    Route::get('count', [CountController::class, 'index']);


    Route::resource('plan-reports', PlanReportController::class);

    Route::resource('sub-tasks', SubTaskController::class);

    Route::post('tasks/{task}/remarks', [TaskController::class, 'addRemark']);
    Route::get('my-teams', [UnitController::class, 'myTeams']);
    Route::get('get-user-tasks/{user}', [TaskController::class, 'byUser']);
    Route::post('update-sub-task-status/{subTask}', [SubTaskController::class, 'updateStatus']);
    Route::get('my-day', [SubTaskController::class, 'myDay']);



    Route::resource('monitorings', MonitoringController::class);
    Route::post('array-monitorings', [MonitoringController::class, 'storeArrayMonitorings']);


    Route::get('task-count', [CountController::class, 'taskCount']);
    Route::get('monitoring-count', [CountController::class, 'montitorCount']);
    Route::get('monitor-count', [CountController::class, 'monitoringCount']);
    Route::get('child-units-count', [CountController::class, 'countChildUnits']);
    Route::get('kpi-grade-count', [CountController::class, 'kpiGradeCount']);
    Route::get('performance', [CountController::class, 'keyPerformanceIndicator']);
    
    
    Route::get('get-managers', [ManagerController::class, 'getManagers']);
});
