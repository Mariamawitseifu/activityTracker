<?php

namespace Database\Seeders;

use App\Models\MainActivity;
use App\Models\Plan;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainActivities = MainActivity::factory(128)->create();

        $unit = Unit::where('name', 'Health System Innovation & Quality')->first();
        foreach ($mainActivities as $value) {
            Plan::updateOrCreate([
                'main_activity_id' => $value->id,
                'unit_id' => $unit->id,
            ]);
        }
    }
}
