<?php

class RateServiceImpl implements RateService
{

    public function fetchRates($url): bool|string
    {
        return file_get_contents('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
    }
}