<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'users', 'middleware' => ['throttle:6,1']], function () {
    Route::post('/create', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [AuthController::class, 'index']);
        Route::put('/update', [AuthController::class, 'update']);
        Route::delete('/delete', [AuthController::class, 'delete']);
    });
});

Route::group(['prefix' => 'posts', 'middleware' => ['throttle:6,1']], function () {
    Route::get('/', [AuthController::class, 'indexpost']);
    Route::get('/search', [AuthController::class, 'search']);
    Route::put('/update', [AuthController::class, 'updatepost']);
    Route::delete('/delete', [AuthController::class, 'deletepost']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [AuthController::class, 'createpost']);
        Route::get('/author', [AuthController::class, 'getByAuthor']);
    });
});


Route::fallback(function () {
    return response()->json(['message' => 'Unauthorized.'], 404);
});
