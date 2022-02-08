<?php

namespace Coff\TestAssignment\CountryProvider;

use Coff\TestAssignment\Enum\CountryIso3166Aplha2Enum;

interface CountryProviderInterface
{
    /**
     * @param string $bin
     * @return $this
     */
    public function setBin($bin) : self;

    /**
     * @return $this
     * @throws \Exception when fetch failed
     */
    public function fetch() : self;

    /**
     * Intentionally small interface with only required functionality
     * @return CountryIso3166Aplha2Enum
     */
    public function getCountry() : CountryIso3166Aplha2Enum;
}