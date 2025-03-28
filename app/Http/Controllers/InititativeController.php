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
        return Inititative::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInititativeRequest $request)
    {
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
        return $inititative;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInititativeRequest $request, Inititative $inititative)
    {
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
        return response('not implemented', 501);
    }
}
