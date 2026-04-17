<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public const IMAGE_1 = [
        'path' => 'images/test.jpg',
        'error_message' => null,
    ];

    public function definition(): array
    {
        return [
            ...self::IMAGE_1,
        ];
    }
}
