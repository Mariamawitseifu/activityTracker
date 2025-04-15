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
        $fiscalYear = FiscalYear::firstOrCreate(
            ['name' => '2023-2024'],
            ['start_date' => '2023-01-01', 'end_date' => '2024-12-31']
        );
        return [
            'main_activity_id' => $mainActivity->id,
            'unit_id' => $unit->id,
            'fiscal_year_id' => $fiscalYear->id,
        ];
    }
}
