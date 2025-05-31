<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class ArticleRepository
{
    /**
     * Create a new article.
     */
    public function create(array $data): Article
    {
        return Article::create($data);
    }

    /**
     * Update an existing article and sync its categories.
     */
    public function update(Article $article, array $data): Article
    {
        $this->ensureUserCanAccess($article);

        $article->update($data);

        if (isset($data['category_ids'])) {
            $article->categories()->sync($data['category_ids']);
        }

        return $article;
    }

    /**
     * Delete an article with access check.
     */
    public function delete(Article $article): void
    {
        $this->ensureUserCanAccess($article);

        $article->delete();
    }

    /**
     * Find an article by ID, scoped by role.
     */
    public function find(int $id): ?Article
    {
        $query = Article::with('categories', 'author');

        if (!Auth::user()->isAdmin()) {
            $query->where('author_id', Auth::id());
        }

        $article = $query->find($id);

        return $article;
    }

    /**
     * Get all articles with optional filters and role scope.
     */
    public function all(array $filters = []): Collection
    {
        $query = Article::with('categories', 'author');

        if (!Auth::user()->isAdmin()) {
            $query->where('author_id', Auth::id());
        }

        if (!empty($filters['category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereBetween('published_at', [$filters['from_date'], $filters['to_date']]);
        }

        return $query->get();
    }

    /**
     * Role-based access check (Admin or owner).
     */
    protected function ensureUserCanAccess(Article $article): void
    {
        if (!Auth::user()->isAdmin() && Auth::id() !== $article->author_id) {
            throw new AuthorizationException('Unauthorized access to this article.');
        }
    }
}
