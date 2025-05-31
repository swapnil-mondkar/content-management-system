<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function create(array $data): Category
    {
        $data['created_by'] = Auth::id();
        $category = Category::create($data);
        Cache::forget('categories.all');
        return $category;
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        Cache::forget('categories.all');
        Cache::forget("categories.{$category->id}");
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
        Cache::forget('categories.all');
        Cache::forget("categories.{$category->id}");
    }

    public function all(): Collection
    {
        return Cache::remember('categories.all', 600, function () {
            return Category::all();
        });
    }

    public function find(int $id): ?Category
    {
        return Cache::remember("categories.$id", 600, function () use ($id) {
            return Category::find($id);
        });
    }
}
