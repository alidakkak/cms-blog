<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment from the public article page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => ['required', 'exists:articles,id'],
            'body' => ['required', 'string'],
        ]);

        $article = Article::findOrFail($request->article_id);

        abort_unless($article->comments_enabled, 403);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your comment is awaiting approval.');
    }
}
