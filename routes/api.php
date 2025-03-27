<?php

use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::resource('unit-types', UnitTypeController::class);
Route::resource('units', UnitController::class);    
