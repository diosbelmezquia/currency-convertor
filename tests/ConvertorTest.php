<?php
namespace BaffourAdu\CurrencyConvertor\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use BaffourAdu\CurrencyConvertor\Convertor;

class ConvertorTest extends TestCase
{
    /** @test */
    public function it_returns_an_api_key()
    {
        $currencyConvertor = new Convertor('SomeApiKey');
    
        $apiKey = $currencyConvertor->getApiKey();
    
        $this->assertSame('SomeApiKey', $apiKey);
    }

    /** @test */
    public function it_returns_currencies_from_and_to()
    {
        $currencyConvertor = new Convertor('SomeApiKey');
        $conversion = $currencyConvertor->from('USD')
                                        ->to('GHS');

        $conversionCurrencies = $conversion->getCurrencies();
    
        $this->assertSame('USD_GHS', $conversionCurrencies);
    }

    /** @test */
    public function it_returns_an_amount()
    {
        $currencyConvertor = new Convertor('SomeApiKey');
        $conversion = $currencyConvertor->amount(2.00);
 
        $conversionAmount = $conversion->getAmount();
     
        $this->assertSame(2.00, $conversionAmount);
    }
        
    /** @test */
    public function it_returns_a_rate()
    {
        // Create a mock and queue a response.
        $mock = new MockHandler([
            new Response(200, [], '{"USD_GHS": 5.51805 }'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $currencyConvertor = new Convertor('SomeApiKey');
        $rate = $currencyConvertor->from('USD')
                                        ->to('GHS')
                                        ->getRate($client);
 
        $this->assertSame('5.52', $rate);
    }

    /** @test */
    public function it_returns_a_converted_amount()
    {

         // Create a mock and queue a response.
        $mock = new MockHandler([
            new Response(200, [], '{"USD_GHS": 5.51805 }'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $currencyConvertor = new Convertor('SomeApiKey');
        $convertedAmount = $currencyConvertor->from('USD')
                                        ->to('GHS')
                                        ->amount(3.00)
                                        ->convert($client);
 
        $this->assertSame('16.56', $convertedAmount);
    }
}
