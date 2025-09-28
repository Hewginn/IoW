<?php

namespace Database\Factories;

use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SensorMessage>
 */
class SensorMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sensor_id' => Sensor::factory(),
            'value' => $this->faker->randomFloat(2, 1, 100),
            'created_at' => now(),
            'error_message' => $this->faker->sentence(),
            'value_type' => $this->faker->randomElement(['C', 'cm', '%']),
        ];
    }
}
