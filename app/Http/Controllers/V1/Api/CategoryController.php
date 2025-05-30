<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Services\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    use ResponseTrait;

    public function __construct(protected CategoryService $service) {}

    public function index(): JsonResponse
    {
        return $this->successResponse(data: $this->service->getAll());
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        return $this->successResponse(data: $this->service->create($request->validated()), code: 201);
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->service->getById($id);
        if (!$category) {
            return $this->errorResponse(message: 'Category not found', code: 404);
        }
        return $this->successResponse(data: $category);
    }

    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        $category = $this->service->update($id, $request->validated());
        if (!$category) {
            return $this->errorResponse(message: 'Category not found', code: 404);
        }
        return $this->successResponse(data: $category);
    }

    public function destroy(int $id): JsonResponse
    {
        $category = $this->service->delete($id);
        if (!$category) {
            return $this->errorResponse(message: 'Category not found', code: 404);
        }
        return $this->successResponse(message: 'Category deleted successfully', code: 204);
    }
}
