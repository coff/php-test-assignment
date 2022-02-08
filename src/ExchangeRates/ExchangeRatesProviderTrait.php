<?php

namespace Coff\TestAssignment\RatesProvider;

use Coff\TestAssignment\Enum\CurrencyIso4217Enum;

trait RatesProviderTrait
{
    protected $rates = [];

    /**
     * @return int
     * @throws \Exception
     */
    public function getRateByCurrency(CurrencyIso4217Enum $currency)
    {
        if (false === isset($this->rates[(string)$currency])) {
            throw new \Exception('Currency unlisted!');
        }
        return $this->rates[(string)$currency];
    }
}