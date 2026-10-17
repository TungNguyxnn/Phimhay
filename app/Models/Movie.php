<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];
    protected $casts = ['is_vip' => 'boolean'];

    public function categories() { return $this->belongsToMany(Category::class); }
    public function actors() { return $this->belongsToMany(Actor::class)->withPivot('role_name'); }
    public function episodes() { return $this->hasMany(Episode::class)->orderBy('number'); }
    public function comments() { return $this->hasMany(Comment::class)->latest(); }
    public function ratings() { return $this->hasMany(Rating::class); }

    public function avgRating(): float
    {
        return round((float) $this->ratings()->avg('stars'), 1);
    }

    public function posterUrl(): string
    {
        return $this->poster ?: 'https://placehold.co/300x450/1f4e79/ffffff?text=' . urlencode($this->title);
    }
}
