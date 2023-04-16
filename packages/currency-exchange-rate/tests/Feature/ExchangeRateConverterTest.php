<?php

namespace Kwame\CurrencyExchangeRate\Tests\Feature;
use Kwame\CurrencyExchangeRate\Tests\BaseTestCase;

class ExchangeRateConverterTest extends BaseTestCase
{

    public function test_currency_convert()
    {
       $response = $this->getJson('/api/currency-converter/JPY/10');
       $response->assertOk();
       $response->assertJsonPath('amount', '1466.00');
    }

    public function test_invalid_currency_convert()
    {
        $response = $this->getJson('/api/currency-converter/JPY1/10');
        $response->assertBadRequest();
    }
}