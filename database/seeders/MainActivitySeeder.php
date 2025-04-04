<?php

namespace Database\Seeders;

use App\Models\MainActivity;
use App\Models\Plan;
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
        foreach ($mainActivities as $value) {
            Plan::updateOrCreate([
                'main_activity_id' => $value,
                'unit_id' => $value,
            ]);
        }
    }
}
