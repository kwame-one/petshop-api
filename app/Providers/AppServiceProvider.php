<?php

namespace App\Providers;

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use App\Repositories\JwtTokenRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\FileService;
use App\Services\ICoreService;
use App\Services\OrderStatusService;
use App\Services\PaymentService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(AdminController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new AdminService(
                    $app->make(UserRepository::class),
                    $app->make(JwtTokenRepository::class),
                );
            });

        $this->app->when(CategoryController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new CategoryService(
                    $app->make(CategoryRepository::class)
                );
            });

        $this->app->when(BrandController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new BrandService(
                    $app->make(BrandRepository::class)
                );
            });

        $this->app->when(OrderStatusController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new OrderStatusService(
                    $app->make(OrderStatusRepository::class)
                );
            });

        $this->app->when(FileController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new FileService(
                    $app->make(FileRepository::class)
                );
            });

        $this->app->when(PaymentController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new PaymentService(
                    $app->make(PaymentRepository::class)
                );
            });

        $this->app->when(ProductController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new ProductService(
                    $app->make(ProductRepository::class),
                );
            });

        $this->app->when(UserController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new UserService(
                    $app->make(UserRepository::class),
                    $app->make(JwtTokenRepository::class),
                );
            });

        $this->app->when(AuthController::class)
            ->needs(ICoreService::class)
            ->give(function ($app) {
                return new AuthService(
                    $app->make(UserRepository::class),
                    $app->make(JwtTokenRepository::class),
                );
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
