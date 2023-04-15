<?php

namespace Kwame\CurrencyExchangeRate;

use GuzzleHttp\Client;

class ExchangeRateConverter
{
    private $client;

    public function __construct()
    {
        $this->client  = new Client();

    }
    public function convert($amount, $currency): int {

    }

}