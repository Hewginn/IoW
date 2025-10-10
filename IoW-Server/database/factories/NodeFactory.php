<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Node>
 */
class NodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'password' => Hash::make('password'),
            'location' => $this->faker->address(),
            'status' => $this->faker->randomElement(['online', 'offline']),
            'main_unit' => $this->faker->randomElement(['arduino', 'raspberrypi']),
        ];
    }
}
