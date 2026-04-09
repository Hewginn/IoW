<?php

namespace Tests\Feature;

use App\Models\DataType;
use App\Models\Node;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SendDataTest extends TestCase
{

    use RefreshDatabase;

    public function test_existing_data_type(): void
    {
        $this->seed(TestSeeder::class);

        $node = Node::get()->first();
        $sensor = $node->sensors()->get()->first();
        $data_type = DataType::get()->first();

        Sanctum::actingAs($node);

        $response = $this->post('/api/sendData', [
            'sensor_name' => $sensor->name,
            'value_type' => $data_type->data_type,
            'value' => 100,
            'unit' => 'unit',
            'max' => 50,
            'error_message' => null,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sensor_messages', [
            'sensor_id' => $sensor->id,
            'value' => 100,
            'data_type_id' => $data_type->id,
        ]);
    }

    public function test_new_data_type(): void
    {
        $this->seed(TestSeeder::class);

        $node = Node::get()->first();
        $sensor = $node->sensors()->get()->first();

        Sanctum::actingAs($node);

        $response = $this->post('/api/sendData', [
            'sensor_name' => $sensor->name,
            'value_type' => 'UV',
            'value' => 5,
            'unit' => 'INDEX',
            'max' => 10,
            'error_message' => null,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('data_types', [
            'data_type' => 'UV',
        ]);

        $uv_data_type = DataType::get()->where('data_type', 'UV')->first();

        $this->assertDatabaseHas('sensor_messages', [
            'sensor_id' => $sensor->id,
            'value' => 5,
            'data_type_id' => $uv_data_type->id,
        ]);
    }

    public function test_error(): void
    {
        $this->seed(TestSeeder::class);

        $node = Node::get()->first();
        $sensor = $node->sensors()->get()->first();
        $data_type = DataType::get()->first();

        Sanctum::actingAs($node);

        $response = $this->post('/api/sendData', [
            'sensor_name' => $sensor->name,
            'value_type' => $data_type->data_type,
            'value' => 100,
            'unit' => 'unit',
            'max' => 50,
            'error_message' => "ERROR",
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sensor_messages', [
            'sensor_id' => $sensor->id,
            'value' => 100,
            'data_type_id' => $data_type->id,
            'error_message' => "ERROR",
        ]);
    }
}
