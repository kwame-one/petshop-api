<?php

namespace Kwame\CurrencyExchangeRate;

use Kwame\CurrencyExchangeRate\Services\RateService;

class ExchangeRateConverterService
{
    private RateService $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function convert($amount, $currency)
    {
        $xml = simplexml_load_string(
            $this->rateService->fetchRates('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
        );
        $items = $xml->Cube->Cube->Cube;
        $rates = [];
        foreach ($items as $item) {
            $curr = $item->attributes()->currency;
            $rate = $item->attributes()->rate;
            $rates[(string)$curr] = (string)$rate;
        }
        if (!isset($rates[$currency])) {
            return false;
        }
        return ['amount' => number_format((float)$amount * (float)$rates[$currency], 2, '.', '')];
    }

}