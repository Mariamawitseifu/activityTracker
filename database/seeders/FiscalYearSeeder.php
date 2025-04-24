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
        FiscalYear::firstOrCreate([
            'name' => '2023-2024',
            'start_date' => '2024-04-01',
            'end_date' => '2025-12-31',
        ]);
    }
}
