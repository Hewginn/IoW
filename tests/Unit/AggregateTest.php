<?php

namespace Tests\Unit;

use App\Services\AggregateService;
use PHPUnit\Framework\TestCase;

class AggregateTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_avg(): void
    {
        $s = new AggregateService();

        $values = [[-6.5, 10, 32, 100]];
        $expected_result = array_sum($values[0]) / count($values[0]);

        $avgFunc = $s->avg($values[0]);
        $aggregateFunc = $s->aggregate($values, 'avg');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_sum(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 10, 32, 100];
        $expected_result = array_sum($values);

        $avgFunc = $s->sum($values);
        $aggregateFunc = $s->aggregate([$values], 'sum');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_max(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 10, 32, 100];
        $expected_result = max($values);

        $avgFunc = $s->max($values);
        $aggregateFunc = $s->aggregate([$values], 'max');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_min(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 10, 32, 100];
        $expected_result = min($values);

        $avgFunc = $s->min($values);
        $aggregateFunc = $s->aggregate([$values], 'min');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_median(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 32, 10, 100];

        $avgFunc = $s->median($values);
        $aggregateFunc = $s->aggregate([$values], 'median');

        sort($values);
        $middle = (int) floor(count($values) / 2);
        if(count($values) % 2 === 1){
            $expected_result = $values[$middle];
        }else{
            $expected_result = ($values[$middle - 1] + $values[$middle]) / 2;
        }

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_mode(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 10, 32, 100, 100];
        $values_to_string = array_map(fn($v) => (string) round($v, 2), $values);
        $modes = array_map('floatval' , array_keys(array_count_values($values_to_string), max(array_count_values($values_to_string))));
        $expected_result = array_sum($modes) / count($modes);

        $avgFunc = $s->mode($values);
        $aggregateFunc = $s->aggregate([$values], 'mode');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }

    public function test_count(): void
    {
        $s = new AggregateService();

        $values = [-6.5, 10, 32, 100, 100];
        $expected_result = count($values);

        $avgFunc = $s->count($values);
        $aggregateFunc = $s->aggregate([$values], 'count');

        $this->assertEquals($expected_result, $aggregateFunc[0], $avgFunc);
    }
}
