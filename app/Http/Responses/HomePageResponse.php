<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomePageResponse implements Responsable
{
    public function __construct(
        public LengthAwarePaginator $articles,
        public Collection $categories,
        public ?string $search = null,
        public ?int $categoryId = null
    ) {}

    public function toResponse($request)
    {
        return response()->view('front.home', [
            'articles'   => $this->articles,
            'categories' => $this->categories,
            'search'     => $this->search,
            'categoryId' => $this->categoryId,
        ]);
    }
}
