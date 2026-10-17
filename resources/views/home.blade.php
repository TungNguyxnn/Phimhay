@extends('layouts.app')
@section('title', 'Trang chủ')
@section('content')
<div class="p-4 p-md-5 mb-4 rounded-3" style="background:linear-gradient(135deg,#1f4e79,#7c3aed)">
    <h1 class="fw-bold">Xem phim online miễn phí & VIP</h1>
    <p class="lead mb-3">Hàng trăm bộ phim lẻ, phim bộ cập nhật mỗi ngày.</p>
    <a href="{{ route('movies.index') }}" class="btn btn-warning btn-lg">Xem ngay</a>
</div>

<div class="mb-4">
    @foreach($categories as $c)
        <a href="{{ route('movies.index', ['category' => $c->id]) }}" class="btn btn-sm btn-outline-light me-1 mb-1">{{ $c->name }}</a>
    @endforeach
</div>

<h4 class="mb-3">🆕 Phim mới cập nhật</h4>
<div class="row">@foreach($latest as $m) @include('movies._card') @endforeach</div>

<h4 class="mb-3 mt-3">🔥 Xem nhiều nhất</h4>
<div class="row">@foreach($hot as $m) @include('movies._card') @endforeach</div>
@endsection
