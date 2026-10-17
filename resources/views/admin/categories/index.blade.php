@extends('layouts.app')
@section('title', 'Quản lý thể loại')
@section('content')
<h3 class="mb-3">Quản lý thể loại</h3>
@include('admin._nav')
<form method="POST" action="{{ route('admin.categories.store') }}" class="d-flex gap-2 mb-3">@csrf
    <input name="name" class="form-control w-auto" placeholder="Tên thể loại mới" required>
    <button class="btn btn-warning">+ Thêm</button>
</form>
<table class="table align-middle">
    <thead><tr><th>#</th><th>Tên thể loại</th><th>Số phim</th><th></th></tr></thead>
    <tbody>
    @foreach($categories as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>
                <form method="POST" action="{{ route('admin.categories.update', $c) }}" class="d-flex gap-2">@csrf @method('PUT')
                    <input name="name" value="{{ $c->name }}" class="form-control form-control-sm w-auto">
                    <button class="btn btn-sm btn-primary">Lưu</button>
                </form>
            </td>
            <td>{{ $c->movies_count }}</td>
            <td>
                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Xóa thể loại này?')">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
