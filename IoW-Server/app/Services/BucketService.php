<?php

namespace App\Services;

use Carbon\Carbon;

class BucketService{
    public function createBucket($data_type, $unit = 'hour', $size = 0){

        if(is_null($data_type)){
            throw new \InvalidArgumentException("There is no data type");
        }

        if(is_null($data_type->messages())){
            throw new \InvalidArgumentException("There are no messages");
        }

        if($size == 0){
            $chart_data = $data_type->messages()
                ->whereNull('error_message')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'label' => $item->created_at->format('Y-m-d H:i:s'),
                        'values' => $item->value,
                    ];
                })
                ->values();
        }else{
            $chart_data = $data_type->messages()
                ->whereNull('error_message')
                ->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(function ($item) use ($unit, $size) {
                    $date = $item->created_at->copy();
                    switch ($unit) {
                        case 'hour':
                            $bucket = floor($date->hour / $size) * $size;
                            $date->setTime($bucket, 0, 0);
                            break;
                        case 'day':
                            $bucket = floor(($date->day - 1) / $size) * $size + 1;
                            $date->setDate($date->year, $date->month, $bucket)->startOfDay();
                            break;
                        case 'month':
                            $bucket = floor(($date->month - 1) / $size) * $size + 1;
                            $date->setDate($date->year, $bucket, 1)->startOfDay();
                            break;
                        case 'year':
                            $bucket = floor($date->year / $size) * $size;
                            $date->setDate($bucket, 1, 1)->startOfDay();
                            break;
                        default:
                            throw new \InvalidArgumentException("The unit type: $unit is not supported");
                            break;
                    }
                    return $date->format('Y-m-d H:i:s');
                })
                ->map(function ($group, $bucketStart) use ($unit, $size) {

                    $start = Carbon::parse($bucketStart);
                    $end = $start->copy()->add($size, $unit);
                    return [
                        'label' => $start->format('Y-m-d H:i') . ' - ' . $end->format('Y-m-d H:i'),
                        'start' => $start->toDateTimeString(),
                        'end' => $end->toDateTimeString(),
                        'values' => $group->pluck('value')->values()->toArray(),
                    ];
                });
        }
        return $chart_data;
    }
}

