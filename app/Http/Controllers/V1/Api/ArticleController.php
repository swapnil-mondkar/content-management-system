<?php

namespace App\Http\Controllers\V1\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Services\ArticleService;
use App\Traits\ResponseTrait;

/**
 * Class ArticleController
 *
 * Handles CRUD operations for articles.
 */
class ArticleController extends Controller
{

    use ResponseTrait;

    /**
     * Create a new controller instance.
     *
     * @param ArticleService $service
     */
    public function __construct(private ArticleService $service) {}

    /**
     * Display a listing of the articles.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(data: $this->service->all());
    }

    /**
     * Store a newly created article in storage.
     *
     * @param ArticleStoreRequest $request
     * @return JsonResponse
     */
    public function store(ArticleStoreRequest $request): JsonResponse
    {
        return $this->successResponse(data: $this->service->create($request->validated(), Auth::user()));
    }

    /**
     * Display the specified article.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->successResponse(data: $this->service->find($id));
    }

    /**
     * Update the specified article in storage.
     *
     * @param ArticleUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ArticleUpdateRequest $request, int $id): JsonResponse
    {
        $article = $this->service->update($id, $request->validated());
        if (!$article) {
            return $this->errorResponse(message: 'Article not found.', code: 404);
        }
        return $this->successResponse(data: $article);
    }

    /**
     * Remove the specified article from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $article = $this->service->delete($id);
        if (!$article) {
            return $this->errorResponse(message: 'Article not found.', code: 404);
        }
        return $this->successResponse(message: 'Article deleted successfully.');
    }
}
