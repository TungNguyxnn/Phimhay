@extends('layouts.app')
@section('title', 'Hồ sơ')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
    <h3 class="mb-3">Hồ sơ cá nhân</h3>
    <p>Gói VIP: @if($sub)<span class="badge badge-vip">VIP đến {{ $sub->ends_at->format('d/m/Y') }}</span>@else <span class="badge bg-secondary">Chưa đăng ký</span> <a href="{{ route('vip.index') }}">Mua gói</a>@endif</p>
    <form method="POST" action="{{ route('account.profile.update') }}">@csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" value="{{ $user->email }}" disabled></div>
        <div class="mb-3"><label class="form-label">Họ tên</label><input name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
        <div class="mb-3"><label class="form-label">Mật khẩu mới (bỏ trống nếu không đổi)</label><input type="password" name="password" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Nhập lại mật khẩu mới</label><input type="password" name="password_confirmation" class="form-control"></div>
        <button class="btn btn-warning">Lưu thay đổi</button>
    </form>
</div></div>
@endsection
