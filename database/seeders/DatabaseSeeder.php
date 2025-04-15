<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use App\Models\Objective;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitTypeSeeder::class,
            UnitSeeder::class,
            FiscalYearSeeder::class,
            MeasuringUnitSeeder::class,
            ObjectiveSeeder::class,
            InitiativeSeeder::class,
            MainActivitySeeder::class,
            PlanSeeder::class,
        ]);
    }
}
