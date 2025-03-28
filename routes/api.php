<?php

use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->group(function () {
    Route::resource('unit-types', UnitTypeController::class);
    Route::resource('units', UnitController::class);    
// });
