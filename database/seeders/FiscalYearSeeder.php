<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 fiscal years
        FiscalYear::factory(1)->create([
            'start_date' => now()->subYears(10),
            'end_date' => now()->addYears(1),
        ]);
    }
}
