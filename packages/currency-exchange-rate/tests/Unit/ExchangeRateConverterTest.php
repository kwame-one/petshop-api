<?php

namespace Kwame\CurrencyExchangeRate\Tests\Unit;

use Kwame\CurrencyExchangeRate\ExchangeRateConverterService;
use Kwame\CurrencyExchangeRate\Facades\ExchangeRateConverter;
use Kwame\CurrencyExchangeRate\Services\RateService;
use Mockery;
use Kwame\CurrencyExchangeRate\Tests\BaseTestCase;

class ExchangeRateConverterTest extends BaseTestCase
{

    public function test_currency_convert()
    {
        $rateServiceMock = Mockery::spy(RateService::class);
        $sampleXml = <<<XML
            <gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
                <gesmes:subject>Reference rates</gesmes:subject>
                <gesmes:Sender>
                    <gesmes:name>European Central Bank</gesmes:name>
                </gesmes:Sender>
                <Cube>
                    <Cube time="2023-04-14">
                        <Cube currency="USD" rate="1.1057"/>
                        <Cube currency="JPY" rate="146.60"/>
                        <Cube currency="BGN" rate="1.9558"/>
                        <Cube currency="CZK" rate="23.341"/>
                        <Cube currency="DKK" rate="7.4510"/>
                        <Cube currency="GBP" rate="0.88440"/>
                        <Cube currency="HUF" rate="373.68"/>
                        <Cube currency="PLN" rate="4.6435"/>
                        <Cube currency="RON" rate="4.9423"/>
                        <Cube currency="SEK" rate="11.3455"/>
                        <Cube currency="CHF" rate="0.9827"/>
                        <Cube currency="ISK" rate="149.70"/>
                        <Cube currency="NOK" rate="11.4020"/>
                        <Cube currency="TRY" rate="21.4218"/>
                        <Cube currency="AUD" rate="1.6309"/>
                        <Cube currency="BRL" rate="5.4410"/>
                        <Cube currency="CAD" rate="1.4725"/>
                        <Cube currency="CNY" rate="7.5761"/>
                        <Cube currency="HKD" rate="8.6797"/>
                        <Cube currency="IDR" rate="16291.79"/>
                        <Cube currency="ILS" rate="4.0426"/>
                        <Cube currency="INR" rate="90.3595"/>
                        <Cube currency="KRW" rate="1438.43"/>
                        <Cube currency="MXN" rate="19.9598"/>
                        <Cube currency="MYR" rate="4.8673"/>
                        <Cube currency="NZD" rate="1.7588"/>
                        <Cube currency="PHP" rate="61.122"/>
                        <Cube currency="SGD" rate="1.4665"/>
                        <Cube currency="THB" rate="37.660"/>
                        <Cube currency="ZAR" rate="19.9352"/>
                    </Cube>
                </Cube>
            </gesmes:Envelope>
        XML;
        $rateServiceMock->shouldReceive('fetchRates')
            ->once()
            ->with('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
            ->andReturn($sampleXml);
        $service = new ExchangeRateConverterService($rateServiceMock);
        $result = $service->convert(10, 'JPY');
        $this->assertIsArray($result);
        $this->assertEquals(['amount' => '1466.00'], $result);
    }
}