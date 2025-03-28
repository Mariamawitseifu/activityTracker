<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use App\Http\Requests\StoreObjectiveRequest;
use App\Http\Requests\UpdateObjectiveRequest;
use Illuminate\Support\Facades\Gate;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Objective::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObjectiveRequest $request)
    {
        try {
            $objective = Objective::create([
                'title' => $request->title,
            ]);
            return $objective;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Objective $objective)
    {
        return $objective;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObjectiveRequest $request, Objective $objective)
    {
        try {
            $objective->update([
                'title' => $request->title,
            ]);
            return $objective;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Objective $objective)
    {
        return response('not implemented', 501);
    }
}
