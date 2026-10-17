<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function comment(Request $r, Movie $movie)
    {
        $data = $r->validate(['content' => 'required|max:1000']);
        Comment::create($data + ['user_id' => $r->user()->id, 'movie_id' => $movie->id]);
        return back()->with('ok', 'Đã gửi bình luận.');
    }

    public function rate(Request $r, Movie $movie)
    {
        $data = $r->validate(['stars' => 'required|integer|between:1,5']);
        Rating::updateOrCreate(
            ['user_id' => $r->user()->id, 'movie_id' => $movie->id],
            ['stars' => $data['stars']]
        );
        return back()->with('ok', 'Cảm ơn bạn đã đánh giá.');
    }

    public function favorite(Request $r, Movie $movie)
    {
        $r->user()->favorites()->toggle($movie->id);
        return back();
    }
}
