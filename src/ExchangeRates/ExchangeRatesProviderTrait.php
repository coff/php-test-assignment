<?php

namespace Coff\TestAssignment\ExchangeRates;

use Coff\TestAssignment\Enum\CurrencyIso4217Enum;

trait ExchangeRatesProviderTrait
{
    protected $rates = [];

    /**
     * @return int
     * @throws \Exception
     */
    public function getRateByCurrency(CurrencyIso4217Enum $currency)
    {
        if (isset($this->rates[(string)$currency]) === false) {
            throw new \Exception('Currency not listed!');
        }
        return $this->rates[(string)$currency];
    }
}