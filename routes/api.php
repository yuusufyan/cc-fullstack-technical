<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PostController;

// LOGIN
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'roles' => $request->user()->getRoleNames(), // dari Spatie
    ]);
});

// Admin Post
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);       // list post
    Route::get('/posts/{id}', [PostController::class, 'show']);   // detail post
    Route::post('/posts', [PostController::class, 'store']);      // create
    Route::put('/posts/{id}', [PostController::class, 'update']); // update
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete
});

// Guest Post
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);

// API Check Health
Route::get('/test-api', function () {
    return response()->json(['message' => 'API hidup!']);
});
