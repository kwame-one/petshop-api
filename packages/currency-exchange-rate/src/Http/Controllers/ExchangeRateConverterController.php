<?php

namespace Kwame\CurrencyExchangeRate\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Kwame\CurrencyExchangeRate\Facades\ExchangeRateConverter;

class ExchangeRateConverterController extends Controller
{

    public function convert($currency, $amount): JsonResponse
    {
        $data = ExchangeRateConverter::convert($amount, $currency);
        if (!$data) {
            return response()->json(['message' => 'currency not found'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($data);
    }
}