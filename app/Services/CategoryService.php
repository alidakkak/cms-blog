<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryService
{
    public function listForAdmin(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Category::query()
            ->orderByDesc('created_at');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status']) && in_array($filters['status'], ['active', 'inactive'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getActiveCategories()
    {
        return Category::where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    public function create(array $data): Category
    {
        $data = Arr::only($data, ['name', 'description', 'status']);

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data = Arr::only($data, ['name', 'description', 'status']);
        $category->update($data);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
