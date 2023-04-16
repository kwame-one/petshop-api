<?php

namespace Kwame\CurrencyExchangeRate\Tests;

use Kwame\CurrencyExchangeRate\CurrencyExchangeRateServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [CurrencyExchangeRateServiceProvider::class,];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}