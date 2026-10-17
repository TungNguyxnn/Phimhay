<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm() { return view('auth.login'); }

    public function login(Request $r)
    {
        $cred = $r->validate(['email' => 'required|email', 'password' => 'required']);

        if (Auth::attempt($cred + ['is_active' => true], $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        return back()->withErrors(['email' => 'Sai email hoặc mật khẩu, hoặc tài khoản đã bị khóa.'])->onlyInput('email');
    }

    public function registerForm() { return view('auth.register'); }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create($data + ['role' => 'member']);
        Auth::login($user);
        return redirect()->route('home')->with('ok', 'Đăng ký thành công!');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('home');
    }
}
