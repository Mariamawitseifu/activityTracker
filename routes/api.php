<?php

use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\MainActivityController;
use App\Http\Controllers\MeasuringUnitController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::resource('unit-types', UnitTypeController::class);
    Route::resource('units', UnitController::class);
    Route::get('all-units', [UnitController::class, 'all']);

    Route::resource('objectives', ObjectiveController::class);

    Route::resource('main-activities',MainActivityController::class);
    Route::resource('initiatives',InitiativeController::class);
    Route::resource('measuring-units', MeasuringUnitController::class);

    Route::resource('plans', PlanController::class);
});
