# Currency Convertor

A php library for https://free.currencyconverterapi.com/ that allows you to;
 - Convert an amount from one currency to another
 - Get the exchange rate between two currencies

## More About Currency Converter API
Free Currency Converter API started in year 2014, it's now 2019 and we're up ever since. It offers free web services for developers to convert one currency to another. You are free to use this for personal or commercial application however it offers no warranty. Currency values are updated every 60 minutes.

## Installation
Require the package using composer.

```bash
composer require baffouradu/currency-convertor
```

## Usage

```php
<?php

use BaffourAdu\CurrencyConvertor\Convertor;

require 'vendor/autoload.php';

//Insert your free api key generatored from https://free.currencyconverterapi.com/free-api-key
$currencyConvertor = new Convertor('xxxxxxxxxxxxxxxxxxxxxx');

/**
 * Get the exchange rate between two currencies
*/
echo $currencyConvertor->from('CAD')
                    ->to('GHS')
                    ->getRate();

/**
 * Convert an amount from one currency to another
*/
echo $res = $currencyConvertor->from('CAD')
                    ->to('GHS')
                    ->amount(150.00)
                    ->convert();

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](./LICENSE.md)