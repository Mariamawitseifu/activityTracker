<?php

use App\Http\Controllers\InititativeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MeasuringUnitController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::resource('unit-types', UnitTypeController::class);
    Route::resource('units', UnitController::class);

    Route::resource('objectives', ObjectiveController::class);

    Route::resource('inititatives', InititativeController::class);
    Route::resource('mains', MainController::class);
    Route::resource('measuring-units', MeasuringUnitController::class);
});
