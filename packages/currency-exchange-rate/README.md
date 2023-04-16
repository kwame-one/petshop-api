## Currency Exchange Rate For Laravel

---

### Installation
```shell
composer require kwame/currency-exchange-rate:dev-main
```

### Using

---
You can make a direct request to an endpoint exposed by the package
```shell
curl  http://localhost:8000/api/currency-converter/{currency}/{amount}
```

or use the facade
```php
use Kwame\CurrencyExchangeRate\Facades\ExchangeRateConverter;

return ExchangeRateConverter::convert($amount, $currency)
```

Replace amount with your value. Below are the available currencies
- USD
- JPY 
- BGN
- CZK
- DKK 
- GBP
- HUF 
- PLN 
- RON
- SEK
- CHF
- ISK
- NOK
- TRY
- AUD
- BRL
- CAD
- CNY
- HKD
- IDR
- ILS
- INR
- KRW
- MXN
- MYR
- NZD
- PHP
- SGD
- THB
- ZAR

---

### Tests
Run the command below in the package root's directory to run all tests
```shell
vendor/bin/phpunit
```