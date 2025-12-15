<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Responses\ArticleShowResponse;
use App\Http\Responses\CategoryPageResponse;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontArticleController extends Controller
{
    /**
     * 2.2 Article Page
     * - Show article details (title, image, content, author, date)
     * - Show related articles
     * - Add comments
     */
    public function show(Article $article): ArticleShowResponse
    {
        abort_unless($article->status === 'published', 404);

        // related by shared categories
        $categoryIds = $article->categories()->pluck('categories.id');

        $relatedQuery = Article::query()
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('created_at');

        if ($categoryIds->isNotEmpty()) {
            $relatedQuery->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        $relatedArticles = $relatedQuery
            ->take(3)
            ->get();

        return new ArticleShowResponse(
            article: $article->load(['author', 'categories']),
            relatedArticles: $relatedArticles
        );
    }

    /**
     * 2.3 Categories Page
     * - Display all articles belonging to a specific category
     */
    public function category(Category $category): CategoryPageResponse
    {
        $articles = $category->articles()
            ->where('status', 'published')
            ->with('author')
            ->latest('created_at')
            ->paginate(10);

        return new CategoryPageResponse(
            category: $category,
            articles: $articles,
            categories: Category::orderBy('name')->get()
        );
    }
}
