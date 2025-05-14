<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use App\Models\MainActivity;
use App\Models\Plan;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainActivities = MainActivity::all();
        $unit = Unit::where('name', 'Health System Innovation & Quality')->first();
        $fiscalYear = FiscalYear::first();
        foreach ($mainActivities as $value) {
            Plan::create([
                'main_activity_id' => $value->id,
                'unit_id' => $unit->id,
                'fiscal_year_id' => $fiscalYear->id,
            ]);
        }
    }
}
