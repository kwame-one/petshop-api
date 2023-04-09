<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['prefix' => 'v1'], function() {

    Route::prefix('admin')->group(function() {
        Route::post('create', [AdminController::class, 'store']);
        Route::get('user-listing', [AdminController::class, 'index']);
        Route::put('user-edit/{uuid}', [AdminController::class, 'update']);
        Route::delete('user-delete/{uuid}', [AdminController::class, 'destroy']);

        Route::post('login', [AuthController::class, 'loginAdmin']);
        Route::get('logout', [AuthController::class, 'logoutAdmin']);
    });

    Route::get('categories', [CategoryController::class, 'index']);
    Route::prefix('category')->group(function() {
        Route::post('create', [CategoryController::class, 'store']);
        Route::put('{uuid}', [CategoryController::class, 'update']);
        Route::delete('{uuid}', [CategoryController::class, 'destroy']);
        Route::get('{uuid}', [CategoryController::class, 'show']);
    });

    Route::get('brands', [BrandController::class, 'index']);
    Route::prefix('brand')->group(function() {
        Route::post('create', [BrandController::class, 'store']);
        Route::put('{uuid}', [BrandController::class, 'update']);
        Route::delete('{uuid}', [BrandController::class, 'destroy']);
        Route::get('{uuid}', [BrandController::class, 'show']);
    });

    Route::get('order-statuses', [OrderStatusController::class, 'index']);
    Route::prefix('order-status')->group(function() {
        Route::post('create', [OrderStatusController::class, 'store']);
        Route::put('{uuid}', [OrderStatusController::class, 'update']);
        Route::delete('{uuid}', [OrderStatusController::class, 'destroy']);
        Route::get('{uuid}', [OrderStatusController::class, 'show']);
    });

    Route::prefix('file')->group(function() {
        Route::post('upload', [FileController::class, 'store']);
        Route::get('{uuid}', [FileController::class, 'view']);
    });

    Route::get('payments', [PaymentController::class, 'index']);
    Route::prefix('payment')->group(function() {
        Route::post('create', [PaymentController::class, 'store']);
        Route::put('{uuid}', [PaymentController::class, 'update']);
        Route::delete('{uuid}', [PaymentController::class, 'destroy']);
        Route::get('{uuid}', [PaymentController::class, 'show']);
    });

    Route::get('products', [ProductController::class, 'index']);
    Route::prefix('product')->group(function() {
        Route::post('create', [ProductController::class, 'store']);
        Route::put('{uuid}', [ProductController::class, 'update']);
        Route::delete('{uuid}', [ProductController::class, 'destroy']);
        Route::get('{uuid}', [ProductController::class, 'show']);
    });

    Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'view']);
        Route::delete('/', [UserController::class, 'delete']);
        Route::put('edit', [UserController::class, 'edit']);
        Route::post('login', [AuthController::class, 'loginUser']);
        Route::post('create', [UserController::class, 'store']);
        Route::get('logout', [AuthController::class, 'logoutUser']);
    });
});