<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Node;
use App\Models\Sensor;
use App\Models\SensorMessage;
use App\Models\DataType;
use App\Models\Camera;
use App\Models\Image;
use App\Models\Vision;
use Database\Factories\NodeFactory;

class TestSeeder2 extends Seeder
{
    public function run(): void
    {

        $user = User::factory()->create();

        $temperatureType = DataType::factory()->temperature()->create();
        $humidityType = DataType::factory()->humidity()->create();

        $years = ['2024', '2025'];
        $months = ['03', '04'];
        $days = ['06', '10'];
        $hours = ['06', '07', '10', '11'];
        $minutes = ['00', '30'];

        $values_temperature = [7, 9];
        $values_humidity = [30, 60];

        $messages_temperature = $messages_humidity = $timestamps = [];

        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($days as $day) {
                    foreach ($hours as $hour) {
                        foreach ($minutes as $minute) {
                            $timestamps[] = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute;
                        }
                    }
                }
            }
        }



        $index = 1;

        foreach ($timestamps as $timestamp) {
            $messages_temperature[] = ['value' => $values_temperature[$index], 'created_at' => $timestamp, 'updated_at' => $timestamp, 'error_message' => null];
            $messages_humidity[] = ['value' => $values_humidity[$index], 'created_at' => $timestamp, 'updated_at' => $timestamp, 'error_message' => null];
            $index = ($index + 1) % 2;
        }

        $node = Node::factory()
            ->has(
                Sensor::factory()
                    ->temperature()
                    ->count(1)
                    ->has(
                        SensorMessage::factory()
                            ->count(count($messages_temperature))
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(...$messages_temperature)),
                        'messages'
                    )
            )
            ->has(
                Sensor::factory()
                ->humidity()
                ->count(1)
                ->has(
                    SensorMessage::factory()
                    ->count(count($messages_humidity))
                    ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(...$messages_humidity)), 'messages'
                )
            )
            ->has(
                Camera::factory()
                    ->count(1)
                    ->has(
                        Image::factory()->count(1),
                        'images'
                    )
            )
            ->create();

        $node = Node::factory()
            ->has(
                Sensor::factory()
                    ->temperature()
                    ->count(1)
                    ->has(
                        SensorMessage::factory()
                            ->count(count($messages_temperature))
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(...$messages_temperature)),
                        'messages'
                    )
            )
            ->has(
                Sensor::factory()
                    ->humidity()
                    ->count(1)
                    ->has(
                        SensorMessage::factory()
                            ->count(count($messages_humidity))
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(...$messages_humidity)),
                        'messages'
                    )
            )
            ->has(
                Camera::factory()
                    ->count(1)
                    ->has(
                        Image::factory()->count(1),
                        'images'
                    )
            )
            ->create();
    }
}
