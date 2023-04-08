<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\OrderStatusController;
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
        Route::get('{uuid}', [FileController::class, 'show']);
    });
});