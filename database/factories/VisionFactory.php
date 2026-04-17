<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vision;

class VisionFactory extends Factory
{
    protected $model = Vision::class;

    public const VISION_1 = [
        'result' => 'healthy',
        'healthy' => 0.95,
        'black_rot' => 0.01,
        'esca' => 0.01,
        'downy_mildew' => 0.02,
        'powdery_mildew' => 0.01,
    ];

    public function definition(): array
    {
        return [
            ...self::VISION_1,
            'image_id' => \App\Models\Image::factory(),
        ];
    }
}
