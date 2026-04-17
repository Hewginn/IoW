<?php

namespace Tests\Feature;

use App\Models\DataType;
use App\Models\Sensor;
use App\Models\User;
use Database\Seeders\TestSeeder2;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetDataTest extends TestCase
{

    use RefreshDatabase;

    public function test_data_type(): void
    {
        $this->seed(TestSeeder2::class);

        $user = User::get()->firstorFail();

        $data_type = DataType::get()->where('data_type', 'temperature')->firstOrFail();

        $response = $this->actingAs($user)->get(route("data.show", $data_type));
        $temperatureMessagesIds = $data_type->messages()->pluck('id')->toArray();

        $response->assertViewHas('raw_data', function ($rawData) use ($temperatureMessagesIds) {
            $ids = $rawData->pluck('id')->toArray();
            foreach ($ids as $id) {
                if (!in_array($id, $temperatureMessagesIds)) {
                    return false;
                }
            }
            return true;
        });
    }

    public function test_sensor_filter(): void
    {
        $this->seed(TestSeeder2::class);

        $user = User::get()->firstorFail();

        $sensor = Sensor::get()->firstOrFail();

        $response = $this->actingAs($user)->get(route("sensors.show", $sensor));

        $sensorMessagesIds = $sensor->messages()->pluck('id')->toArray();

        $response->assertViewHas('sensorMessages', function ($messages) use ($sensorMessagesIds) {
            $ids = $messages->pluck('id')->toArray();
            foreach ($ids as $id) {
                if (!in_array($id, $sensorMessagesIds)) {
                    return false;
                }
            }
            return true;
        });
    }
}
