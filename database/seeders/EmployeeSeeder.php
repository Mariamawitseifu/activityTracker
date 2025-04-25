<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::whereHas('roles', function ($query) {
            $query->where('name', 'Employee');
        })->each(function ($user) {
            $user->employeeUnit()->create([
                'unit_id' => $user->unit_id,
                'start_date' => now(),
                'end_date' => null,
            ]);
        });
    }
}
