<?php

namespace Database\Seeders;

use App\Models\MeasuringUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasuringUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeasuringUnit::create([
            'name' => 'Number',
        ]);

        MeasuringUnit::create([
            'name' => 'Percentage',
        ]);
    }
}
