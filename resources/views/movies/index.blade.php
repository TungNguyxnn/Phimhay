@extends('layouts.app')
@section('title', 'Danh sách phim')
@section('content')
<h3 class="mb-3">Danh sách phim</h3>
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-3"><input class="form-control" name="q" placeholder="Tên phim" value="{{ request('q') }}"></div>
    <div class="col-md-2">
        <select name="category" class="form-select">
            <option value="">Thể loại</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="country" class="form-select">
            <option value="">Quốc gia</option>
            @foreach($countries as $c)<option @selected(request('country') == $c)>{{ $c }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-2"><input class="form-control" type="number" name="year" placeholder="Năm" value="{{ request('year') }}"></div>
    <div class="col-md-2">
        <select name="type" class="form-select">
            <option value="">Loại phim</option>
            <option value="le" @selected(request('type') == 'le')>Phim lẻ</option>
            <option value="bo" @selected(request('type') == 'bo')>Phim bộ</option>
        </select>
    </div>
    <div class="col-md-1 d-grid"><button class="btn btn-warning">Lọc</button></div>
</form>

<div class="row">
    @forelse($movies as $m) @include('movies._card')
    @empty <p class="text-secondary">Không tìm thấy phim phù hợp.</p>
    @endforelse
</div>
{{ $movies->links('pagination::bootstrap-5') }}
@endsection
