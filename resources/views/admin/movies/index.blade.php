@extends('layouts.app')
@section('title', 'Quản lý phim')
@section('content')
<h3 class="mb-3">Quản lý phim</h3>
@include('admin._nav')
<div class="d-flex justify-content-between mb-3">
    <form class="d-flex gap-2"><input name="q" class="form-control" placeholder="Tìm tên phim" value="{{ request('q') }}"><button class="btn btn-outline-light">Tìm</button></form>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-warning">+ Thêm phim</a>
</div>
<table class="table align-middle">
    <thead><tr><th>#</th><th>Tên phim</th><th>Loại</th><th>Năm</th><th>Số tập</th><th>VIP</th><th>Lượt xem</th><th></th></tr></thead>
    <tbody>
    @foreach($movies as $m)
        <tr>
            <td>{{ $m->id }}</td><td>{{ $m->title }}</td><td>{{ $m->type === 'bo' ? 'Bộ' : 'Lẻ' }}</td><td>{{ $m->year }}</td>
            <td>{{ $m->episodes_count }}</td><td>{{ $m->is_vip ? '✔' : '' }}</td><td>{{ $m->views }}</td>
            <td class="text-nowrap">
                <a href="{{ route('admin.movies.edit', $m) }}" class="btn btn-sm btn-primary">Sửa</a>
                <form method="POST" action="{{ route('admin.movies.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Xóa phim này?')">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $movies->links('pagination::bootstrap-5') }}
@endsection
