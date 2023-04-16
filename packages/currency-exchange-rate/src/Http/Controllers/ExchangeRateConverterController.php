<?php

namespace Kwame\CurrencyExchangeRate\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Kwame\CurrencyExchangeRate\Facades\ExchangeRateConverter;

class ExchangeRateConverterController extends Controller
{

    public function convert($currency, $amount): JsonResponse
    {
        $data = ExchangeRateConverter::convert($amount, $currency);
        return response()->json($data);
    }
}