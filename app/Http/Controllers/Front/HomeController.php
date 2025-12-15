<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Responses\HomePageResponse;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Front Home Page
     * - Display latest articles
     * - Search bar
     * - Filter by categories
     * - Pagination
     */
    public function index(Request $request): HomePageResponse
    {
        $search     = $request->query('search');
        $categoryId = $request->query('category');

        $query = Article::query()
            ->with(['author', 'categories'])
            ->where('status', 'published')
            ->latest('created_at');

        // Search by title or content
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $articles = $query
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return new HomePageResponse(
            articles: $articles,
            categories: $categories,
            search: $search,
            categoryId: $categoryId ? (int) $categoryId : null
        );
    }
}
