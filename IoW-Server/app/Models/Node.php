<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Node extends Model
{
    protected $guarded = [];
    /** @use HasFactory<\Database\Factories\NodeFactory> */
    use HasFactory;

    protected $table = 'nodes';

    public $timestamps = false;

    public function changes() :HasMany
    {
        return $this->hasMany(NodeChange::class);
    }

    public function sensors() : HasMany{
        return $this->hasMany(Sensor::class);
    }
}
