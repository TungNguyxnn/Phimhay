<?php

namespace App\Http\Controllers;

use App\Models\VipPlan;
use App\Models\VipSubscription;
use Illuminate\Http\Request;

class VipController extends Controller
{
    public function index(Request $r)
    {
        return view('vip.index', [
            'plans' => VipPlan::orderBy('price')->get(),
            'sub' => $r->user()?->activeSubscription(),
        ]);
    }

    // Mô phỏng thanh toán: ghi nhận đăng ký ngay (đồ án không tích hợp cổng thanh toán thật)
    public function buy(Request $r, VipPlan $plan)
    {
        $current = $r->user()->activeSubscription();
        $start = $current ? $current->ends_at : now();

        VipSubscription::create([
            'user_id' => $r->user()->id,
            'vip_plan_id' => $plan->id,
            'starts_at' => $start,
            'ends_at' => (clone $start)->addDays($plan->days),
            'payment_status' => 'paid',
        ]);
        return redirect()->route('vip.index')->with('ok', "Mua gói {$plan->name} thành công!");
    }
}
