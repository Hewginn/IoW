<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    /** @use HasFactory<\Database\Factories\SensorFactory> */
    use HasFactory;

    protected $table = 'sensors';

    public $timestamps = false;

    protected $guarded = [];

    public function node() : BelongsTo{
        return $this->belongsTo(Node::class);
    }

    public function messages() : HasMany{
        return $this->hasMany(SensorMessage::class);
    }
}
