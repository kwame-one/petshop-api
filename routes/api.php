<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CategoryController;
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
});