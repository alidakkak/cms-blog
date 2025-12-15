<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryPageResponse implements Responsable
{
    public function __construct(
        public Category $category,
        public LengthAwarePaginator $articles,
        public Collection $categories,
    ) {}

    public function toResponse($request)
    {
        return response()->view('front.category', [
            'category' => $this->category,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }
}
