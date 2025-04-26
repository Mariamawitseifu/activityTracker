<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\EmployeeUnit;
use App\Models\Role;
use App\Models\UnitEmployee;
use App\Models\UnitManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'nullable|integer',
            'search' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'sort_by' => 'nullable|string|in:name,id,created_at',
            'sort_order' => 'nullable|string|in:asc,desc',
        ]);

        $search = $request->search;
        $perPage = $request->per_page ?? 10;
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';

        if ($sortBy === 'id') {
            $sortBy = 'username';
        }

        $userIds = User::where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->orWhere('username', 'like', "%$search%")
            ->orderBy($sortBy, $sortOrder)
            ->pluck('id');

        $orderByCase = 'CASE ';
        foreach ($userIds as $index => $id) {
            $orderByCase .= "WHEN user_id = '{$id}' THEN {$index} ";
        }
        $orderByCase .= 'ELSE ' . count($userIds) . ' END';


        $employee1 = EmployeeUnit::whereIn('user_id', $userIds)
            ->where('end_date', null)
            ->when($request->unit_id, function ($query) use ($request) {
                $query->where('unit_id', $request->unit_id);
            })->where('user_id', '!=', Auth::id())
            ->with('user.roles')
            ->paginate($perPage)->through(function ($query) {
                return $this->formattedUser($query);
            });

        $employee2 = UnitManager::whereIn('manager_id', $userIds)
            ->where('end_date', null)
            ->when($request->unit_id, function ($query) use ($request) {
                $query->where('unit_id', $request->unit_id);
            })->where('manager_id', '!=', Auth::id())
            ->with('user.roles')
            ->paginate($perPage)->through(function ($query) {

                return $this->formattedUser($query);
            });

        $collection1 = collect($employee1->items());
        $collection2 = collect($employee2->items());

        $employees = $collection1->merge($collection2);


        return $employees;
    }

    public function myChildEmployees()
    {
        // Gate::authorize('viewChild', EmployeeUnit::class);

        $lastActive = $this->lastActive();
        $myUnit = $lastActive ? $lastActive->unit : null;

        $employees = EmployeeUnit::where('unit_id', $myUnit->id)
            ->where('end_date', null)
            ->with('user.roles')
            ->paginate(10)
            ->through(function ($query) {
                return $this->formattedUser($query);
            });
        return $employees;
    }

    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username ?? $this->generateUniqueUsername($request->name),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt('password'),
            ]);

            EmployeeUnit::create([
                'user_id' => $user->id,
                'unit_id' => $request->unit_id,
                'start_date' => $request->started_date,
                'end_date' => $request->end_date,
            ]);

            $user->assignRole('Employee');

            if (isset($request->roles)) {
                $user->assignRole($request->roles);
            }

            DB::commit();

            return response()->json([
                'message' => 'Employee created successfully',
                'employee' =>  $user,
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $employee = EmployeeUnit::where('user_id', $id)->with('user.roles')->firstOrFail();
        return $this->formattedUser($employee);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            if ($request->phone && $request->phone != '') {
                $user = User::where('phone', $request->phone)->where('id', '!=', $id)->first();
                if ($user) {
                    return response()->json([
                        'message' => 'Phone number already exists',
                    ], 422);
                }
            }


            if ($request->email && $request->email != '') {
                $user = User::where('email', $request->email)->where('id', '!=', $id)->first();
                if ($user) {
                    return response()->json([
                        'message' => 'Email already exists',
                    ], 422);
                }
            }



            $employee = EmployeeUnit::where('user_id', $id)->firstOrFail();
            $employee->update([
                'unit_id' => $request->unit_id ?? $employee->unit_id,
                'start_date' => $request->started_date ?? $employee->start_date,
                'end_date' => $request->end_date ?? $employee->end_date,
            ]);

            $user = User::findOrFail($employee->user_id);
            $user->update([
                'name' => $request->name ?? $employee->user->name,
                'email' => $request->email ?? $employee->user->email,
                'phone' => $request->phone ?? $employee->user->phone,
            ]);

            // if (isset($request->roles)) {
            //     $employee->user->syncRoles($request->roles);
            // }

            DB::commit();

            return $this->formattedUser($employee);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $employee = EmployeeUnit::where('user_id', $id)->firstOrFail();
            $employee->update([
                'end_date' => now(),
            ]);

            $user = User::findOrFail($employee->user_id);
            $user->removeRole('Employee');

            DB::commit();

            return response()->json([
                'message' => 'Employee deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function formattedUser($query)
    {
        return [
            'id' => $query->user_id,
            'name' => $query->user->name,
            'username' => $query->user->username,
            'phone' => $query->user->phone,
            'unit_id' => $query->unit_id,
            'unit_name' => $query->unit->name,
            'roles' => $query->user->roles,
        ];
    }

    private function generateUniqueUsername($name)
    {
        $username = Str::slug($name);
        $existingUser = User::where('username', $username)->first();

        if ($existingUser) {
            $username .= rand(1000, 9999);
        }

        while (User::where('username', $username)->exists()) {
            $username = Str::slug($name) . rand(1000, 1000);
        }

        return $username;
    }
}
