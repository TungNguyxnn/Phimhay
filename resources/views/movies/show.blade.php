@extends('layouts.app')
@section('title', $movie->title)
@section('content')
<div class="row">
    <div class="col-md-3 mb-3"><img src="{{ $movie->posterUrl() }}" class="img-fluid rounded" alt="{{ $movie->title }}"></div>
    <div class="col-md-9">
        <h2>{{ $movie->title }} @if($movie->is_vip)<span class="badge badge-vip">VIP</span>@endif</h2>
        @if($movie->original_title)<div class="text-secondary mb-2">{{ $movie->original_title }}</div>@endif
        <p>
            <span class="badge bg-secondary">{{ $movie->year }}</span>
            <span class="badge bg-secondary">{{ $movie->country }}</span>
            <span class="badge bg-secondary">{{ $movie->type === 'bo' ? 'Phim bộ' : 'Phim lẻ' }}</span>
            @if($movie->duration)<span class="badge bg-secondary">{{ $movie->duration }} phút</span>@endif
            <span class="badge bg-secondary">👁 {{ number_format($movie->views) }}</span>
            <span class="badge bg-warning text-dark">★ {{ $avg ?: 'Chưa có' }}</span>
        </p>
        <p>
            @foreach($movie->categories as $c)
                <a href="{{ route('movies.index', ['category' => $c->id]) }}" class="badge text-bg-primary">{{ $c->name }}</a>
            @endforeach
        </p>
        <p>{{ $movie->description }}</p>
        @if($movie->actors->count())
            <p><strong>Diễn viên:</strong> {{ $movie->actors->map(fn($a) => $a->name . ($a->pivot->role_name ? " ({$a->pivot->role_name})" : ''))->join(', ') }}</p>
        @endif

        <div class="d-flex gap-2 mb-3">
            @if($movie->episodes->count())
                <a href="{{ route('movies.watch', $movie) }}" class="btn btn-warning btn-lg">▶ Xem phim</a>
            @endif
            @if($movie->trailer)<a href="{{ $movie->trailer }}" target="_blank" class="btn btn-outline-light btn-lg">Trailer</a>@endif
            @auth
                <form method="POST" action="{{ route('movies.favorite', $movie) }}">@csrf
                    <button class="btn btn-outline-danger btn-lg">{{ $isFav ? '♥ Bỏ yêu thích' : '♡ Yêu thích' }}</button>
                </form>
            @endauth
        </div>

        @auth
            <form method="POST" action="{{ route('movies.rate', $movie) }}" class="d-flex align-items-center gap-2">@csrf
                <label>Đánh giá của bạn:</label>
                <select name="stars" class="form-select w-auto">
                    @for($i = 5; $i >= 1; $i--)<option value="{{ $i }}" @selected($myRating == $i)>{{ $i }} sao</option>@endfor
                </select>
                <button class="btn btn-sm btn-warning">Gửi</button>
            </form>
        @endauth
    </div>
</div>

@if($movie->episodes->count() > 1)
    <h5 class="mt-4">Danh sách tập</h5>
    @foreach($movie->episodes as $ep)
        <a href="{{ route('movies.watch', [$movie, $ep]) }}" class="btn btn-sm btn-outline-light mb-1">Tập {{ $ep->number }}</a>
    @endforeach
@endif

<h4 class="mt-5">Bình luận ({{ $movie->comments->count() }})</h4>
@auth
    <form method="POST" action="{{ route('movies.comment', $movie) }}" class="mb-3">@csrf
        <textarea name="content" class="form-control mb-2" rows="2" placeholder="Viết bình luận..." required></textarea>
        <button class="btn btn-warning btn-sm">Gửi bình luận</button>
    </form>
@else
    <p class="text-secondary"><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
@endauth
@foreach($movie->comments as $c)
    <div class="card mb-2"><div class="card-body py-2">
        <strong>{{ $c->user->name }}</strong> <small class="text-secondary">{{ $c->created_at->diffForHumans() }}</small>
        <div>{{ $c->content }}</div>
    </div></div>
@endforeach

@if($related->count())
    <h4 class="mt-5">Phim liên quan</h4>
    <div class="row">@foreach($related as $m) @include('movies._card') @endforeach</div>
@endif
@endsection
