<?php

namespace Coff\TestAssignment\ExchangeRates;

use Coff\TestAssignment\Enum\CurrencyIso4217Enum;

interface ExchangeRatesProviderInterface
{
    /**
     * @return $this
     */
    public function fetch() : self;

    /**
     * @param CurrencyIso4217Enum $currency
     * @return int
     * @throws \Exception
     */
    public function getRateByCurrency(CurrencyIso4217Enum $currency);
}