<?php

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SensorMessage>
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SensorMessage;
use App\Models\Sensor;
use App\Models\DataType;

class SensorMessageFactory extends Factory
{
    protected $model = SensorMessage::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(2, 10, 30),
            'error_message' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure(): SensorMessageFactory
    {
        return $this->afterCreating(function (SensorMessage $message) {

            $sensor = $message->sensor;

            if (!$sensor) return;

            $dataType = match ($sensor->type) {
                'temperature' => DataType::where('data_type', 'temperature')->first(),
                'humidity' => DataType::where('data_type', 'humidity')->first(),
                default => null,
            };

            if ($dataType) {
                $message->update([
                    'data_type_id' => $dataType->id,
                ]);
            }
        });
    }
}
