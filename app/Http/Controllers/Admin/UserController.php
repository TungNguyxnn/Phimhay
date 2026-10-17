<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->paginate(15)]);
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể khóa chính mình.');
        }
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('ok', 'Đã cập nhật trạng thái tài khoản.');
    }
}
