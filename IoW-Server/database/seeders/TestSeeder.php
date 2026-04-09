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

class TestSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::factory()->create();

        $temperatureType = DataType::factory()->temperature()->create();

        $years = ['2024', '2025'];
        $months = ['03', '04'];
        $days = ['06', '10'];
        $hours = ['06', '07', '10', '11'];
        $minutes = ['00', '30'];

        $values = [7, 9];

        $timestamps = [];

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

        $messages = [];

        $index = 1;

        foreach ($timestamps as $timestamp) {
            $messages[] = ['value' => $values[$index], 'created_at' => $timestamp, 'updated_at' => $timestamp, 'error_message' => null];
            $index = ($index + 1) % 2;
        }

        $node = Node::factory()
            ->has(
                Sensor::factory()
                    ->temperature()
                    ->count(1)
                    ->has(
                        SensorMessage::factory()
                            ->count(count($messages))
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(...$messages)),
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
            ->create(NodeFactory::NODE_1);
    }
}
