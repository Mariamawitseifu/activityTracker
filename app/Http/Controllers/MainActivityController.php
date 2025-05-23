<?php

namespace App\Http\Controllers;

use App\Models\MainActivity;
use App\Http\Requests\StoreMainActivityRequest;
use App\Http\Requests\UpdateMainActivityRequest;
use Illuminate\Support\Facades\Gate;

class MainActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', MainActivity::class);
        return MainActivity::when(request('search'), function ($query, $search) {
            return $query->where('title', 'like', "%$search%")
                ->orWhere('inititative_id', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%")
                ->orWhere('weight', 'like', "%$search%")
                ->orWhere('measuring_unit_id', 'like', "%$search%");
        })->with(['initiative', 'measuringUnit'])->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMainActivityRequest $request)
    {
        Gate::authorize('create', MainActivity::class);
        try {
            $mainActivity = MainActivity::create([
                'title' => $request->title,
                'target' => $request->target,
                'initiative_id' => $request->initiative_id,
                'type' => $request->type,
                'weight' => $request->weight,
                'measuring_unit_id' => $request->measuring_unit_id,
            ]);
            return $mainActivity;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MainActivity $mainActivity)
    {
        Gate::authorize('view', $mainActivity);
        return $mainActivity->load(['initiative', 'measuringUnit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMainActivityRequest $request, MainActivity $mainActivity)
    {
        Gate::authorize('update', $mainActivity);
        try {
            $mainActivity->update([
                'title' => $request->title ?? $mainActivity->title,
                'initiative_id' => $request->initiative_id ?? $mainActivity->initiative_id,
                'target' => $request->target ?? $mainActivity->target,
                'type' => $request->type ?? $mainActivity->type,
                'weight' => $request->weight ?? $mainActivity->weight,
                'measuring_unit_id' => $request->measuring_unit_id ?? $mainActivity->measuring_unit_id,
            ]);
            return $mainActivity->load(['initiative', 'measuringUnit']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainActivity $mainActivity)
    {
        Gate::authorize('delete', $mainActivity);
        return response('not implemented', 501);
    }
}
