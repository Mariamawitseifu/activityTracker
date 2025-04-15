<?php

namespace App\Http\Controllers;

use App\Models\FiscalYear;
use App\Http\Requests\StoreFiscalYearRequest;
use App\Http\Requests\UpdateFiscalYearRequest;
use Illuminate\Support\Facades\Gate;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', FiscalYear::class);
        return FiscalYear::get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFiscalYearRequest $request)
    {
        Gate::authorize('create', FiscalYear::class);

        try {
            $fiscalYear = FiscalYear::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return $fiscalYear;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating fiscal year',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FiscalYear $fiscalYear)
    {
        Gate::authorize('view', $fiscalYear);
        return $fiscalYear;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFiscalYearRequest $request, FiscalYear $fiscalYear)
    {
        Gate::authorize('update', $fiscalYear);
        try {
            $fiscalYear->update([
                'name' => $request->name ?? $fiscalYear->name,
                'start_date' => $request->start_date ?? $fiscalYear->start_date,
                'end_date' => $request->end_date ?? $fiscalYear->end_date,
            ]);
            return $fiscalYear;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating fiscal year',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FiscalYear $fiscalYear)
    {
        Gate::authorize('delete', $fiscalYear);
        return ("not implemented");
    }
}
