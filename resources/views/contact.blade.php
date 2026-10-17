@extends('layouts.app')
@section('title', 'Liên hệ')
@section('content')
<div class="row">
    <div class="col-md-6">
        <h3>Liên hệ với chúng tôi</h3>
        <form method="POST" action="{{ route('contact.send') }}">@csrf
            <div class="mb-3"><label class="form-label">Họ tên</label><input name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required></div>
            <div class="mb-3"><label class="form-label">Nội dung</label><textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea></div>
            <button class="btn btn-warning">Gửi liên hệ</button>
        </form>
    </div>
    <div class="col-md-6">
        <h3>Thông tin</h3>
        <p>📍 Địa chỉ: Hà Nội, Việt Nam</p>
        <p>📧 Email: lienhe@phimhay.test</p>
        <p>☎ Hotline: 0123 456 789</p>
    </div>
</div>
@endsection
