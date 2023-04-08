<?php

namespace App\Providers;

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\JwtTokenRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ICoreService;
use App\Services\OrderStatusService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
