<?php

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataType>
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DataType;

class DataTypeFactory extends Factory
{
    protected $model = DataType::class;

    public const TEMPERATURE = [
        'data_type' => 'temperature',
        'unit' => 'C',
        'max' => 50,
        'image_path' => 'data_types_images/DataTypePlaceHolder.png',
    ];

    public const HUMIDITY = [
        'data_type' => 'humidity',
        'unit' => '%',
        'max' => 100,
        'image_path' => 'data_types_images/DataTypePlaceHolder.png',
    ];

    public function temperature()
    {
        return $this->state(fn () => self::TEMPERATURE);
    }

    public function humidity()
    {
        return $this->state(fn () => self::HUMIDITY);
    }

    public function definition(): array
    {
        return self::TEMPERATURE;
    }
}
