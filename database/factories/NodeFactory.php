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

    public function definition(): array
    {
        static $index = 1;

        return [
            'name' => 'NODE_' . $index++,
            'password' => bcrypt('node1234'),
            'location' => 'LOCATION',
            'status' => 'Online',
            'main_unit' => 'MAIN UNIT',
            'control' => true,
            'analyze_images' => true,
        ];
    }
}
