@extends('layouts.app')
@section('title', $movie->exists ? 'Sửa phim' : 'Thêm phim')
@section('content')
<h3 class="mb-3">{{ $movie->exists ? 'Sửa phim: ' . $movie->title : 'Thêm phim mới' }}</h3>
@include('admin._nav')

<form method="POST" action="{{ $movie->exists ? route('admin.movies.update', $movie) : route('admin.movies.store') }}">
    @csrf @if($movie->exists) @method('PUT') @endif
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Tên phim *</label><input name="title" class="form-control" value="{{ old('title', $movie->title) }}" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tên gốc</label><input name="original_title" class="form-control" value="{{ old('original_title', $movie->original_title) }}"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Năm</label><input type="number" name="year" class="form-control" value="{{ old('year', $movie->year) }}"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Thời lượng (phút)</label><input type="number" name="duration" class="form-control" value="{{ old('duration', $movie->duration) }}"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Quốc gia</label><input name="country" class="form-control" value="{{ old('country', $movie->country) }}"></div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Loại phim *</label>
            <select name="type" class="form-select">
                <option value="le" @selected(old('type', $movie->type) === 'le')>Phim lẻ</option>
                <option value="bo" @selected(old('type', $movie->type) === 'bo')>Phim bộ</option>
            </select>
        </div>
        <div class="col-md-6 mb-3"><label class="form-label">Link ảnh poster</label><input name="poster" class="form-control" value="{{ old('poster', $movie->poster) }}" placeholder="https://..."></div>
        <div class="col-md-6 mb-3"><label class="form-label">Link trailer</label><input name="trailer" class="form-control" value="{{ old('trailer', $movie->trailer) }}" placeholder="https://..."></div>
        <div class="col-12 mb-3"><label class="form-label">Mô tả</label><textarea name="description" rows="4" class="form-control">{{ old('description', $movie->description) }}</textarea></div>
        <div class="col-12 mb-3">
            <label class="form-label d-block">Thể loại</label>
            @php $selected = old('categories', $movie->exists ? $movie->categories->pluck('id')->all() : []); @endphp
            @foreach($categories as $c)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $c->id }}" id="c{{ $c->id }}" @checked(in_array($c->id, $selected))>
                    <label class="form-check-label" for="c{{ $c->id }}">{{ $c->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="col-12 mb-3 form-check ms-2">
            <input type="checkbox" class="form-check-input" name="is_vip" value="1" id="vip" @checked(old('is_vip', $movie->is_vip))>
            <label class="form-check-label" for="vip">Phim dành riêng cho thành viên VIP</label>
        </div>
    </div>
    <button class="btn btn-warning">{{ $movie->exists ? 'Lưu thay đổi' : 'Thêm phim' }}</button>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-light">Quay lại</a>
</form>

@if($movie->exists)
    <hr class="my-4">
    <h5>Tập phim</h5>
    <table class="table align-middle">
        <thead><tr><th>Tập</th><th>Tên</th><th>Link video</th><th>Phút</th><th></th></tr></thead>
        <tbody>
        @foreach($movie->episodes as $ep)
            <tr>
                <td>{{ $ep->number }}</td><td>{{ $ep->title }}</td><td class="text-truncate" style="max-width:300px">{{ $ep->video_url }}</td><td>{{ $ep->duration }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.episodes.destroy', $ep) }}" onsubmit="return confirm('Xóa tập này?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <form method="POST" action="{{ route('admin.episodes.store', $movie) }}" class="row g-2">@csrf
        <div class="col-md-1"><input type="number" name="number" class="form-control" placeholder="Tập" value="{{ $movie->episodes->count() + 1 }}" required></div>
        <div class="col-md-3"><input name="title" class="form-control" placeholder="Tên tập"></div>
        <div class="col-md-5"><input name="video_url" class="form-control" placeholder="Link video (.mp4)" required></div>
        <div class="col-md-1"><input type="number" name="duration" class="form-control" placeholder="Phút"></div>
        <div class="col-md-2 d-grid"><button class="btn btn-success">+ Thêm tập</button></div>
    </form>
@endif
@endsection
