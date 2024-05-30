<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'middleware' => ['throttle:1,1']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    Route::put('/update', [UserController::class, 'update']);
    Route::delete('/delete', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'posts', 'middleware' => ['throttle:1,1']], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/search', [PostController::class, 'search']);
    Route::post('/create', [PostController::class, 'create']);
    Route::put('/update', [PostController::class, 'update']);
    Route::delete('/delete', [PostController::class, 'delete']);
    Route::get('/author', [PostController::class, 'getByAuthor']);
});
