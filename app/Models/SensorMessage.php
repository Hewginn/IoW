<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorMessage extends Model
{
    /** @use HasFactory<\Database\Factories\SensorMessageFactory> */
    use HasFactory;

    protected $table = 'sensor_messages';

    public $timestamps = true;

    protected $guarded = [];

    public function sensor() : BelongsTo{
        return $this->belongsTo(Sensor::class);
    }

    public function dataType() : BelongsTo{
        return $this->belongsTo(DataType::class);
    }
}
