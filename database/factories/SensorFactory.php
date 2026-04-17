<?php

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sensor>
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sensor;

class SensorFactory extends Factory
{
    protected $model = Sensor::class;

    public function temperature()
    {
        return $this->state(fn () => [
            'type' => 'temperature',
        ]);
    }

    public function humidity()
    {
        return $this->state(fn () => [
            'type' => 'humidity',
        ]);
    }

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'type' => 'temperature',
        ];
    }
}
