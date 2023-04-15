<?php

namespace Kwame\CurrencyExchangeRate;

use GuzzleHttp\Client;

class ExchangeRateConverterService
{
    private $client;

    public function __construct()
    {
        $this->client  = new Client();

    }
    public function convert($amount, $currency): array {
        return ['amount' => 10];
    }

}