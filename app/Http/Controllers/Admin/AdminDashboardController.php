<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $articlesCount   = Article::count();
        $categoriesCount = Category::count();
        $commentsCount   = Comment::count();
        $messagesCount   = ContactMessage::count();

        $publishedArticlesCount = Article::where('status', 'published')->count();
        $draftArticlesCount     = Article::where('status', 'draft')->count();

        $unreadMessagesCount    = ContactMessage::where('is_read', false)->count();
        $pendingCommentsCount   = Comment::where('status', 'pending')->count();

        $latestArticles = Article::with('author')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'articlesCount',
            'categoriesCount',
            'commentsCount',
            'messagesCount',
            'publishedArticlesCount',
            'draftArticlesCount',
            'unreadMessagesCount',
            'pendingCommentsCount',
            'latestArticles'
        ));
    }
}
