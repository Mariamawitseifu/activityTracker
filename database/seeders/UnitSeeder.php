<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitManager;
use App\Models\UnitStatus;
use App\Models\UnitType;
use App\Models\User;
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

        $user1 = User::updateOrCreate([
            'username' => 'MOH00002',
        ], [
            'name' => 'Dr. Ayele Teshome',
            'phone' => '251910342855',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit2->id,
            'manager_id' => $user1->id,
            'start_date' => now(),
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


        $user2 = User::updateOrCreate([
            'username' => 'MOH00003',
        ], [
            'name' => 'Dr. Abas Hassen ',
            'phone' => '0913637826',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit7->id,
            'manager_id' => $user2->id,
            'start_date' => now(),
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

        $user3 = User::updateOrCreate([
            'username' => 'MOH00004',
        ], [
            'name' => 'Deneke Ayele ',
            'phone' => '251913637826',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit9->id,
            'manager_id' => $user3->id,
            'start_date' => now(),
        ]);

        $unit10 = Unit::create([
            'name' => 'Healthcare Quality',
            'unit_type_id' => UnitType::where('name', 'Desk')->first()->id,
            'parent_id' => $unit7->id,
        ]);

        UnitManager::create([
            'unit_id' => $unit10->id,
            'manager_id' => $user3->id,
            'start_date' => now(),
        ]);

        $unit11 = Unit::create([
            'name' => 'Leadership & Equity',
            'unit_type_id' => UnitType::where('name', 'Desk')->first()->id,
            'parent_id' => $unit7->id,
        ]);

        $user4 = User::updateOrCreate([
            'username' => 'MOH00005',
        ], [
            'name' => 'Gemu Tiru ',
            'phone' => '251933612966',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit11->id,
            'manager_id' => $user4->id,
            'start_date' => now(),
        ]);

        $unit12 = Unit::create([
            'name' => 'Health Innovation Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit9->id,
        ]);

        $user5 = User::updateOrCreate([
            'username' => 'MOH00006',
        ], [
            'name' => 'Dr. Bereket Zelalem',
            'phone' => '251911456336',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit12->id,
            'manager_id' => $user5->id,
            'start_date' => now(),
        ]);

        $unit13 = Unit::create([
            'name' => 'Healthcare Quality Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $user6 = User::updateOrCreate([
            'username' => 'MOH00007',
        ], [
            'name' => 'Nesredin Nursebo',
            'phone' => '251916392715',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit13->id,
            'manager_id' => $user6->id,
            'start_date' => now(),
        ]);


        $unit14 = Unit::create([
            'name' => 'Healthcare Safety Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $user7 = User::updateOrCreate([
            'username' => 'MOH00008',
        ], [
            'name' => 'Eyobed Kaleb ',
            'phone' => '251911073578',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit14->id,
            'manager_id' => $user7->id,
            'start_date' => now(),
        ]);


        $unit15 = Unit::create([
            'name' => 'Health Facility Accreditation Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $user9 = User::updateOrCreate([
            'username' => 'MOH00010',
        ], [
            'name' => 'Henok Hailu',
            'phone' => '251912233637',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit15->id,
            'manager_id' => $user9->id,
            'start_date' => now(),
        ]);

        $unit16 = Unit::create([
            'name' => 'Infection Prevention and Control (IPC) Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit10->id,
        ]);

        $user10 = User::updateOrCreate([
            'username' => 'MOH00011',
        ], [
            'name' => 'Markos Paulos',
            'phone' => '251911168821',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit16->id,
            'manager_id' => $user10->id,
            'start_date' => now(),
        ]);

        $unit17 = Unit::create([
            'name' => 'Health Equity Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);

        $user8 = User::updateOrCreate([
            'username' => 'MOH00009',
        ], [
            'name' => 'Mezgebu Kebede ',
            'phone' => '251911263375',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit17->id,
            'manager_id' => $user8->id,
            'start_date' => now(),
        ]);


        $unit18 = Unit::create([
            'name' => 'High Impact Leadership Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);


        $user11 = User::updateOrCreate([
            'username' => 'MOH00012',
        ], [
            'name' => 'Shemsedin Bamboro',
            'phone' => '251912175296',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit18->id,
            'manager_id' => $user11->id,
            'start_date' => now(),
        ]);


        $unit19 = Unit::create([
            'name' => 'Learning and KNowledge Management (KLM) Program',
            'unit_type_id' => UnitType::where('name', 'Team')->first()->id,
            'parent_id' => $unit11->id,
        ]);

        $user12 = User::updateOrCreate([
            'username' => 'MOH00013',
        ], [
            'name' => 'Ftalew Dagnew',
            'phone' => '251911061646',
            'password' => bcrypt('password'),
        ]);

        UnitManager::create([
            'unit_id' => $unit19->id,
            'manager_id' => $user12->id,
            'start_date' => now(),
        ]);


        $units = Unit::all();

        foreach ($units as $value) {
            UnitStatus::create([
                'unit_id' => $value->id,
                'status' => 1,
            ]);
        }
    }
}
