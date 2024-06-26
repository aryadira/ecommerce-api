<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('a1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        // logout
        Route::prefix('auth')->group(function () {
            Route::delete('/logout', [AuthController::class, 'logout']);
        });

        // products
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        // user manage profile
        // show by user
        Route::get('/users/products', [ProductController::class, 'showProductByUser']);

        Route::middleware('restrictRole:admin')->group(function () {
            // admin manage user
            Route::get('/admin/list-user', [UserController::class, 'index']);
            Route::get('/admin/detail-user/{id}', [UserController::class, 'show']);
            Route::post('/admin/create-user', [UserController::class, 'store']);
            Route::put('/admin/update-user/{id}', [UserController::class, 'update']);
            Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);
        });
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
