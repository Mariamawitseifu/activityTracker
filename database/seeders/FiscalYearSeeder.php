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
            'name' => '2023-2024',
            'start_date' => '2023-04-01', 
            'end_date' => '2024-03-31', 
        ]);
    }
}
