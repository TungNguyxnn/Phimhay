<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::withCount('movies')->orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate(['name' => 'required|max:50|unique:categories,name']);
        Category::create($data);
        return back()->with('ok', 'Đã thêm thể loại.');
    }

    public function update(Request $r, Category $category)
    {
        $data = $r->validate(['name' => ['required', 'max:50', Rule::unique('categories', 'name')->ignore($category->id)]]);
        $category->update($data);
        return back()->with('ok', 'Đã sửa thể loại.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('ok', 'Đã xóa thể loại.');
    }
}
