<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => 'required|max:200',
            'original_title' => 'nullable|max:200',
            'description' => 'nullable',
            'year' => 'nullable|integer|between:1900,2100',
            'duration' => 'nullable|integer|min:1',
            'poster' => 'nullable|url|max:255',
            'trailer' => 'nullable|url|max:255',
            'country' => 'nullable|max:50',
            'type' => 'required|in:le,bo',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function index(Request $r)
    {
        $movies = Movie::withCount('episodes')
            ->when($r->q, fn ($q, $kw) => $q->where('title', 'like', "%$kw%"))
            ->latest()->paginate(10)->withQueryString();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.form', ['movie' => new Movie(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate($this->rules());
        $data['is_vip'] = $r->boolean('is_vip');
        $movie = Movie::create(collect($data)->except('categories')->all());
        $movie->categories()->sync($r->input('categories', []));
        return redirect()->route('admin.movies.edit', $movie)->with('ok', 'Đã thêm phim. Hãy thêm tập phim bên dưới.');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.form', [
            'movie' => $movie->load('categories', 'episodes'),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $r, Movie $movie)
    {
        $data = $r->validate($this->rules());
        $data['is_vip'] = $r->boolean('is_vip');
        $movie->update(collect($data)->except('categories')->all());
        $movie->categories()->sync($r->input('categories', []));
        return back()->with('ok', 'Đã cập nhật phim.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('ok', 'Đã xóa phim.');
    }

    // ----- Tập phim
    public function storeEpisode(Request $r, Movie $movie)
    {
        $data = $r->validate([
            'number' => 'required|integer|min:1',
            'title' => 'nullable|max:100',
            'video_url' => 'required|url|max:255',
            'duration' => 'nullable|integer|min:1',
        ]);
        $movie->episodes()->create($data);
        return back()->with('ok', 'Đã thêm tập phim.');
    }

    public function destroyEpisode(Episode $episode)
    {
        $episode->delete();
        return back()->with('ok', 'Đã xóa tập phim.');
    }
}
