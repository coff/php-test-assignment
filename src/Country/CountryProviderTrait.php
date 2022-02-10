<?php

namespace Coff\TestAssignment\Country;

use Coff\TestAssignment\Enum\CountryIso3166Aplha2Enum;

trait CountryProviderTrait
{
    /** @var CountryIso3166Aplha2Enum */
    protected $country;

    /** @var string */
    protected $bin;

    /**
     * Default setter for bin number
     * @param int $bin
     * @return self
     */
    public function setBin($bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * Returns Country based on bin number
     * @return CountryIso3166Aplha2Enum
     */
    public function getCountry(): CountryIso3166Aplha2Enum
    {
        return $this->country;
    }
}