<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.api:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
});
