<?php

use Illuminate\Support\Facades\Route;
use Kwame\CurrencyExchangeRate\Http\Controllers\ExchangeRateConverterController;

Route::get('/currency-converter/{currency}/{amount}', [ExchangeRateConverterController::class, 'convert']);