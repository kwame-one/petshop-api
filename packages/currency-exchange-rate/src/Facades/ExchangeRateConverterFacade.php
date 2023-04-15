<?php

namespace Kwame\CurrencyExchangeRate;

use Illuminate\Support\Facades\Facade;

class ExchangeRateConverterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'exchangeRateConverter';
    }
}