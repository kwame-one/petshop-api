<?php

namespace Kwame\CurrencyExchangeRate;
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