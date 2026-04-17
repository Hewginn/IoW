<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vision extends Model
{
    /** @use HasFactory<\Database\Factories\VisionFactory> */
    use HasFactory;

    protected $table = 'visions';

    public $timestamps = false;

    protected $guarded = [];

    public function image() : BelongsTo{
        return $this->belongsTo(Image::class);
    }
}
