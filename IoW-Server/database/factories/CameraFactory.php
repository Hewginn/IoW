<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Camera;

class CameraFactory extends Factory
{
    protected $model = Camera::class;

    public const CAMERA_1 = [
        'name' => 'cam-1',
        'resolution' => '600x400',
        'status' => 'Online',
    ];

    public function definition(): array
    {
        return [
            ...self::CAMERA_1,
        ];
    }
}
