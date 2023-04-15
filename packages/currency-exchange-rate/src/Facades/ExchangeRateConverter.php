<?php

namespace Kwame\CurrencyExchangeRate;

use Illuminate\Support\Facades\Facade;

class ExchangeRateConverter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'exchangeRateConverter';
    }
}