<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camera extends Model
{
    /** @use HasFactory<\Database\Factories\CameraFactory> */
    use HasFactory;

    protected $table = 'cameras';

    public $timestamps = false;

    protected $guarded = [];

    public function node() : BelongsTo{
        return $this->belongsTo(Node::class);
    }

    public function images() : HasMany{
        return $this->hasMany(Image::class);
    }
}
