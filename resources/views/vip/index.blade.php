@extends('layouts.app')
@section('title', 'Gói VIP')
@section('content')
<h3 class="text-center mb-2">Nâng cấp tài khoản VIP</h3>
<p class="text-center text-secondary mb-4">Xem phim độc quyền, không giới hạn. (Thanh toán mang tính mô phỏng cho đồ án)</p>
@if($sub)<div class="alert alert-warning text-center">Bạn đang là VIP đến <strong>{{ $sub->ends_at->format('d/m/Y') }}</strong>. Mua thêm sẽ được cộng dồn thời gian.</div>@endif
<div class="row justify-content-center">
    @foreach($plans as $p)
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100"><div class="card-body d-flex flex-column">
                <h5>{{ $p->name }}</h5>
                <div class="display-6 text-warning my-3">{{ number_format($p->price, 0, ',', '.') }}đ</div>
                <p class="text-secondary">Thời hạn {{ $p->days }} ngày</p>
                @auth
                    <form method="POST" action="{{ route('vip.buy', $p) }}" class="mt-auto" onsubmit="return confirm('Xác nhận mua {{ $p->name }}?')">@csrf
                        <button class="btn btn-warning w-100">Mua ngay</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light mt-auto">Đăng nhập để mua</a>
                @endauth
            </div></div>
        </div>
    @endforeach
</div>
@endsection
