<?php
namespace Kwame\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

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
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}