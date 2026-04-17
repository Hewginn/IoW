<?php

namespace Tests\Feature;

use App\Models\Node;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NodeAddTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_node_and_redirects()
    {
        # Seeding the test database
        $this->seed(TestSeeder::class);

        $user = User::get()->first();

        $response = $this->actingAs($user)->post(route('nodes.store'), [
            'name' => 'Test Node',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'location' => 'Test Location',
            'status' => 'Online',
            'main_unit' => 'Unit A',
            'control' => true,
            'analyze_images' => false,
        ]);

        // Assert redirect
        $response->assertRedirect(route('nodes.index'));

        // Assert database has the record
        $this->assertDatabaseHas('nodes', [
            'name' => 'Test Node',
            'status' => 'Online',
            'location' => 'Test Location',
        ]);

        $node = Node::where('name', 'Test Node')->first();

        Sanctum::actingAs($node);

        $response = $this->post('/api/updateNode', [
            'location' => 'Test Location 2',
            'status' => 'Offline',
            'main_unit' => 'Unit A',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('nodes', [
            'name' => 'Test Node',
            'status' => 'Offline',
            'location' => 'Test Location 2',
        ]);
    }

    public function test_store_requires_authentication()
    {
        # Seeding the test database
        $this->seed(TestSeeder::class);

        $response = $this->post(route('nodes.store'), []);

        $response->assertRedirect(route('login'));
    }

    public function test_store_validation_fails()
    {
        # Seeding the test database
        $this->seed(TestSeeder::class);

        $user = User::get()->first();

        $response = $this->actingAs($user)->post(route('nodes.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'password',
            'status',
        ]);
    }
}
