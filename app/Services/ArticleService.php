<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public function listForAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Article::query()
            ->with('author')
            ->latest('created_at');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('title', 'like', "%{$search}%");
        }

        if (!empty($filters['status']) && in_array($filters['status'], ['draft', 'published', 'archived'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function store(array $data, UploadedFile $imageFile, int $userId): Article
    {
        $imagePath = $imageFile->store('articles', 'public');

        return Article::create([
            'title'   => $data['title'],
            'content' => $data['content'],
            'status'  => $data['status'],
            'image'   => $imagePath,
            'user_id' => $userId,
        ]);
    }

    public function update(Article $article, array $data, ?UploadedFile $imageFile = null): Article
    {
        if ($imageFile) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $data['image'] = $imageFile->store('articles', 'public');
        } else {
            unset($data['image']);
        }

        $article->update($data);

        return $article;
    }

    public function delete(Article $article): void
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
    }

    public function toggleStatus(Article $article): Article
    {
        if ($article->status === 'published') {
            $article->status = 'draft';
        } else {
            $article->status = 'published';
        }

        $article->save();

        return $article;
    }
}
