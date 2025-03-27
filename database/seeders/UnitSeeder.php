<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Unit 1', 'unit_type_id' => '1'],
            ['name' => 'Unit 2', 'unit_type_id' => '1'],
            ['name' => 'Unit 3', 'unit_type_id' => '2'],
            ['name' => 'Unit 4', 'unit_type_id' => '2'],
            ['name' => 'Unit 5', 'unit_type_id' => '3'],
            ['name' => 'Unit 6', 'unit_type_id' => '3'],
            ['name' => 'Unit 7', 'unit_type_id' => '4'],
            ['name' => 'Unit 8', 'unit_type_id' => '4'],
            ['name' => 'Unit 9', 'unit_type_id' => '5'],
            ['name' => 'Unit 10', 'unit_type_id' => '5'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
