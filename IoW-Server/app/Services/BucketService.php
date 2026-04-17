<?php

namespace App\Services;

use Carbon\Carbon;

class BucketService
{
    public function createBucket($messages, $unit = 'hour', $size = 0)
    {
        if ($messages->isEmpty()) {
            return collect();
        }

        if ($size == 0) {
            return $messages->map(fn ($item) => [
                'label' => $item->created_at->format('Y-m-d H:i:s'),
                'values' => $item->value,
            ])->values();
        }

        return $messages
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
                        throw new \InvalidArgumentException("Unsupported unit: $unit");
                }

                return $date->format('Y-m-d H:i:s');
            })
            ->map(function ($group, $bucketStart) use ($unit, $size) {

                $start = Carbon::parse($bucketStart);
                $end = $start->copy()->add($size, $unit);

                return [
                    'label' => $start->format('Y-m-d H:i') . ' - ' . $end->format('Y-m-d H:i'),
                    'values' => $group->pluck('value')->toArray(),
                ];
            })
            ->values();
    }
}

