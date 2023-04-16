<?php

namespace Kwame\CurrencyExchangeRate\Tests;

use Kwame\CurrencyExchangeRate\CurrencyExchangeRateServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
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