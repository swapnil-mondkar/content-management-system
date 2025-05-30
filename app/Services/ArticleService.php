<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GenerateArticleMetadata;

class ArticleService
{
    public function __construct(private ArticleRepository $repository) {}

    /**
     * Create a new article and dispatch a job to generate metadata.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        $data['author_id'] = Auth::id();

        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        $article = $this->repository->create($data);

        $article->categories()->sync($categoryIds);

        Bus::dispatch(new GenerateArticleMetadata($article));

        return $article;
    }

    /**
     * Update an existing article and dispatch a job to generate metadata.
     *
     * @param int $id
     * @param array $data
     * @return Article|null
     */
    public function update(int $id, array $data): ?Article
    {
        $article = $this->repository->find($id);
        if (!$article) {
            return null;
        }
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        $updatedArticle = $this->repository->update($article, $data);

        $updatedArticle->categories()->sync($categoryIds);

        Bus::dispatch(new GenerateArticleMetadata($article));

        return $updatedArticle;
    }

    /**
     * Delete an article by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $article = $this->repository->find($id);
        if (!$article) {
            return false;
        }
        $this->repository->delete($article);
        return true;
    }

    /**
     * Find an article by ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article
    {
        return $this->repository->find($id);
    }

    /**
     * Get all articles with optional filters.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function all(array $filters = [])
    {
        return $this->repository->all($filters);
    }
}
