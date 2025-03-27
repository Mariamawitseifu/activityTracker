<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitTypes = [
            ['name' => 'Kilogram'],
            ['name' => 'Gram'],
            ['name' => 'Liter'],
            ['name' => 'Milliliter'],
            ['name' => 'Piece'],
        ];

        foreach ($unitTypes as $unitType) {
            UnitType::create($unitType);
        }
    }
}
