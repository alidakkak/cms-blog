<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Article;
use Illuminate\Support\Collection;

class ArticleShowResponse implements Responsable
{
    public function __construct(
        public Article $article,
        public Collection $relatedArticles
    ) {}

    public function toResponse($request)
    {
        return response()->view('front.article', [
            'article' => $this->article,
            'related' => $this->relatedArticles,
        ]);
    }
}
