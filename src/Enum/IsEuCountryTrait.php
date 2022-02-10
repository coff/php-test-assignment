<?php

namespace Coff\TestAssignment\Enum;

trait IsEuCountryTrait
{
    /**
     * Statically defined list but shouldn't we think of some other solution in case of another "Brexit"??
     * @var array<int,CountryIso3166Aplha2Enum>
     */
    protected static $euCountries = [
        CountryIso3166Aplha2Enum::AUSTRIA,
        CountryIso3166Aplha2Enum::BELGIUM,
        CountryIso3166Aplha2Enum::BULGARIA,
        CountryIso3166Aplha2Enum::CYPRUS,
        CountryIso3166Aplha2Enum::CZECHIA,
        CountryIso3166Aplha2Enum::DENMARK,
        CountryIso3166Aplha2Enum::GERMANY,
        CountryIso3166Aplha2Enum::ESTONIA,
        CountryIso3166Aplha2Enum::SPAIN,
        CountryIso3166Aplha2Enum::FINLAND,
        CountryIso3166Aplha2Enum::FRANCE,
        CountryIso3166Aplha2Enum::GREECE,
        CountryIso3166Aplha2Enum::CROATIA,
        CountryIso3166Aplha2Enum::HUNGARY,
        CountryIso3166Aplha2Enum::IRELAND,
        CountryIso3166Aplha2Enum::ITALY,
        CountryIso3166Aplha2Enum::LITHUANIA,
        CountryIso3166Aplha2Enum::LUXEMBOURG,
        CountryIso3166Aplha2Enum::LATVIA,
        CountryIso3166Aplha2Enum::MALTA,
        CountryIso3166Aplha2Enum::NETHERLANDS,
        CountryIso3166Aplha2Enum::POLAND,
        CountryIso3166Aplha2Enum::PORTUGAL,
        CountryIso3166Aplha2Enum::ROMANIA,
        CountryIso3166Aplha2Enum::SWEDEN,
        CountryIso3166Aplha2Enum::SLOVENIA,
        CountryIso3166Aplha2Enum::SLOVAKIA,
    ];

    /**
     * @param CountryIso3166Aplha2Enum $country
     * @return bool
     */
    public function isEuCountry() : bool
    {
        return in_array((string)$this, self::$euCountries, true);
    }
}