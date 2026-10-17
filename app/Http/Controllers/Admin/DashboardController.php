<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\User;
use App\Models\VipPlan;
use App\Models\VipSubscription;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'movieCount' => Movie::count(),
            'userCount' => User::count(),
            'commentCount' => Comment::count(),
            'revenue' => VipSubscription::where('payment_status', 'paid')->with('plan')->get()->sum(fn ($s) => $s->plan->price ?? 0),
            'top' => Movie::orderByDesc('views')->take(5)->get(),
        ]);
    }
}
