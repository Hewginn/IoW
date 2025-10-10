<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Node extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\NodeFactory> */
    use HasFactory;
    use HasApiTokens, \Illuminate\Auth\Authenticatable;

    protected $guarded = [];
    protected $hidden = ['password'];

    protected $table = 'nodes';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public $timestamps = false;

    public function sensors() : HasMany{
        return $this->hasMany(Sensor::class);
    }
}
