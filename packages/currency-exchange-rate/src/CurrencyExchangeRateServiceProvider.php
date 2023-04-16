<?php
namespace Kwame\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('exchangeRateConverter', function($app) {
            return new ExchangeRateConverterService();
        });
    }

    public function boot()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group(['prefix' => 'api'], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }
}