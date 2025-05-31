<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'API route not found.',
    ], 404);
});
