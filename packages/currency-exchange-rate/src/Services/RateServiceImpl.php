<?php

namespace Kwame\CurrencyExchangeRate\Services;

class RateServiceImpl implements RateService
{

    public function fetchRates($url): bool|string
    {
        return file_get_contents($url);
    }
}