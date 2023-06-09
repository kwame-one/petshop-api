<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::prefix('admin')->group(function () {
        Route::post('create', [AdminController::class, 'store']);
        Route::post('login', [AuthController::class, 'loginAdmin']);

        Route::group(['middleware' => ['token.validate']], function () {
            Route::get('user-listing', [AdminController::class, 'index'])->middleware('permission:user-listing');
            Route::put('user-edit/{uuid}', [AdminController::class, 'update'])->middleware('permission:user-edit');
            Route::delete('user-delete/{uuid}', [AdminController::class, 'destroy'])->middleware(
                'permission:user-delete'
            );
            Route::get('logout', [AuthController::class, 'logoutAdmin']);
        });
    });

    Route::get('categories', [CategoryController::class, 'index']);
    Route::prefix('category')->group(function () {
        Route::get('{uuid}', [CategoryController::class, 'show']);

        Route::group(['middleware' => ['token.validate']], function () {
            Route::post('create', [CategoryController::class, 'store'])->middleware('permission:category-create');
            Route::put('{uuid}', [CategoryController::class, 'update'])->middleware('permission:category-edit');
            Route::delete('{uuid}', [CategoryController::class, 'destroy'])->middleware('permission:category-delete');
        });
    });

    Route::get('brands', [BrandController::class, 'index']);
    Route::prefix('brand')->group(function () {
        Route::get('{uuid}', [BrandController::class, 'show']);

        Route::group(['middleware' => ['token.validate']], function () {
            Route::post('create', [BrandController::class, 'store'])->middleware('permission:brand-create');
            Route::put('{uuid}', [BrandController::class, 'update'])->middleware('permission:brand-edit');
            Route::delete('{uuid}', [BrandController::class, 'destroy'])->middleware('permission:brand-delete');
        });
    });

    Route::get('order-statuses', [OrderStatusController::class, 'index']);
    Route::prefix('order-status')->group(function () {
        Route::get('{uuid}', [OrderStatusController::class, 'show']);

        Route::group(['middleware' => ['token.validate']], function () {
            Route::post('create', [OrderStatusController::class, 'store'])->middleware(
                'permission:order-status-create'
            );
            Route::put('{uuid}', [OrderStatusController::class, 'update'])->middleware('permission:order-status-edit');
            Route::delete('{uuid}', [OrderStatusController::class, 'destroy'])->middleware(
                'permission:order-status-delete'
            );
        });
    });

    Route::prefix('file')->group(function () {
        Route::get('{uuid}', [FileController::class, 'view']);
        Route::post('upload', [FileController::class, 'store'])->middleware('token.validate');
    });

    Route::get('payments', [PaymentController::class, 'index'])->middleware('permission:payment-listing');
    Route::prefix('payment')->group(function () {
        Route::group(['middleware' => ['token.validate']], function () {
            Route::post('create', [PaymentController::class, 'store']);
            Route::put('{uuid}', [PaymentController::class, 'update'])->middleware('permission:payment-edit');
            Route::delete('{uuid}', [PaymentController::class, 'destroy'])->middleware('permission:payment-delete');
            Route::get('{uuid}', [PaymentController::class, 'show'])->middleware('permission:payment-view');
        });
    });

    Route::get('products', [ProductController::class, 'index']);
    Route::prefix('product')->group(function () {
        Route::get('{uuid}', [ProductController::class, 'show']);

        Route::group(['middleware' => ['token.validate']], function () {
            Route::post('create', [ProductController::class, 'store'])->middleware('permission:product-create');
            Route::put('{uuid}', [ProductController::class, 'update'])->middleware('permission:product-edit');
            Route::delete('{uuid}', [ProductController::class, 'destroy'])->middleware('permission:product-delete');
        });
    });

    Route::prefix('user')->group(function () {
        Route::group(['middleware' => ['token.validate']], function () {
            Route::get('/', [UserController::class, 'view']);
            Route::delete('/', [UserController::class, 'delete']);
            Route::put('edit', [UserController::class, 'edit']);
            Route::get('logout', [AuthController::class, 'logoutUser']);
        });

        Route::post('login', [AuthController::class, 'loginUser']);
        Route::post('create', [UserController::class, 'store']);
        Route::post('forgot-password', [UserController::class, 'forgotPassword']);
        Route::post('reset-password-token', [UserController::class, 'resetPassword']);
    });

    Route::prefix('orders')->middleware('token.validate')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('dashboard', [OrderController::class, 'index'])->name('orders.dashboard')->middleware(
            'permission:orders-dashboard'
        );
        Route::get('shipment-locator', [OrderController::class, 'getShippedOrders'])->middleware(
            'permission:orders-shipment-locator'
        );
    });
    Route::prefix('order')->middleware('token.validate')->group(function () {
        Route::post('create', [OrderController::class, 'store']);
        Route::get('{uuid}', [OrderController::class, 'show']);
        Route::delete('{uuid}', [OrderController::class, 'destroy']);
        Route::put('{uuid}', [OrderController::class, 'update']);
    });

    Route::prefix('main')->group(function () {
        Route::get('blog', [PostController::class, 'index']);
        Route::get('blog/{uuid}', [PostController::class, 'show']);
        Route::get('promotions', [PromotionController::class, 'index']);
    });
});