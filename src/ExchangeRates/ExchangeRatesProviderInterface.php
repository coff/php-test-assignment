<?php

namespace Coff\TestAssignment\RatesProvider;

use Coff\TestAssignment\Enum\CurrencyIso4217Enum;

interface RatesProviderInterface
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