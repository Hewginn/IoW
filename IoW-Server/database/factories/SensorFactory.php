<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sensor>
 */
class SensorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['temperature', 'humidity']),
            'node_id' => \App\Models\Node::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'name' => $this->faker->name(),
        ];
    }
}
