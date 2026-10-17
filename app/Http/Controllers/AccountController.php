<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function favorites(Request $r)
    {
        return view('account.favorites', ['movies' => $r->user()->favorites()->latest('favorites.created_at')->get()]);
    }

    public function history(Request $r)
    {
        $items = $r->user()->histories()->with('episode.movie')->latest('updated_at')->take(50)->get();
        return view('account.history', compact('items'));
    }

    public function profile(Request $r) { return view('account.profile', ['user' => $r->user(), 'sub' => $r->user()->activeSubscription()]); }

    public function updateProfile(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|max:100',
            'password' => 'nullable|min:6|confirmed',
        ]);
        $user = $r->user();
        $user->name = $data['name'];
        if (!empty($data['password'])) $user->password = $data['password'];
        $user->save();
        return back()->with('ok', 'Đã cập nhật hồ sơ.');
    }
}
