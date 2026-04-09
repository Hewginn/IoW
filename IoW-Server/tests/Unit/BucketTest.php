<?php

namespace Tests\Unit;

use App\Models\DataType;
use App\Models\SensorMessage;
use App\Services\BucketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\TestSeeder;

class BucketTest extends TestCase
{
    use RefreshDatabase;

    public function test_0_size(): void
    {

        # Seeding the test database
        $this->seed(TestSeeder::class);

        #Loading the service
        $bucketService = new BucketService();

        #Loading the data
        $data_type = DataType::get()->first();

        # Getting the buckets with size 0 for each unit
        $hourBucket = $bucketService->createBucket($data_type);
        $dayBucket = $bucketService->createBucket($data_type, 'day');
        $monthBucket = $bucketService->createBucket($data_type, 'month');
        $yearBucket = $bucketService->createBucket($data_type, 'year');

        # Getting messages for assertion
        $messages = SensorMessage::get();
        $number_of_values = $messages->count();
        $base_values = $messages->pluck('value')->toArray();
        $base_dates = $messages->pluck('created_at')->toArray();

        # Getting the data from the buckets
        $bucket_values = $hourBucket->pluck('values')->toArray();
        $bucket_dates = $monthBucket->pluck('label')->toArray();

        # Checking hour bucket has the right values
        $this->assertEquals($bucket_values, $base_values);
        $this->assertEquals($bucket_dates, $base_dates);
        $this->assertEquals(count($hourBucket), $number_of_values);

        # Checking if all the buckets are the same
        $this->assertEquals($dayBucket, $hourBucket);
        $this->assertEquals($dayBucket, $monthBucket);
        $this->assertEquals($dayBucket, $yearBucket);
    }

    public function test_hour(): void{

        #Load database
        $this->seed(TestSeeder::class);

        #Loading the service
        $bucketService = new BucketService();

        #Loading the data
        $data_type = DataType::get()->first();

        # Getting the buckets with size 0 for each unit
        $hourBucket = $bucketService->createBucket($data_type, 'hour',1);

        # Getting messages for assertion
        $messages = SensorMessage::get();
        $number_of_values = $messages->count();
        $years = ['2024', '2025'];
        $months = ['03', '04'];
        $days = ['06', '10'];
        $hours = ['06', '07', '10', '11'];
        $minutes = ['00', '30'];

        #Hour buckets values
        $bucket_values = $hourBucket->pluck('values')->toArray();
        $value_array = [9, 7];
        $expected_values = array_fill(0, $number_of_values / 2, $value_array);
        $this->assertEquals($bucket_values, $expected_values);
        #Hour buckets dates
        $bucket_starts = $hourBucket->pluck('start')->toArray();
        $expected_starts = [];
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($days as $day) {
                    foreach ($hours as $hour) {
                        $expected_starts[] = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minutes[0] . ':00';
                    }
                }
            }
        }
        $this->assertEquals($bucket_starts, $expected_starts);
    }

    public function test_day(): void{

        #Load database
        $this->seed(TestSeeder::class);

        #Loading the service
        $bucketService = new BucketService();

        #Loading the data
        $data_type = DataType::get()->first();

        $dayBucket = $bucketService->createBucket($data_type, 'day', 1);

        # Getting messages for assertion
        $messages = SensorMessage::get();
        $number_of_values = $messages->count();
        $years = ['2024', '2025'];
        $months = ['03', '04'];
        $days = ['06', '10'];

        #Day buckets values
        $bucket_values = $dayBucket->pluck('values')->toArray();
        $value_array = array_merge(...array_fill(0, 4, [9, 7]));
        $expected_values = array_fill(0, $number_of_values / 8, $value_array);
        $this->assertEquals($bucket_values, $expected_values);
        #Day buckets dates
        $bucket_starts = $dayBucket->pluck('start')->toArray();
        $expected_starts = [];
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($days as $day) {
                    $expected_starts[] = $year . '-' . $month . '-' . $day . ' 00:00:00';
                }
            }
        }
        $this->assertEquals($bucket_starts, $expected_starts);
    }

    public function test_month(): void{

        #Load database
        $this->seed(TestSeeder::class);

        #Loading the service
        $bucketService = new BucketService();

        #Loading the data
        $data_type = DataType::get()->first();

        $monthBucket = $bucketService->createBucket($data_type, 'month', 1);

        # Getting messages for assertion
        $messages = SensorMessage::get();
        $number_of_values = $messages->count();
        $years = ['2024', '2025'];
        $months = ['03', '04'];

        #Month buckets values
        $bucket_values = $monthBucket->pluck('values')->toArray();
        $value_array = array_merge(...array_fill(0, 8, [9, 7]));
        $expected_values = array_fill(0, $number_of_values / 16, $value_array);
        $this->assertEquals($bucket_values, $expected_values);
        #Month buckets dates
        $bucket_starts = $monthBucket->pluck('start')->toArray();
        $expected_starts = [];
        foreach ($years as $year) {
            foreach ($months as $month) {
                $expected_starts[] = $year . '-' . $month . '-01 00:00:00';
            }
        }
        $this->assertEquals($bucket_starts, $expected_starts);
    }

    public function test_year(): void{

        #Load database
        $this->seed(TestSeeder::class);

        #Loading the service
        $bucketService = new BucketService();

        #Loading the data
        $data_type = DataType::get()->first();

        $yearBucket = $bucketService->createBucket($data_type, 'year', 1);

        # Getting messages for assertion
        $messages = SensorMessage::get();
        $number_of_values = $messages->count();
        $years = ['2024', '2025'];

        #Year buckets values
        $bucket_values = $yearBucket->pluck('values')->toArray();
        $value_array = array_merge(...array_fill(0, 16, [9, 7]));
        $expected_values = array_fill(0, $number_of_values / 32, $value_array);
        $this->assertEquals($bucket_values, $expected_values);
        #Year buckets dates
        $bucket_starts = $yearBucket->pluck('start')->toArray();
        $expected_starts = [];
        foreach ($years as $year) {
            $expected_starts[] = $year . '-01-01 00:00:00';
        }
        $this->assertEquals($bucket_starts, $expected_starts);
    }
}
