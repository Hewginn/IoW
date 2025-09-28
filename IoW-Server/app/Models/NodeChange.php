<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NodeChange extends Model
{
    protected $guarded = [];

    protected $table = 'node_changes';

    public function node() : BelongsTo{
        return $this->belongsTo(Node::class);
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
