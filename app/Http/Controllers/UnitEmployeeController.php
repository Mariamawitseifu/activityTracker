<?php

namespace App\Http\Controllers;

use App\Models\UnitEmployee;
use App\Http\Requests\StoreUnitEmployeeRequest;
use App\Http\Requests\UpdateUnitEmployeeRequest;

class UnitEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UnitEmployee::when(request('search'), function ($query, $search) {
            return $query->where('unit_id', 'like', "%$search%")
                ->orWhere('employee_id', 'like', "%$search%");
        })->with(['unit', 'employee'])->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitEmployee $unitEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitEmployeeRequest $request, UnitEmployee $unitEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitEmployee $unitEmployee)
    {
        //
    }
}
