<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users'], function () {
    Route::post('/create', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login'])->name('login');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'inpdex']);
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete', [UserController::class, 'delete']);
    });
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/search', [PostController::class, 'search']);
    Route::post('/create', [PostController::class, 'create']);
    Route::put('/update', [PostController::class, 'update']);
    Route::delete('/delete', [PostController::class, 'delete']);
    Route::get('/author', [PostController::class, 'getByAuthor']);
});


Route::fallback(function () {
    return response()->json(['message' => 'Unauthorized.'], 404);
});
