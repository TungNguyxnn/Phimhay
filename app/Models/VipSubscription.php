<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VipSubscription extends Model
{
    protected $guarded = [];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    public function plan() { return $this->belongsTo(VipPlan::class, 'vip_plan_id'); }
    public function user() { return $this->belongsTo(User::class); }
}
