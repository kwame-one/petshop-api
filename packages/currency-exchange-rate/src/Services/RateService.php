<?php

namespace Kwame\CurrencyExchangeRate\Services;

interface RateService
{
    public function fetchRates($url): string | bool;
}