<?php

namespace Database\Seeders;

use App\Models\Initiative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitiativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Initiative::factory(10)->create();
    }
}
