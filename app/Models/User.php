<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar', 'is_active'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool { return $this->role === 'admin'; }

    public function favorites() { return $this->belongsToMany(Movie::class, 'favorites')->withTimestamps(); }
    public function histories() { return $this->hasMany(WatchHistory::class); }
    public function subscriptions() { return $this->hasMany(VipSubscription::class); }

    public function activeSubscription()
    {
        return $this->subscriptions()->where('payment_status', 'paid')
            ->where('ends_at', '>', now())->orderByDesc('ends_at')->first();
    }

    public function isVip(): bool { return $this->activeSubscription() !== null || $this->isAdmin(); }
}
