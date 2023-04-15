<?php

use Illuminate\Support\Facades\Route;
use Kwame\CurrencyExchangeRate\ExchangeRateConverterController;

Route::get('/currency-converter', [ExchangeRateConverterController::class, 'convert']);