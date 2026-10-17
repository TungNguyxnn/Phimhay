@extends('layouts.app')
@section('title', 'Xem ' . $movie->title)
@section('content')
<h4 class="mb-3"><a href="{{ route('movies.show', $movie) }}" class="text-warning">{{ $movie->title }}</a> - Tập {{ $episode->number }} {{ $episode->title }}</h4>
<video controls autoplay class="w-100 rounded bg-black" style="max-height:70vh" src="{{ $episode->video_url }}"></video>

@if($episodes->count() > 1)
    <h6 class="mt-4">Chọn tập</h6>
    @foreach($episodes as $ep)
        <a href="{{ route('movies.watch', [$movie, $ep]) }}"
           class="btn btn-sm mb-1 {{ $ep->id === $episode->id ? 'btn-warning' : 'btn-outline-light' }}">Tập {{ $ep->number }}</a>
    @endforeach
@endif
@endsection
