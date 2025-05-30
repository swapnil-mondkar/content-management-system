<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\CategoryController;

Route::middleware('throttle:10,1')->post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.api:sanctum', 'throttle:30,1'])->group(function () {

    Route::middleware(['role:admin'])->prefix('v1')->group(function () {
        Route::apiResource('categories', CategoryController::class);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
