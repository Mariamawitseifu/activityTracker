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
            ['name' => 'Minister'],
            ['name' => 'State Minister'],
            ['name' => 'LEO - Lead Executive Officer'],
            ['name' => 'Desk'],
            ['name' => 'Team'],
            ['name' => 'Individual'],
        ];

        foreach ($unitTypes as $unitType) {
            UnitType::create($unitType);
        }
    }
}
