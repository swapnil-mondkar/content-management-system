<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\CategoryController;
use App\Http\Controllers\V1\Api\ArticleController;

Route::middleware('throttle:10,1')->post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.api:sanctum', 'role:admin,author', 'throttle:30,1'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('v1')->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::apiResource('categories', CategoryController::class);
        });

        Route::apiResource('articles', ArticleController::class);
    });
});
