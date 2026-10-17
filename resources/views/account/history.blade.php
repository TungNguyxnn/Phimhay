@extends('layouts.app')
@section('title', 'Lịch sử xem')
@section('content')
<h3 class="mb-3">Lịch sử xem</h3>
<table class="table">
    <thead><tr><th>Phim</th><th>Tập</th><th>Lần xem gần nhất</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $h)
        <tr>
            <td>{{ $h->episode->movie->title }}</td>
            <td>Tập {{ $h->episode->number }}</td>
            <td>{{ $h->updated_at->format('d/m/Y H:i') }}</td>
            <td><a class="btn btn-sm btn-warning" href="{{ route('movies.watch', [$h->episode->movie, $h->episode]) }}">Xem lại</a></td>
        </tr>
    @empty <tr><td colspan="4" class="text-secondary">Chưa có lịch sử.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
