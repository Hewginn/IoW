<?php

namespace Tests\Feature;

use App\Models\Camera;
use App\Models\Node;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;

class MachineVisionIntegrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_store_image()
    {
        $this->seed(TestSeeder::class);

        $node = Node::get()->firstOrFail();

        $camera = Camera::get()->firstOrFail();
        $camera_name = $camera->name;

        $test_file_path = base_path('tests/Images/esca_test.jpg');

        $file = new UploadedFile(
            $test_file_path,
            'esca_test.jpg',
            'image/jpeg',
            null,
            true
        );

        Sanctum::actingAs($node);

        $response = $this->post('/api/sendImage', [
            'camera_name' => $camera_name,
            'image' => $file,
            'error_message' => null,
        ]);

        $response->assertStatus(200);

        $camera_images = $camera->images();

        $this->assertCount(2, $camera_images->get()->toArray());

        $camera_last_image = $camera_images->get()->last();

        $this->assertFalse($camera_last_image->vision()->get()->isEmpty());

        Storage::disk('local')->deleteDirectory('images/1');
    }

    public function test_error_store_image()
    {
        $this->seed(TestSeeder::class);

        $node = Node::get()->firstOrFail();

        $camera = Camera::get()->firstOrFail();
        $camera_name = $camera->name;

        $test_file_path = base_path('tests/Images/esca_test.jpg');

        $file = new UploadedFile(
            $test_file_path,
            'esca_test.jpg',
            'image/jpeg',
            null,
            true
        );

        Sanctum::actingAs($node);

        $response = $this->post('/api/sendImage', [
            'camera_name' => $camera_name,
            'image' => $file,
            'error_message' => "ERROR",
        ]);

        $response->assertStatus(200);

        $camera_images = $camera->images();

        $this->assertCount(2, $camera_images->get()->toArray());

        $camera_last_image = $camera_images->get()->last();


        $this->assertTrue($camera_last_image->vision()->get()->isEmpty());

        Storage::disk('local')->deleteDirectory('images/1');
    }
}
