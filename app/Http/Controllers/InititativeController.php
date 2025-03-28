<?php

namespace App\Http\Controllers;

use App\Models\Inititative;
use App\Http\Requests\StoreInititativeRequest;
use App\Http\Requests\UpdateInititativeRequest;
use Illuminate\Support\Facades\Gate;

class InititativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Inititative::class);
        return Inititative::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInititativeRequest $request)
    {
        Gate::authorize('create', Inititative::class);
        try {
            $inititative = Inititative::create([
                'title' => $request->title,
                'objective_id' => $request->objective_id,
            ]);
            return $inititative;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inititative $inititative)
    {
        Gate::authorize('view', $inititative);
        return $inititative;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInititativeRequest $request, Inititative $inititative)
    {
        Gate::authorize('update', $inititative);
        try {
            $inititative->update([
                'title' => $request->title,
                'objective_id' => $request->objective_id,
            ]);
            return $inititative;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inititative $inititative)
    {
        Gate::authorize('delete', $inititative);
        return response('not implemented', 501);
    }
}
