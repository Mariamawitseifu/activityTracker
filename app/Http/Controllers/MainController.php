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
        try {
            $main = Main::create([
                'title' => $request->title,
                'inititative_id' => $request->inititative_id,
                'type' => $request->type,
                'weight' => $request->weight,
                'measuring_unit_id' => $request->measuring_unit_id,
            ])->load(['inititative'
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
        return $main->load(['inititative']);
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
        try {
            $main->update([
                'title' => $request->title,
                'inititative_id' => $request->inititative_id,
                'type' => $request->type,
                'weight' => $request->weight,
                'measuring_unit_id' => $request->measuring_unit_id,
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
