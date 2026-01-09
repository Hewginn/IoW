<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataType extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'data_types';

    public $timestamps = false;

    public function messages()
    {
        return $this->hasMany(SensorMessage::class);
    }
}
