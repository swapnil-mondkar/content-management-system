<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(protected CategoryRepository $repository) {}

    public function create(array $data): Category
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Category
    {
        $category = $this->repository->find($id);
        if (!$category) {
            return null;
        }
        return $this->repository->update($category, $data);
    }

    public function delete(int $id): bool
    {
        $category = $this->repository->find($id);
        if (!$category) {
            return false;
        }
        $this->repository->delete($category);
        return true;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getById(int $id): Category
    {
        return $this->repository->find($id);
    }
}
