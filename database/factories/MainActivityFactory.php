<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MainActivity>
 */
class MainActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'initiative_id' => \App\Models\Initiative::factory(),
            'target' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['KPI', 'main activity']),
            'measuring_unit_id' => \App\Models\MeasuringUnit::factory(),
            'weight' => $this->faker->numberBetween(1, 100),
        ];
    }
}
