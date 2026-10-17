@extends('layouts.app')
@section('title', 'Kiểm duyệt bình luận')
@section('content')
<h3 class="mb-3">Kiểm duyệt bình luận</h3>
@include('admin._nav')
<table class="table align-middle">
    <thead><tr><th>Người dùng</th><th>Phim</th><th>Nội dung</th><th>Thời gian</th><th></th></tr></thead>
    <tbody>
    @foreach($comments as $c)
        <tr>
            <td>{{ $c->user->name }}</td><td>{{ $c->movie->title }}</td><td>{{ $c->content }}</td><td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <form method="POST" action="{{ route('admin.comments.destroy', $c) }}" onsubmit="return confirm('Xóa bình luận?')">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $comments->links('pagination::bootstrap-5') }}
@endsection
