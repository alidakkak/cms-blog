<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
        ];

        $articles = $this->articleService->listForAdmin($filters);

        return view('admin.articles.index', compact('articles', 'filters'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $this->articleService->store(
            $request->validated(),
            $request->file('image'),
            $request->user()->id
        );

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->articleService->update(
            $article,
            $request->validated(),
            $request->file('image')
        );

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $this->articleService->delete($article);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    public function toggleStatus(Article $article)
    {
        $this->articleService->toggleStatus($article);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article status updated.');
    }
}
