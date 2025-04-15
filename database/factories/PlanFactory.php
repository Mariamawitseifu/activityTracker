<?php

namespace Database\Factories;

use App\Models\FiscalYear;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mainActivity = \App\Models\MainActivity::factory()->create();
        $unit = Unit::where('name', 'Health System Innovation & Quality')->first();
        $fiscalYear = FiscalYear::where('name', '2023-2024')->first();
        return [
            'main_activity_id' => $mainActivity->id,
            'unit_id' => $unit->id,
            'fiscal_year_id' => $fiscalYear->id,
        ];
    }
}
