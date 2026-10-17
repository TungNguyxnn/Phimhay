@extends('layouts.app')
@section('title', 'Đăng nhập')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
    <h3 class="mb-3">Đăng nhập</h3>
    <form method="POST" action="{{ route('login') }}">@csrf
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        <div class="mb-3"><label class="form-label">Mật khẩu</label><input type="password" name="password" class="form-control" required></div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="rm"><label class="form-check-label" for="rm">Ghi nhớ đăng nhập</label></div>
        <button class="btn btn-warning w-100">Đăng nhập</button>
    </form>
    <p class="mt-3">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
</div></div>
@endsection
