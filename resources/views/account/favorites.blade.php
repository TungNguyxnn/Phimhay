@extends('layouts.app')
@section('title', 'Phim yêu thích')
@section('content')
<h3 class="mb-3">♥ Phim yêu thích</h3>
<div class="row">
    @forelse($movies as $m) @include('movies._card')
    @empty <p class="text-secondary">Bạn chưa thêm phim nào.</p>
    @endforelse
</div>
@endsection
