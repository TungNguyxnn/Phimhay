@extends('layouts.app')
@section('title', 'Đăng ký')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
    <h3 class="mb-3">Đăng ký tài khoản</h3>
    <form method="POST" action="{{ route('register') }}">@csrf
        <div class="mb-3"><label class="form-label">Họ tên</label><input name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        <div class="mb-3"><label class="form-label">Mật khẩu (tối thiểu 6 ký tự)</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Nhập lại mật khẩu</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <button class="btn btn-warning w-100">Đăng ký</button>
    </form>
</div></div>
@endsection
