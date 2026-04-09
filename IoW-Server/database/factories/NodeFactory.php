<?php


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Node>
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Node;

class NodeFactory extends Factory
{
    protected $model = Node::class;

    public const NODE_1 = [
        'name' => 'node-alpha',
        'password' => 'secret',
        'location' => 'Greenhouse A',
        'status' => 'Online',
        'main_unit' => 'unit-1',
        'control' => true,
        'analyze_images' => true,
    ];

    public const NODE_2 = [
        'name' => 'node-beta',
        'password' => 'secret',
        'location' => 'Greenhouse B',
        'status' => 'Offline',
        'main_unit' => 'unit-2',
        'control' => false,
        'analyze_images' => false,
    ];

    public function definition(): array
    {
        return self::NODE_1;
    }
}
