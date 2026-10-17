@extends('layouts.app')
@section('title', 'Quản trị')
@section('content')
<h3 class="mb-3">Trang quản trị</h3>
@include('admin._nav')
<div class="row mb-4">
    @foreach([['Phim', $movieCount], ['Người dùng', $userCount], ['Bình luận', $commentCount], ['Doanh thu VIP', number_format($revenue, 0, ',', '.') . 'đ']] as [$l, $v])
        <div class="col-md-3 mb-3"><div class="card text-center"><div class="card-body">
            <div class="text-secondary">{{ $l }}</div><div class="display-6 text-warning">{{ $v }}</div>
        </div></div></div>
    @endforeach
</div>
<h5>Top 5 phim xem nhiều</h5>
<table class="table">
    <thead><tr><th>Phim</th><th>Lượt xem</th></tr></thead>
    <tbody>@foreach($top as $m)<tr><td>{{ $m->title }}</td><td>{{ number_format($m->views) }}</td></tr>@endforeach</tbody>
</table>
@endsection
