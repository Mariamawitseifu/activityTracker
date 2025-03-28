<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unit1 = Unit::create([
            'name' => 'Minister',
            'unit_type_id' => UnitType::where('name', 'Minister')->first()->id,
            'is_main' => true,
        ]);

        $unit2 = Unit::create([
            'name' => 'Health Service & Program Wing',
            'unit_type_id' => UnitType::where('name', 'State Minister')->first()->id,
            'parent_id' => $unit1->id,
        ]);

        $unit3 = Unit::create([
            'name' => 'Health System Capacity Building Wing',
            'unit_type_id' => UnitType::where('name', 'State Minister')->first()->id,
            'parent_id' => $unit1->id,
        ]);

        $unit4 = Unit::create([
            'name' => 'Health Commodities & Regulatory Wing',
            'unit_type_id' => UnitType::where('name', 'State Minister')->first()->id,
            'parent_id' => $unit1->id,
        ]);

        $unit5 = Unit::create([
            'name' => 'HRH Development & Improvement',
            'unit_type_id' => UnitType::where('name', 'LEO - Lead Executive Officer')->first()->id,
            'parent_id' => $unit3->id,
        ]);

        $unit6 = Unit::create([
            'name' => 'Health Infrastructure',
            'unit_type_id' => UnitType::where('name', 'LEO - Lead Executive Officer')->first()->id,
            'parent_id' => $unit3->id,
        ]);

        $unit7 = Unit::create([
            'name' => 'Health System Innovation & Quality',
            'unit_type_id' => UnitType::where('name', 'LEO - Lead Executive Officer')->first()->id,
            'parent_id' => $unit3->id,
        ]);

        $unit8 = Unit::create([
            'name' => 'Digital Health',
            'unit_type_id' => UnitType::where('name', 'LEO - Lead Executive Officer')->first()->id,
            'parent_id' => $unit3->id,
        ]);

        $unit9 = Unit::create([
            'name' => 'Health Innovation',
            'unit_type_id' => UnitType::where('name', 'Desk')->first()->id,
            'parent_id' => $unit7->id,
        ]);

        $unit10 = Unit::create([
            'name' => 'Healthcare Quality',
            'unit_type_id' => UnitType::where('name', 'Desk')->first()->id,
            'parent_id' => $unit7->id,
        ]);

        $unit11 = Unit::create([
            'name' => 'Leadership & Equity',
            'unit_type_id' => UnitType::where('name', 'Desk')->first()->id,
            'parent_id' => $unit7->id,
        ]);

        $unit12 = Unit::create([
            'name' => 'Health Innovation Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit9->id,
        ]);

        $unit13 = Unit::create([
            'name' => 'Healthcare Quality Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $unit14 = Unit::create([
            'name' => 'Healthcare Safety Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $unit15 = Unit::create([
            'name' => 'Health Facility Accreditation Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $unit16 = Unit::create([
            'name' => 'Infection Prevention and Control (IPC) Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $unit17 = Unit::create([
            'name' => 'Health Equity Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);

        $unit18 = Unit::create([
            'name' => 'High Impact Leadership Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);

        $unit19 = Unit::create([
            'name' => 'Learning and KNowledge Management (KLM) Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);
    }
}
