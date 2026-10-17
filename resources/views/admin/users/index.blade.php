@extends('layouts.app')
@section('title', 'Quản lý người dùng')
@section('content')
<h3 class="mb-3">Quản lý người dùng</h3>
@include('admin._nav')
<table class="table align-middle">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th>Ngày tạo</th><th></th></tr></thead>
    <tbody>
    @foreach($users as $u)
        <tr>
            <td>{{ $u->id }}</td><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->role }}</td>
            <td>{!! $u->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-danger">Bị khóa</span>' !!}</td>
            <td>{{ $u->created_at?->format('d/m/Y') }}</td>
            <td>
                <form method="POST" action="{{ route('admin.users.toggle', $u) }}">@csrf
                    <button class="btn btn-sm {{ $u->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">{{ $u->is_active ? 'Khóa' : 'Mở khóa' }}</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links('pagination::bootstrap-5') }}
@endsection
