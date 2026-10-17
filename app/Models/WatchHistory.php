<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    protected $guarded = [];
    public function episode() { return $this->belongsTo(Episode::class); }
}
