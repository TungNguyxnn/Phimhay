<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\WatchHistory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'latest' => Movie::latest()->take(8)->get(),
            'hot' => Movie::orderByDesc('views')->take(8)->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function movies(Request $r)
    {
        $q = Movie::query()->with('categories');

        if ($r->filled('q')) {
            $kw = $r->q;
            $q->where(fn ($x) => $x->where('title', 'like', "%$kw%")->orWhere('original_title', 'like', "%$kw%"));
        }
        if ($r->filled('category')) {
            $q->whereHas('categories', fn ($x) => $x->where('categories.id', $r->category));
        }
        if ($r->filled('country')) $q->where('country', $r->country);
        if ($r->filled('year')) $q->where('year', $r->year);
        if ($r->filled('type')) $q->where('type', $r->type);

        return view('movies.index', [
            'movies' => $q->latest()->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
            'countries' => Movie::whereNotNull('country')->distinct()->pluck('country'),
        ]);
    }

    public function show(Movie $movie)
    {
        $movie->load(['categories', 'actors', 'episodes', 'comments.user']);
        $user = auth()->user();

        return view('movies.show', [
            'movie' => $movie,
            'avg' => $movie->avgRating(),
            'myRating' => $user ? $movie->ratings()->where('user_id', $user->id)->value('stars') : null,
            'isFav' => $user ? $user->favorites()->where('movies.id', $movie->id)->exists() : false,
            'related' => Movie::where('id', '!=', $movie->id)
                ->whereHas('categories', fn ($x) => $x->whereIn('categories.id', $movie->categories->pluck('id')))
                ->take(4)->get(),
        ]);
    }

    public function watch(Movie $movie, ?Episode $episode = null)
    {
        $user = auth()->user();

        if ($movie->is_vip && !$user->isVip()) {
            return redirect()->route('vip.index')->with('error', 'Phim này dành cho thành viên VIP. Vui lòng đăng ký gói VIP.');
        }

        $episodes = $movie->episodes;
        $episode = $episode ?: $episodes->first();
        abort_if(!$episode || $episode->movie_id !== $movie->id, 404, 'Phim chưa có tập nào.');

        $movie->increment('views');
        WatchHistory::updateOrCreate(
            ['user_id' => $user->id, 'episode_id' => $episode->id],
            ['progress' => 0]
        )->touch();

        return view('movies.watch', compact('movie', 'episode', 'episodes'));
    }

    public function contactForm() { return view('contact'); }

    public function contactSend(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|max:2000',
        ]);
        Contact::create($data);
        return back()->with('ok', 'Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn.');
    }
}
