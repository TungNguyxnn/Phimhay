<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        return view('admin.comments.index', ['comments' => Comment::with('user', 'movie')->latest()->paginate(15)]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('ok', 'Đã xóa bình luận.');
    }
}
