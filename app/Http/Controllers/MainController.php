<?php

namespace App\Http\Controllers;

use App\Models\Main;
use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\UpdateMainRequest;
use Illuminate\Support\Facades\Gate;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Main::class);
        return Main::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMainRequest $request)
    {
        Gate::authorize('create', Main::class);
        try {
            $main = Main::create([
                'title' => $request->title,
                'inititative_id' => $request->inititative_id,
                'main_type' => $request->main_type,
                'weight' => $request->weight,
                'measuring_unit' => $request->measuring_unit,
            ])->load(['inititative', 'unitType', 'unitManager'
            ]);
            return $main;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Main $main)
    {
        Gate::authorize('view', $main);
        return $main->load(['inititative', 'unitType', 'unitManager']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Main $main)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMainRequest $request, Main $main)
    {
        Gate::authorize('update', $main);
        try {
            $main->update([
                'title' => $request->title,
                'inititative_id' => $request->inititative_id,
                'main_type' => $request->main_type,
                'weight' => $request->weight,
                'measuring_unit' => $request->measuring_unit,
            ]);
            return $main;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        Return response()->json(['message' => 'not implemented'], 501);
    }
}
