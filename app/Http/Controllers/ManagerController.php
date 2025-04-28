<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ManagerController extends Controller
{

    //get managers
    public function getManagers()
    {
        // Gate::authorize('viewAny', User::class);

        $managers = User::whereHas('roles', function ($query) {
            $query->where('name', 'manager');
        })->paginate();

        return response()->json($managers);
    }
}
