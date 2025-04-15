<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
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

        $fiscalYearRecord = FiscalYear::where('name', '2023-2024')->first(); 

        if (!$fiscalYearRecord) {
            $this->command->error('Fiscal Year 2023-2024 does not exist!');
            return;
        }

        foreach ($mainActivities as $value) {
            Plan::updateOrCreate([
                'main_activity_id' => $value->id,
                'unit_id' => $unit->id,
            ],
            [
                'fiscal_year_id' => $fiscalYearRecord->id,
            ]);
        }
    }
}
