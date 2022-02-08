<?php

namespace Coff\TestAssignment\RatesProvider;

use Coff\TestAssignment\Enum\CurrencyIso4217Enum;

class ExchangeRatesProvider implements RatesProviderInterface
{
    use RatesProviderTrait;

    protected $url = 'http://api.exchangeratesapi.io/v1/latest?access_key=53f96d003916a2287b70c9c9251de8dd';

    /**
     * In case we had to switch to another currency exchange rates provider we just add another class implementing
     * RatesProviderInterface and add authentication via proper setters called on bootstrap
     */

    /**
     *
     * @return $this
     */
    public function fetch() : self
    {
        $data = file_get_contents($this->url);

        $data = json_decode($data);

        foreach ($data->rates as $rateKey => $rateValue) {
            $this->rates[$rateKey] = $rateValue;
        }
        return $this;
    }
}