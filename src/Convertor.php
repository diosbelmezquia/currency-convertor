<?php

namespace BaffourAdu\CurrencyConvertor;

use GuzzleHttp\Client;

class Convertor
{
    const BASE_URL = 'https://free.currconv.com';
    const RATE_ENDPOINT = '/api/v7/convert';

    /** @string Holds API key  */
    protected $apiKey;
    /** @string Holds currency from value */
    protected $currencyFrom;
    /** @string Holds currency to value */
    protected $currencyTo;
    /** @string Holds amount to convert */
    protected $amount;
    /** @object */
    protected $client;

    /**
     * Sets API Key for API call.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Sets caurrecy from value.
     *
     * @param string $currencyFrom
     * @return $this
     */
    public function from(string $currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;

        return $this;
    }

    /**
     * Sets Currency to value.
     *
     * @param string $currencyTo
     * @return $this
     */
    public function to(string $currencyTo)
    {
        $this->currencyTo = $currencyTo;

        return $this;
    }

    /**
     * Sets amount.
     *
     * @param float $amount
     * @return $this
     */
    public function amount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Returns a currency rate between currency from and to.
     *
     * @param client $client
     * @return string
     */
    public function getRate(Client $client = null)
    {
        $this->client = $client ?: new Client();

        $currencies = $this->getCurrencies();

        $queryParams = '?q='.$currencies.'&compact=ultra&apiKey='.$this->getApiKey();
        $endpoint = self::BASE_URL.self::RATE_ENDPOINT.$queryParams;

        $response = $this->client->get($endpoint);
        $rate = json_decode($response->getBody()->getContents());

        return number_format($rate->$currencies, 2, '.', '');
    }

    /**
     * Returns a converted amount using getRate and amount specified.
     *
     * @param client $client
     * @return string
     */
    public function convert(Client $client = null)
    {
        $convertedAmount = $this->amount * $this->getRate($client);

        return number_format($convertedAmount, 2, '.', '');
    }

    /**
     * Returns API Key.
     *
     * @return string $this->getApiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Returns Amount.
     *
     * @return float $this->amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns Currency From and To concatenated.
     *
     * @return float $this->amount
     */
    public function getCurrencies()
    {
        return $this->currencyFrom.'_'.$this->currencyTo;
    }
}
