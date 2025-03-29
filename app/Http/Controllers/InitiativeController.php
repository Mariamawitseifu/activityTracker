<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Http\Requests\StoreInitiativeRequest;
use App\Http\Requests\UpdateInitiativeRequest;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Initiative::when(request('search'), function ($query, $search) {
            return $query->where('title', 'like', "%$search%");
        })->with('objective')->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInitiativeRequest $request)
    {
        try {
            $initiative = Initiative::create([
                'title' => $request->title,
                'objective_id' => $request->objective_id,
            ]);
            return $initiative;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative)
    {
        return $initiative->load('objective');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInitiativeRequest $request, Initiative $initiative)
    {
        try {
            $initiative->update([
                'title' => $request->title ?? $initiative->title,
                'objective_id' => $request->objective_id ?? $initiative->objective_id,
            ]);
            return $initiative;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative)
    {
        return response('not implemented', 501);
    }
}